@extends('layouts.frontend')

@section('content')
<!--==================== AI GUIDE PAGE ====================-->
<section class="aig__hero">
    <div class="aig__hero-orbs">
        <div class="aig__orb aig__orb--1"></div>
        <div class="aig__orb aig__orb--2"></div>
        <div class="aig__orb aig__orb--3"></div>
    </div>
    <div class="aig__hero-content container">
        <div class="aig__hero-badge">
            <i class="bx bx-bot"></i>
            <span>AI-Powered</span>
        </div>
        <h1 class="aig__hero-title">Let's See Lanka <span>AI Guide</span></h1>
        <p class="aig__hero-subtitle">Your intelligent companion for discovering Sri Lanka's traditional industries, cultural heritage, and authentic artisan experiences.</p>
        <div class="aig__features">
            <div class="aig__feature-pill"><i class="bx bx-map-pin"></i> Personalized Recommendations</div>
            <div class="aig__feature-pill"><i class="bx bx-book-open"></i> Cultural Knowledge</div>
            <div class="aig__feature-pill"><i class="bx bx-globe"></i> Multilingual Support</div>
            <div class="aig__feature-pill"><i class="bx bx-time-five"></i> 24/7 Available</div>
        </div>
    </div>
</section>

<!--==================== CHAT INTERFACE ====================-->
<section class="aig__chat-section section">
    <div class="aig__chat-wrapper container">

        <!-- Chat Window -->
        <div class="aig__chat-window" id="aig-chat-window">

            <!-- Welcome Message -->
            <div class="aig__message aig__message--bot" id="aig-welcome">
                <div class="aig__avatar">
                    <i class="bx bx-bot"></i>
                </div>
                <div class="aig__bubble aig__bubble--bot">
                    <div class="aig__bubble-header">
                        <span class="aig__bot-name">Lanka AI Guide</span>
                        <span class="aig__bubble-time" data-time="now"></span>
                    </div>
                    <div class="aig__bubble-content">
                        <p>🌿 <strong>Ayubowan!</strong> Welcome to the Let's See Lanka AI Guide.</p>
                        <p style="margin-top: 0.5rem;">I'm your intelligent tourism companion, specialized in Sri Lanka's rich traditional industries — from handloom weaving and pottery to batik, mask making, and Ayurveda.</p>
                        <p style="margin-top: 0.5rem;">Tell me about your interests or travel plans, and I'll recommend the perfect cultural experiences for you!</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Suggestion Chips -->
        <div class="aig__suggestions" id="aig-suggestions">
            <p class="aig__suggestions-label">Try asking:</p>
            <div class="aig__chips">
                <button class="aig__chip" data-prompt="I like traditional crafts and photography. What places should I visit?">
                    <i class="bx bx-camera"></i> Photography & Crafts
                </button>
                <button class="aig__chip" data-prompt="I am a student researching handloom weaving in Sri Lanka.">
                    <i class="bx bx-book"></i> Handloom Research
                </button>
                <button class="aig__chip" data-prompt="Create a one-day cultural industry tour itinerary for me.">
                    <i class="bx bx-map"></i> One-Day Cultural Tour
                </button>
                <button class="aig__chip" data-prompt="What traditional industries are good for families with children?">
                    <i class="bx bx-group"></i> Family-Friendly Visits
                </button>
                <button class="aig__chip" data-prompt="Tell me about Sri Lanka's traditional batik and mask making.">
                    <i class="bx bx-palette"></i> Batik & Mask Making
                </button>
                <button class="aig__chip" data-prompt="I am interested in Ayurveda and traditional medicine.">
                    <i class="bx bx-leaf"></i> Ayurveda & Wellness
                </button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="aig__input-area">
            <div class="aig__input-box">
                <button class="aig__emoji-btn" id="aig-clear-btn" title="Clear conversation">
                    <i class="bx bx-trash"></i>
                </button>
                <textarea
                    id="aig-input"
                    class="aig__textarea"
                    placeholder="Ask about traditional industries, cultural tours, artisan workshops..."
                    rows="1"
                    maxlength="1000"
                ></textarea>
                <button class="aig__send-btn" id="aig-send-btn" title="Send message">
                    <i class="bx bx-send"></i>
                </button>
            </div>
            <p class="aig__disclaimer">
                <i class="bx bx-info-circle"></i>
                Responses are AI-generated based on platform data. Always verify details before visiting.
            </p>
        </div>

    </div>
