<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository
{
    /**
     * Get categories for the index page with limited subcategories.
     *
     * @return Collection
     */
    public function getCategoriesForIndexPage(): Collection;

    /**
     * Find a category by its full slug path.
     *
     * @param array $slugs
     * @return Category|null
     */
    public function findByFullPath(array $slugs): ?Category;

    /**
     * Get next-level subcategories of a category.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getNextLevelSubcategories(int $parentId): Collection;

    /**
     * Generate the breadcrumb based on slugs.
     *
     * @param array $slugs
     * @return Collection
     */
    public function getBreadcrumbFromSlugs(array $slugs): Collection;
}
