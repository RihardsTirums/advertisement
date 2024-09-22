<?php

namespace App\Repositories\Interfaces;

interface CategoryRepository
{
    /**
     * Fetch all categories with their first-level subcategories.
     *
     * @return array
     */
    public function getAllCategories(): array;
}
