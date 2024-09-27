<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service class for managing categories.
 */
class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all main categories with their subcategories.
     *
     * @return Collection
     */
    public function getAllMainCategoriesWithSubcategories(): Collection
    {
        return $this->categoryRepository->getMainCategories();
    }

    /**
     * Get nested subcategories for a specific category.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getSubcategoriesByParent(int $parentId): Collection
    {
        return $this->categoryRepository->getNestedCategories($parentId);
    }

    /**
     * Get the category by a series of slugs (e.g., electronics/phones).
     *
     * @param array $slugs
     * @return Category
     */
    public function getCategoryBySlugs(array $slugs): Category
    {
        $category = null;
        foreach ($slugs as $slug) {
            $category = Category::where('slug_en', $slug)
                ->orWhere('slug_lv', $slug)
                ->orWhere('slug_ru', $slug)
                ->when($category, function ($query) use ($category) {
                    return $query->where('parent_id', $category->id);
                })
                ->first();

            if (!$category) {
                throw new ModelNotFoundException('Category not found');
            }
        }
        return $category;
    }
}
