<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed all traditional Sri Lankan industry categories used by the AI chatbot.
     */
    public function run(): void
    {
        $categories = [
            'Handloom',
            'Pottery',
            'Batik',
            'Wood Carving',
            'Brassware',
            'Ayurveda',
            'Mask Making',
            'Lacquerwork',
            'Traditional Food Production',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name'       => $name,
                    'slug'       => Str::slug($name),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
