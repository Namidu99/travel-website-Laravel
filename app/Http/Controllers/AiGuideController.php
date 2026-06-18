<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TravelPackage;

class AiGuideController extends Controller
{
    /**
     * Show the AI Guide chat page.
     */
    public function index()
    {
        return view('ai_guide');
    }

    /**
     * Handle a chat message, inject DB context, and call OpenRouter AI.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'in:user,assistant',
            'history.*.content' => 'string|max:2000',
        ]);

        $userMessage = trim($request->input('message'));
        $history     = $request->input('history', []);

        // ── 1. Search travel_packages for relevant context ──────────────────
        $keywords = $this->extractKeywords($userMessage);
        $industries = $this->searchIndustries($keywords, $userMessage);
        $context   = $this->buildContext($industries);

        // ── 2. Build system prompt ───────────────────────────────────────────
        $systemPrompt = $this->buildSystemPrompt($context);

        // ── 3. Build messages array for OpenRouter ───────────────────────────
        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        // Append prior conversation turns (max last 10 to stay within token limits)
        $recentHistory = array_slice($history, -10);
        foreach ($recentHistory as $turn) {
            if (isset($turn['role'], $turn['content'])) {
                $messages[] = [
                    'role'    => $turn['role'],
                    'content' => $turn['content'],
                ];
            }
        }

        // Append current user message
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // ── 4. Call OpenRouter API ───────────────────────────────────────────
        $apiKey = env('OPENROUTER_API_KEY', '');
        $model  = env('OPENROUTER_MODEL', 'google/gemini-2.5-flash');

        if (empty($apiKey)) {
            return response()->json([
                'reply' => "⚠️ The AI Guide is not yet configured. Please add your OpenRouter API key to the application's `.env` file under `OPENROUTER_API_KEY` to enable AI responses.",
            ]);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer'  => config('app.url', 'http://localhost'),
                'X-Title'       => "Let's See Lanka AI Guide",
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model'       => $model,
                'messages'    => $messages,
                'max_tokens'  => 800,
                'temperature' => 0.7,
            ]);

            if ($response->failed()) {
                $errBody = $response->json();
                $errMsg  = $errBody['error']['message'] ?? 'Unknown API error.';
                return response()->json([
                    'reply' => "I'm sorry, I encountered an issue communicating with the AI service: {$errMsg}",
                ], 200);
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response. Please try again.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'I apologize — a network error occurred. Please check your internet connection and try again.',
            ], 200);
        }
    }

    /**
     * Extract search keywords from the user's message.
     */
    private function extractKeywords(string $message): array
    {
        // Industry category keywords
        $categoryMap = [
            'handloom'   => ['handloom', 'weaving', 'weave', 'textile', 'fabric', 'loom'],
            'pottery'    => ['pottery', 'ceramic', 'clay', 'pot'],
            'batik'      => ['batik', 'fabric', 'dye', 'print'],
            'carving'    => ['carving', 'wood', 'wooden', 'craft', 'sculpture'],
            'brass'      => ['brass', 'brassware', 'metal', 'bronze'],
            'mask'       => ['mask', 'masks', 'kolam', 'ambalangoda'],
            'ayurveda'   => ['ayurveda', 'herbal', 'medicine', 'spa', 'wellness'],
            'lacquer'    => ['lacquer', 'lacquerwork', 'lacquered'],
            'art'        => ['art', 'artistic', 'painting', 'creative'],
            'photography'=> ['photography', 'photo', 'camera', 'photographer'],
            'family'     => ['family', 'children', 'kids', 'child'],
            'research'   => ['research', 'study', 'student', 'academic', 'university'],
            'cultural'   => ['culture', 'cultural', 'heritage', 'tradition', 'traditional', 'history', 'historical'],
            'tour'       => ['tour', 'visit', 'trip', 'travel', 'journey', 'itinerary'],
            'kandy'      => ['kandy', 'dumbara'],
            'galle'      => ['galle', 'southern'],
            'colombo'    => ['colombo'],
            'matara'     => ['matara'],
            'gampaha'    => ['gampaha'],
        ];

        $msgLower  = strtolower($message);
        $found     = [];

        foreach ($categoryMap as $category => $words) {
            foreach ($words as $word) {
                if (str_contains($msgLower, $word)) {
                    $found[] = $category;
                    break;
                }
            }
        }

        return array_unique($found);
    }