</section>
@endsection

@push('style-alt')
<style>
/* ===================================================
   AI GUIDE — PAGE STYLES
=================================================== */

/* ── Hero Section ── */
.aig__hero {
    position: relative;
    background: linear-gradient(135deg, hsl(228, 66%, 22%) 0%, hsl(228, 66%, 38%) 50%, hsl(25, 83%, 35%) 100%);
    padding: 6rem 0 3.5rem;
    overflow: hidden;
    min-height: 340px;
    display: flex;
    align-items: center;
}

.aig__hero-orbs {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.aig__orb {
    position: absolute;
    border-radius: 50%;
    opacity: 0.12;
    animation: aig-float 8s ease-in-out infinite;
}

.aig__orb--1 {
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, hsl(228, 100%, 80%), transparent);
    top: -80px;
    right: 5%;
    animation-delay: 0s;
}

.aig__orb--2 {
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, hsl(25, 83%, 70%), transparent);
    bottom: -60px;
    left: 10%;
    animation-delay: 3s;
}

.aig__orb--3 {
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, hsl(180, 60%, 70%), transparent);
    top: 40%;
    left: 40%;
    animation-delay: 6s;
}

@keyframes aig-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}

.aig__hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.aig__hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    padding: 0.35rem 1rem;
    border-radius: 2rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
}

.aig__hero-badge i {
    font-size: 1rem;
}

.aig__hero-title {
    color: #fff;
    font-size: clamp(1.6rem, 5vw, 2.8rem);
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 0.85rem;
}

.aig__hero-title span {
    color: hsl(25, 90%, 70%);
}

.aig__hero-subtitle {
    color: rgba(255,255,255,0.82);
    font-size: 0.95rem;
    max-width: 600px;
    margin: 0 auto 2rem;
    line-height: 1.7;
}

.aig__features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    justify-content: center;
}

.aig__feature-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: rgba(255,255,255,0.13);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.9);
    padding: 0.4rem 0.9rem;
    border-radius: 2rem;
    font-size: 0.78rem;
    font-weight: 500;
    transition: background 0.3s;
}

.aig__feature-pill i { font-size: 0.9rem; }

/* ── Chat Section ── */
.aig__chat-section {
    background: var(--body-color);
    padding-top: 2rem;
    padding-bottom: 3rem;
}

.aig__chat-wrapper {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 800px;
}

/* ── Chat Window ── */
.aig__chat-window {
    background: var(--container-color);
    border: 1.5px solid var(--border-color);
    border-radius: 1.25rem;
    padding: 1.5rem 1.25rem;
    min-height: 420px;
    max-height: 520px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    scroll-behavior: smooth;
    box-shadow: 0 4px 24px rgba(39,69,190,0.06);
}

/* custom scrollbar */
.aig__chat-window::-webkit-scrollbar { width: 5px; }
.aig__chat-window::-webkit-scrollbar-track { background: transparent; }
.aig__chat-window::-webkit-scrollbar-thumb { background: var(--text-color-light); border-radius: 10px; }

/* ── Messages ── */
.aig__message {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    animation: aig-slide-in 0.35s ease forwards;
}

@keyframes aig-slide-in {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.aig__message--user {
    flex-direction: row-reverse;
}

.aig__avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
    font-size: 1.2rem;
    box-shadow: 0 3px 8px rgba(39,69,190,0.25);
}

.aig__avatar--user {
    background: linear-gradient(135deg, var(--second-color), hsl(25, 83%, 40%));
    box-shadow: 0 3px 8px rgba(200,100,30,0.25);
}

.aig__bubble {
    max-width: 80%;
    border-radius: 1.25rem;
    padding: 0.85rem 1.1rem;
    position: relative;
}

.aig__bubble--bot {
    background: var(--first-color-lighten);
    border-top-left-radius: 0.2rem;
    color: var(--title-color);
}

