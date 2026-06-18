<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Renames `type` -> `name` and `location` -> `district` (using raw SQL
     * for compatibility with older MariaDB versions), and adds `category_id`
     * and `best_for` columns.
     */
    public function up(): void
    {
        // Use raw SQL CHANGE COLUMN for MariaDB < 10.5 compatibility
        DB::statement('ALTER TABLE `travel_packages` CHANGE `type` `name` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `travel_packages` CHANGE `location` `district` VARCHAR(255) NOT NULL');

        Schema::table('travel_packages', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('name')
                  ->constrained('categories')
                  ->nullOnDelete();

            $table->string('best_for')->nullable()->after('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'best_for']);
        });

        DB::statement('ALTER TABLE `travel_packages` CHANGE `name` `type` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `travel_packages` CHANGE `district` `location` VARCHAR(255) NOT NULL');
    }
};
