<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepository;

class DatabaseCategoryRepository implements CategoryRepository
{
    /**
     * Fetch all categories and their first-level subcategories from PostgreSQL.
     *
     * @return array
     */
    public function getAllCategories(): array
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return $categories->toArray(); // Convert to array for easy JSON response
    }
}
