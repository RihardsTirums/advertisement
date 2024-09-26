<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CategoryRepository;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display the main categories and their subcategories.
     *
     * @return View
     */
    public function index(): View
    {
        $locale = app()->getLocale();
        $categories = $this->categoryRepository->getCategoriesForIndexPage();

        // Pass the locale to the view
        return view('categories.index', compact('categories', 'locale'));
    }

    /**
     * Display a specific category and its subcategories based on the slug path.
     *
     * @param string $path
     * @return View
     */
    public function show(string $path): View
    {
        $slugs = explode('/', $path);
        $locale = app()->getLocale();
        $category = $this->categoryRepository->findByFullPath($slugs);

        if (!$category) {
            abort(404);
        }

        $subcategories = $this->categoryRepository->getNextLevelSubcategories($category->id);
        $breadcrumb = $this->categoryRepository->getBreadcrumbFromSlugs($slugs);

        return view('categories.show', compact('category', 'subcategories', 'breadcrumb', 'slugs', 'locale'));
    }
}

