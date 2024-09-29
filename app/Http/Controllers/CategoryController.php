<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * TODO: Investigate and fix the error that occurs when using the back button
     * after switching languages; ensure that it does not throw an error or flash
     * a message briefly.
     * Display the subcategories for a given path.
     *
     * This method retrieves the category based on the provided path,
     * translates slugs according to the current locale, and
     * handles redirects if necessary.
     *
     * @param Request $request The current HTTP request instance.
     * @param string|null $path The path containing slugs for the category.
     * @return View|RedirectResponse The view for the category or a redirect response if a redirect is required.
     */
    public function show(Request $request, ?string $path = null): View|RedirectResponse
    {
        // Extract slug segments from the path.
        $slugs = explode('/', $path);

        // Attempt to fetch the category using the slugs.
        $category = $this->categoryService->getCategoryBySlugs($slugs ?? []);

        // If no category is found, redirect to the index route.
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Create a new slug path with all existing slugs in localized form.
        $localizedSlugs = array_map(
            fn($slug) => $this->categoryService->getSlugBySlug($slug),
            $slugs
        );
        $newPath = implode('/', $localizedSlugs);

        // Regenerate the URL with the new slug path.
        $url = route('categories.show', ['path' => $newPath]);

        // Redirect to the localized URL only if it differs from the current path.
        if ($request->fullUrl() !== $url) {
            return redirect($url);
        }

        // Render the subcategories view if a valid category is found.
        return view('categories.show', compact('category'));
    }
}
