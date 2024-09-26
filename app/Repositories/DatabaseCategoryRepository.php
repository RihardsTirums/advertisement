<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\CategoryRepository;

class DatabaseCategoryRepository implements CategoryRepository
{
    private string $nameField;
    private string $slugField;
    private string $locale;

    public function __construct()
    {
        $this->locale = app()->getLocale();
        $this->nameField = "name_{$this->locale}";
        $this->slugField = "slug_{$this->locale}";
    }

    /**
     * Get categories for the index page with a limit on subcategories.
     *
     * @return Collection
     */
    public function getCategoriesForIndexPage(): Collection
    {
        $cacheKey = $this->getCacheKey("categories_index_page");

        return Cache::rememberForever($cacheKey, function () {
            return Category::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->select('id', 'parent_id', "{$this->nameField} as name", "{$this->slugField} as slug")
                        ->limit(9);
                }])
                ->select('id', "{$this->nameField} as name", "{$this->slugField} as slug")
                ->get();  // Return collection instead of array
        });
    }

    /**
     * Find a category by its full slug path.
     *
     * @param array $slugs
     * @return Category|null
     */
    public function findByFullPath(array $slugs): ?Category
    {
        $fallbackLocale = config('app.fallback_locale');
        $fallbackSlugField = "slug_{$fallbackLocale}";
        $query = Category::query();

        foreach ($slugs as $slug) {
            $query->where(function ($query) use ($slug, $fallbackSlugField) {
                $query->where($this->slugField, $slug)
                    ->orWhere($fallbackSlugField, $slug);
            });

            $category = $query->first();

            if (!$category) {
                return null;
            }

            // Continue querying from this category's children
            $query = $category->children();
        }

        return $category;
    }

    /**
     * Get next-level subcategories of a category.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getNextLevelSubcategories(int $parentId): Collection
    {
        $cacheKey = $this->getCacheKey("subcategories_parent_{$parentId}");

        return Cache::rememberForever($cacheKey, function () use ($parentId) {
            return Category::where('parent_id', $parentId)
                ->select('id', 'parent_id', "{$this->nameField} as name", "{$this->slugField} as slug")
                ->get();  // Return collection instead of array
        });
    }

    /**
     * Generate the breadcrumb based on slugs.
     *
     * @param array $slugs
     * @return Collection
     */
    public function getBreadcrumbFromSlugs(array $slugs): Collection
    {
        $breadcrumb = collect();  // Initialize empty collection
        $path = [];

        foreach ($slugs as $slug) {
            $path[] = $slug;
            $category = $this->findByFullPath($path);

            if ($category) {
                $breadcrumb->push([
                    'name' => $category->{$this->nameField},
                    'slug' => $category->{$this->slugField},
                    'full_path' => implode('/', $path)
                ]);
            } else {
                break;
            }
        }

        return $breadcrumb;  // Return collection
    }

    /**
     * Generate a cache key based on the locale and additional identifiers.
     *
     * @param string $key
     * @return string
     */
    private function getCacheKey(string $key): string
    {
        return "{$key}_{$this->locale}";
    }
}

