<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository
{
    /**
     * Fetch all categories with their first-level subcategories in the current locale.
     * Categories are cached indefinitely for improved performance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories(): \Illuminate\Database\Eloquent\Collection;
}
