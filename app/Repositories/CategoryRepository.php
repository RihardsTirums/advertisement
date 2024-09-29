<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository class for Category operations.
 */
class CategoryRepository
{
    /**
     * Fetch all main categories (parent categories).
     *
     * @return Collection
     */
    public function getMainCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->with('children')
            ->get();
    }

    /**
     * Fetch nested categories for the given category.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getNestedCategories(int $parentId): Collection
    {
        return Category::where('parent_id', $parentId)
            ->with('children')
            ->get();
    }

    /**
     * Get a category by its slug in any language.
     *
     * @param string $slug
     * @param Category|null $parentCategory
     * @return Category|null
     */
    public function getCategoryBySlug(string $slug, ?Category $parentCategory = null): ?Category
    {
        $query = Category::where('slug_en', $slug)
            ->orWhere('slug_lv', $slug)
            ->orWhere('slug_ru', $slug);

        if ($parentCategory) {
            $query->where('parent_id', $parentCategory->id);
        }

        return $query->first();
    }
}
