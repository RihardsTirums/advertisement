<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class DatabaseCategoryRepository implements CategoryRepository
{
    /**
     * Fetch all categories with their first-level subcategories in the current locale.
     * Categories are cached indefinitely for improved performance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::rememberForever('categories_' . app()->getLocale(), function () {
            $nameField = 'name_' . app()->getLocale();

            return Category::whereNull('parent_id')
                ->with(['children' => function ($query) use ($nameField) {
                    $query->select('id', 'parent_id', 'slug_en', "{$nameField} as name");
                }])
                ->select('id', 'parent_id', 'slug_en', "{$nameField} as name")
                ->get();
        });
    }
}