.aig__bubble--user {
    background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
    border-top-right-radius: 0.2rem;
    color: #fff;
}

.aig__bubble-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.4rem;
}

.aig__bot-name {
    font-weight: 600;
    font-size: 0.78rem;
    color: var(--first-color);
}

.aig__bubble-time {
    font-size: 0.68rem;
    color: var(--text-color-light);
}

.aig__bubble-content {
    font-size: 0.875rem;
    line-height: 1.65;
    color: inherit;
}

.aig__bubble-content p { margin-bottom: 0; }
.aig__bubble-content strong { font-weight: 600; }

/* Formatted AI response */
.aig__bubble-content .aig-formatted ol,
.aig__bubble-content .aig-formatted ul {
    padding-left: 1.2rem;
    margin: 0.4rem 0;
}

.aig__bubble-content .aig-formatted ol { list-style: decimal; }
.aig__bubble-content .aig-formatted ul { list-style: disc; }

.aig__bubble-content .aig-formatted li { margin-bottom: 0.3rem; }
.aig__bubble-content .aig-formatted h3,
.aig__bubble-content .aig-formatted h4 {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0.6rem 0 0.2rem;
    color: var(--title-color);
}

/* ── Typing indicator ── */
.aig__typing {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: aig-slide-in 0.35s ease forwards;
}

.aig__typing-dots {
    background: var(--first-color-lighten);
    border-radius: 1.25rem;
    border-top-left-radius: 0.2rem;
    padding: 0.7rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.aig__typing-dots span {
    width: 7px;
    height: 7px;
    background: var(--first-color);
    border-radius: 50%;
    animation: aig-dot-bounce 1.2s infinite;
}

.aig__typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.aig__typing-dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes aig-dot-bounce {
    0%, 80%, 100% { transform: translateY(0); opacity: 0.5; }
    40% { transform: translateY(-6px); opacity: 1; }
}

/* ── Suggestions ── */
.aig__suggestions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.aig__suggestions-label {
    font-size: 0.78rem;
    color: var(--text-color-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.aig__chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.55rem;
}

.aig__chip {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--container-color);
    border: 1.5px solid var(--border-color);
    color: var(--text-color);
    padding: 0.45rem 0.9rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s;
}

.aig__chip:hover {
    background: var(--first-color);
    border-color: var(--first-color);
    color: #fff;
    box-shadow: 0 4px 10px rgba(39,69,190,0.2);
    transform: translateY(-2px);
}

.aig__chip i { font-size: 0.9rem; }

/* ── Input area ── */
.aig__input-area {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.aig__input-box {
    display: flex;
    align-items: flex-end;
    gap: 0.5rem;
    background: var(--container-color);
    border: 1.5px solid var(--border-color);
    border-radius: 1rem;
    padding: 0.6rem 0.75rem;
    transition: border-color 0.25s, box-shadow 0.25s;
}

.aig__input-box:focus-within {
    border-color: var(--first-color);
    box-shadow: 0 0 0 3px rgba(56, 88, 214, 0.12);
}

.aig__textarea {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font-family: 'Poppins', sans-serif;
    font-size: 0.875rem;
    color: var(--title-color);
    resize: none;
    line-height: 1.5;
    max-height: 150px;
    overflow-y: auto;
    padding: 0.1rem 0;
}

.aig__textarea::placeholder { color: var(--text-color-light); }

.aig__emoji-btn,
.aig__send-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s;
    flex-shrink: 0;
    font-size: 1.15rem;
}

.aig__emoji-btn {
    background: var(--first-color-lighten);
    color: var(--text-color);
}

.aig__emoji-btn:hover {
    background: #fee2e2;
    color: #dc2626;
}

.aig__send-btn {
    background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
    color: #fff;
    box-shadow: 0 3px 8px rgba(39,69,190,0.25);
}

.aig__send-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 5px 14px rgba(39,69,190,0.35);
}

.aig__send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.aig__disclaimer {
    font-size: 0.72rem;
    color: var(--text-color-light);
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0 0.25rem;
}