    /**
     * Search the travel_packages table for relevant industries.
     */
    private function searchIndustries(array $keywords, string $rawMessage): \Illuminate\Database\Eloquent\Collection
    {
        $query = TravelPackage::with('category');

        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords, $rawMessage) {
                // Search by matched keyword categories
                foreach ($keywords as $kw) {
                    $q->orWhere('name', 'LIKE', "%{$kw}%")
                      ->orWhere('district', 'LIKE', "%{$kw}%")
                      ->orWhere('best_for', 'LIKE', "%{$kw}%")
                      ->orWhere('description', 'LIKE', "%{$kw}%");
                }

                // Also do a broad search against raw words in the message
                $words = preg_split('/\s+/', strtolower($rawMessage));
                $stopWords = ['i', 'a', 'an', 'the', 'is', 'are', 'and', 'or', 'to', 'in', 'of', 'for', 'me', 'my', 'we', 'you', 'it', 'at'];
                foreach ($words as $word) {
                    $word = preg_replace('/[^a-z]/', '', $word);
                    if (strlen($word) > 3 && !in_array($word, $stopWords)) {
                        $q->orWhere('name', 'LIKE', "%{$word}%")
                          ->orWhere('district', 'LIKE', "%{$word}%")
                          ->orWhere('best_for', 'LIKE', "%{$word}%")
                          ->orWhere('description', 'LIKE', "%{$word}%");
                    }
                }
            });
        }

        // Also search the related category name via a join
        if (!empty($keywords)) {
            $query->orWhereHas('category', function ($q) use ($keywords) {
                foreach ($keywords as $kw) {
                    $q->orWhere('name', 'LIKE', "%{$kw}%");
                }
            });
        }

        // Limit to a reasonable number to keep token count manageable
        return $query->limit(8)->get();
    }

    /**
     * Build the context string from industry records.
     */
    private function buildContext(\Illuminate\Database\Eloquent\Collection $industries): string
    {
        if ($industries->isEmpty()) {
            // Fall back to all industries for general queries
            $industries = TravelPackage::with('category')->limit(6)->get();
        }

        if ($industries->isEmpty()) {
            return "No industry records are currently available in the platform database.";
        }

        $lines = ["=== Available Traditional Industries (from Let's See Lanka Database) ===\n"];

        foreach ($industries as $industry) {
            $lines[] = "---";
            $lines[] = "Name: {$industry->name}";
            $lines[] = "Category: " . ($industry->category->name ?? 'N/A');
            $lines[] = "District: {$industry->district}";
            if ($industry->best_for) {
                $lines[] = "Best For: {$industry->best_for}";
            }
            $lines[] = "Price/Entry: \${$industry->price}";
            $desc = strip_tags($industry->description ?? '');
            if ($desc) {
                $lines[] = "Description: " . substr($desc, 0, 400);
            }
            $lines[] = "";
        }

        return implode("\n", $lines);
    }

    /**
     * Build the master system prompt with injected context.
     */
    private function buildSystemPrompt(string $context): string
    {
        return <<<PROMPT
You are "Let's See Lanka AI Guide", the official intelligent tourism and cultural assistant for the Let's See Lanka platform — a dedicated platform for promoting Sri Lanka's traditional industries and cultural heritage.

Your mission is to help visitors discover, understand, and experience Sri Lanka's traditional industries.

You have access to the following information from the Let's See Lanka platform database:

{$context}

RESPONSIBILITIES:
1. Recommend suitable traditional industries based on visitor preferences and interests.
2. Explain the cultural significance and historical background of industries.
3. Provide information about products, workshops, demonstrations, and artisan communities.
4. Assist students and researchers with educational information.
5. Help tourists plan visits to traditional industries.
6. Suggest nearby or related traditional industries when relevant.
7. Encourage cultural preservation and appreciation of local artisans.

SUPPORTED INDUSTRY CATEGORIES:
Handloom Weaving, Pottery, Batik, Wood Carving, Brassware, Ayurveda, Mask Making, Lacquerwork, Traditional Food Production, and other Sri Lankan traditional industries.

RESPONSE RULES:
- Always prioritize and reference the database information provided above.
- Never invent contact details, specific prices, or visiting hours not in the database.
- If specific information is unavailable, clearly say it is not currently listed on Let's See Lanka.
- Explain why recommendations match the visitor's interests.
- Be friendly, warm, professional, and culturally respectful.
- Support multilingual conversations — reply in the same language the visitor uses.
- Keep answers informative but concise (avoid very long walls of text).
- Use numbered lists or bullet points when recommending multiple places.
- Promote authentic and responsible cultural tourism.
- Encourage visitors to support local artisans and rural communities.

When giving recommendations:
1. Understand the user's interests first.
2. Identify matching industries from the database.
3. Explain why each recommendation matches their interests.
4. Highlight the cultural importance and unique experiences available.
5. Suggest a visit itinerary or nearby options when helpful.

Your ultimate goal is to connect visitors with authentic Sri Lankan traditional industries while supporting cultural preservation, education, tourism, and artisan livelihoods.
PROMPT;
    }
}
