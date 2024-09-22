<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

/**
 * Seeder for populating initial categories and subcategories.
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create top-level category
        $electronics = Category::create([
            'name_lv' => 'Elektronika',
            'name_en' => 'Electronics',
            'name_ru' => 'Электроника',
            'slug_lv' => 'elektronika',
            'slug_en' => 'electronics',
            'slug_ru' => 'elektronika',
            'parent_id' => null, // Top-level category
        ]);

        // Subcategory under Elektronika
        $communication = Category::create([
            'name_lv' => 'Sakaru līdzekļi',
            'name_en' => 'Communication devices',
            'name_ru' => 'Средства связи',
            'slug_lv' => 'sakaru-lidzekli',
            'slug_en' => 'communication-devices',
            'slug_ru' => 'sredstva-svyazi',
            'parent_id' => $electronics->id, // Elektronika is the parent
        ]);

        // Subcategory under Elektronika
        $householdAppliances = Category::create([
            'name_lv' => 'Sadzīves tehnika',
            'name_en' => 'Household appliances',
            'name_ru' => 'Бытовая техника',
            'slug_lv' => 'sadzives-tehnika',
            'slug_en' => 'household-appliances',
            'slug_ru' => 'bytovaya-tehnika',
            'parent_id' => $electronics->id, // Elektronika is the parent
        ]);

        // Sub-subcategory under Sakaru līdzekļi
        $mobilePhones = Category::create([
            'name_lv' => 'Mobilie telefoni',
            'name_en' => 'Mobile Phones',
            'name_ru' => 'Мобильные телефоны',
            'slug_lv' => 'mobilie-telefoni',
            'slug_en' => 'mobile-phones',
            'slug_ru' => 'mobilnye-telefony',
            'parent_id' => $communication->id, // Sakaru līdzekļi is the parent
        ]);

        // Sub-sub-subcategories under Mobilie telefoni (brands)
        $apple = Category::create([
            'name_lv' => 'Apple',
            'name_en' => 'Apple',
            'name_ru' => 'Apple',
            'slug_lv' => 'apple',
            'slug_en' => 'apple',
            'slug_ru' => 'apple',
            'parent_id' => $mobilePhones->id, // Mobilie telefoni is the parent
        ]);

        // Sub-sub-sub-subcategory under Apple (models)
        Category::create([
            'name_lv' => 'iPhone 11 Pro Max',
            'name_en' => 'iPhone 11 Pro Max',
            'name_ru' => 'iPhone 11 Pro Max',
            'slug_lv' => 'iphone-11-pro-max',
            'slug_en' => 'iphone-11-pro-max',
            'slug_ru' => 'iphone-11-pro-max',
            'parent_id' => $apple->id, // Apple is the parent
        ]);

        // Add more models under Apple, other brands under Mobilie telefoni, and repeat the structure...
    }
}