/* ── Dark theme overrides ── */
body.dark-theme .aig__hero {
    background: linear-gradient(135deg, hsl(228, 40%, 12%) 0%, hsl(228, 50%, 22%) 50%, hsl(25, 50%, 20%) 100%);
}

body.dark-theme .aig__bubble--bot {
    background: hsl(228, 20%, 16%);
    color: var(--text-color);
}

body.dark-theme .aig__typing-dots {
    background: hsl(228, 20%, 16%);
}

body.dark-theme .aig__chip {
    background: hsl(228, 16%, 14%);
    border-color: hsl(228, 16%, 20%);
    color: var(--text-color);
}

body.dark-theme .aig__chat-window,
body.dark-theme .aig__input-box {
    box-shadow: none;
}

body.dark-theme .aig__bubble-content .aig-formatted h3,
body.dark-theme .aig__bubble-content .aig-formatted h4 {
    color: var(--title-color);
}

/* ── Responsive ── */
@media screen and (max-width: 480px) {
    .aig__bubble { max-width: 92%; }
    .aig__hero { padding: 7rem 0 2.5rem; }
    .aig__hero-title { font-size: 1.45rem; }
    .aig__chat-window { min-height: 340px; max-height: 400px; }
}

@media screen and (min-width: 1024px) {
    .aig__chat-wrapper { margin: 0 auto; }
}
</style>
@endpush

