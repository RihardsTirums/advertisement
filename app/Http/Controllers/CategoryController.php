<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\SolrService;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\CategoryRepository;

/**
 * Controller for handling categories.
 */
class CategoryController extends Controller
{
    private SolrService $solrService;
    private CategoryRepository $categoryRepository;

    /**
     * CategoryController constructor.
     *
     * @param SolrService $solrService
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(SolrService $solrService, CategoryRepository $categoryRepository)
    {
        // Keeping Solr for future use but commenting out for now
        $this->solrService = $solrService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display all categories.
     *
     * @return View
     */
    public function index(): View
    {
        // Commenting out Solr logic to switch to PostgreSQL
        // $categories = $this->solrService->getAllCategories();

        // Use PostgreSQL logic (Repository Pattern) for now
        $categories = $this->categoryRepository->getAllCategories();

        // Return the view with categories
        return view('categories.index', ['categories' => $categories]);
    }
}
