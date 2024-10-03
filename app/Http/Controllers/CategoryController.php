<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

/**
 * Controller to handle category-related pages.
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show a specific category based on the slug.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $category = Category::where("slug_" . app()->getLocale(), $slug)->firstOrFail();
        return view('categories.show', compact('category'));
    }
}
