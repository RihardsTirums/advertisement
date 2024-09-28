<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller class for handling category-related requests.
 */
class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService, Request $request)
    {
        $this->categoryService = $categoryService;

        // Set the canonical URL for all category-related pages.
        $this->setCanonicalUrl($request);
    }

    /**
     * Display a listing of the main categories on the index page.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllMainCategoriesWithSubcategories();
        return view('categories.index', compact('categories'));
    }

    /**
     * Display the subcategories for a given path.
     *
     * @param Request $request
     * @param string|null $path
     * @return View
     */
    public function show(Request $request, string $path = null): View
    {
        // Extract slug segments from the path.
        $slugs = explode('/', $path);

        // Fetch the categories and subcategories based on the path.
        $category = $this->categoryService->getCategoryBySlugs($slugs);

        // Render the subcategories view if a valid category is found.
        return view('categories.show', compact('category'));
    }
}
