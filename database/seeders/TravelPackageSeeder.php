<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TravelPackageSeeder extends Seeder
{
    /**
     * Update existing travel_packages records with correct name, district,
     * category_id, and best_for values aligned with the AI chatbot data.
     */
    public function run(): void
    {
        // Helper to get category id by name
        $categoryId = fn(string $name) => DB::table('categories')
            ->where('name', $name)
            ->value('id');

        // ── Update existing record: Batik (id=1) ───────────────────────────
        DB::table('travel_packages')->where('id', 1)->update([
            'name'        => 'Sri Lankan Batik Centre',
            'district'    => 'Kandy',
            'slug'        => Str::slug('Sri Lankan Batik Centre'),
            'category_id' => $categoryId('Batik'),
            'best_for'    => 'Photography, Tourists, Art Lovers',
            'updated_at'  => now(),
        ]);

        // ── Update existing record: Ambalangoda Mask Industry (id=2) ───────
        DB::table('travel_packages')->where('id', 2)->update([
            'name'        => 'Ambalangoda Mask Industry',
            'district'    => 'Galle',
            'slug'        => Str::slug('Ambalangoda Mask Industry'),
            'category_id' => $categoryId('Mask Making'),
            'best_for'    => 'Photography, Tourists',
            'updated_at'  => now(),
        ]);

        // ── Update existing record: Dumbara Handloom Centre (id=5) ─────────
        DB::table('travel_packages')->where('id', 5)->update([
            'name'        => 'Dumbara Handloom Centre',
            'district'    => 'Kandy',
            'slug'        => Str::slug('Dumbara Handloom Centre'),
            'category_id' => $categoryId('Handloom'),
            'best_for'    => 'Students, Researchers',
            'updated_at'  => now(),
        ]);

        // ── Insert additional representative industry records ───────────────
        $packages = [
            [
                'name'        => 'Nildandahinna Pottery Village',
                'district'    => 'Kandy',
                'category'    => 'Pottery',
                'best_for'    => 'Families, Tourists, Students',
                'price'       => 250,
                'description' => '<p>The <strong>Nildandahinna Pottery Village</strong> is one of Sri Lanka\'s oldest pottery-making communities. Skilled artisans demonstrate traditional clay-shaping techniques passed down through generations, producing decorative and functional pottery items.</p>',
            ],
            [
                'name'        => 'Kandy Wood Carving Workshop',
                'district'    => 'Kandy',
                'category'    => 'Wood Carving',
                'best_for'    => 'Tourists, Art Lovers, Photographers',
                'price'       => 350,
                'description' => '<p>The <strong>Kandy Wood Carving Workshop</strong> showcases the intricate art of traditional Sri Lankan wood carving. Artisans craft beautiful figures, masks, and furniture items using ebony and teak wood with hand-carved motifs inspired by Buddhist and local cultural heritage.</p>',
            ],
            [
                'name'        => 'Matara Brassware Craft Centre',
                'district'    => 'Matara',
                'category'    => 'Brassware',
                'best_for'    => 'Tourists, Researchers, Art Lovers',
                'price'       => 300,
                'description' => '<p>The <strong>Matara Brassware Craft Centre</strong> preserves the ancient craft of Sri Lankan brass and bronze casting. Visitors can observe artisans creating ornate traditional lamps, figurines, and ceremonial items using age-old lost-wax casting techniques.</p>',
            ],
            [
                'name'        => 'Ayurveda Herbal Garden & Spa',
                'district'    => 'Gampaha',
                'category'    => 'Ayurveda',
                'best_for'    => 'Wellness Seekers, Tourists, Researchers',
                'price'       => 500,
                'description' => '<p>Experience the healing traditions of <strong>Sri Lankan Ayurveda</strong> at this authentic herbal garden and wellness centre. Learn about traditional medicinal plants, herbal preparations, and authentic Ayurvedic treatments that have been practiced in Sri Lanka for over 3,000 years.</p>',
            ],
        ];

        foreach ($packages as $package) {
            $slug = Str::slug($package['name']);
            // Avoid duplicate slug conflicts
            $existingSlug = DB::table('travel_packages')->where('slug', $slug)->exists();
            if ($existingSlug) {
                continue;
            }
            DB::table('travel_packages')->insert([
                'name'        => $package['name'],
                'district'    => $package['district'],
                'slug'        => $slug,
                'category_id' => $categoryId($package['category']),
                'best_for'    => $package['best_for'],
                'price'       => $package['price'],
                'description' => $package['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