@push('script-alt')
<script>
(function () {
    // ── State ─────────────────────────────────────────────────────────
    const chatWindow   = document.getElementById('aig-chat-window');
    const inputEl      = document.getElementById('aig-input');
    const sendBtn      = document.getElementById('aig-send-btn');
    const clearBtn     = document.getElementById('aig-clear-btn');
    const suggestions  = document.getElementById('aig-suggestions');
    const chips        = document.querySelectorAll('.aig__chip');
    let   history      = [];   // { role, content }[]
    let   isLoading    = false;

    // ── Init timestamps ───────────────────────────────────────────────
    document.querySelectorAll('[data-time="now"]').forEach(el => {
        el.textContent = currentTime();
    });

    // ── Auto-resize textarea ──────────────────────────────────────────
    inputEl.addEventListener('input', () => {
        inputEl.style.height = 'auto';
        inputEl.style.height = Math.min(inputEl.scrollHeight, 150) + 'px';
    });

    // ── Send on Enter (Shift+Enter = newline) ─────────────────────────
    inputEl.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);

    // ── Quick-prompt chips ────────────────────────────────────────────
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            const prompt = chip.getAttribute('data-prompt');
            inputEl.value = prompt;
            inputEl.style.height = 'auto';
            inputEl.style.height = Math.min(inputEl.scrollHeight, 150) + 'px';
            sendMessage();
        });
    });

    // ── Clear conversation ────────────────────────────────────────────
    clearBtn.addEventListener('click', () => {
        if (!confirm('Clear the entire conversation?')) return;
        // Remove all messages except welcome
        const welcome = document.getElementById('aig-welcome');
        chatWindow.innerHTML = '';
        if (welcome) chatWindow.appendChild(welcome);
        history = [];
        suggestions.style.display = 'flex';
    });

    // ── Main send function ────────────────────────────────────────────
    function sendMessage() {
        const msg = inputEl.value.trim();
        if (!msg || isLoading) return;

        // Hide suggestion chips after first message
        suggestions.style.display = 'none';

        // Append user bubble
        appendMessage('user', msg);
        history.push({ role: 'user', content: msg });

        // Clear input
        inputEl.value = '';
        inputEl.style.height = 'auto';

        // Show typing indicator
        const typingEl = showTyping();
        isLoading = true;
        sendBtn.disabled = true;

        // POST to backend
        fetch('{{ route("ai_guide.chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: msg, history: history.slice(-10) }),
        })
        .then(res => res.json())
        .then(data => {
            removeTyping(typingEl);
            const reply = data.reply || 'Sorry, I could not process your request. Please try again.';
            appendMessage('bot', reply);
            history.push({ role: 'assistant', content: reply });
        })
        .catch(() => {
            removeTyping(typingEl);
            appendMessage('bot', '⚠️ A connection error occurred. Please check your internet connection and try again.');
        })
        .finally(() => {
            isLoading = false;
            sendBtn.disabled = false;
            inputEl.focus();
        });
    }

    // ── Append a message bubble ───────────────────────────────────────
    function appendMessage(role, text) {
        const isBot = role === 'bot';
        const wrapper = document.createElement('div');
        wrapper.className = `aig__message${isBot ? ' aig__message--bot' : ' aig__message--user'}`;

        const avatar = document.createElement('div');
        avatar.className = `aig__avatar${isBot ? '' : ' aig__avatar--user'}`;
        avatar.innerHTML = isBot
            ? '<i class="bx bx-bot"></i>'
            : '<i class="bx bx-user"></i>';

        const bubble = document.createElement('div');
        bubble.className = `aig__bubble${isBot ? ' aig__bubble--bot' : ' aig__bubble--user'}`;

        if (isBot) {
            const header = document.createElement('div');
            header.className = 'aig__bubble-header';
            header.innerHTML = `<span class="aig__bot-name">Lanka AI Guide</span><span class="aig__bubble-time">${currentTime()}</span>`;
            bubble.appendChild(header);
        }

        const content = document.createElement('div');
        content.className = 'aig__bubble-content';

        if (isBot) {
            content.innerHTML = `<div class="aig-formatted">${formatMarkdown(text)}</div>`;
        } else {
            content.textContent = text;
        }

        bubble.appendChild(content);
        wrapper.appendChild(avatar);
        wrapper.appendChild(bubble);
        chatWindow.appendChild(wrapper);
        scrollToBottom();
    }

    // ── Typing indicator ──────────────────────────────────────────────
    function showTyping() {
        const wrapper = document.createElement('div');
        wrapper.className = 'aig__typing';
        wrapper.innerHTML = `
            <div class="aig__avatar"><i class="bx bx-bot"></i></div>
            <div class="aig__typing-dots">
                <span></span><span></span><span></span>
            </div>`;
        chatWindow.appendChild(wrapper);
        scrollToBottom();
        return wrapper;
    }

    function removeTyping(el) {
        if (el && el.parentNode) el.parentNode.removeChild(el);
    }

    // ── Helpers ───────────────────────────────────────────────────────
    function scrollToBottom() {
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    function currentTime() {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    /**
     * Minimal markdown-to-HTML converter for AI responses.
     * Handles: **bold**, *italic*, numbered lists, bullet lists, headings (###, ####).
     */
    function formatMarkdown(text) {
        // Escape HTML first
        const escHtml = str => str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        let escaped = escHtml(text);

        // Headings
        escaped = escaped.replace(/^#### (.+)$/gm, '<h4>$1</h4>');
        escaped = escaped.replace(/^### (.+)$/gm, '<h3>$1</h3>');

        // Bold / italic
        escaped = escaped.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
        escaped = escaped.replace(/\*(.+?)\*/g, '<em>$1</em>');

        // Numbered lists — convert blocks of "1. item\n2. item" into <ol>
        escaped = escaped.replace(/((?:^\d+\. .+\n?)+)/gm, (block) => {
            const items = block.trim().split('\n').map(line =>
                `<li>${line.replace(/^\d+\.\s*/, '')}</li>`
            ).join('');
            return `<ol>${items}</ol>`;
        });

        // Bullet lists
        escaped = escaped.replace(/((?:^[-*•] .+\n?)+)/gm, (block) => {
            const items = block.trim().split('\n').map(line =>
                `<li>${line.replace(/^[-*•]\s*/, '')}</li>`
            ).join('');
            return `<ul>${items}</ul>`;
        });

        // Paragraphs — split by blank lines
        const paras = escaped.split(/\n{2,}/);
        return paras.map(p => {
            p = p.trim();
            if (!p) return '';
            // Don't wrap block elements
            if (/^<(ol|ul|h[1-6])/.test(p)) return p;
            // Replace single newlines with <br>
            return '<p>' + p.replace(/\n/g, '<br>') + '</p>';
        }).filter(Boolean).join('');
    }

})();
</script>
@endpush
