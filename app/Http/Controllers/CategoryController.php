<?php

namespace App\Http\Controllers;

use App\Services\SolrService;
use Illuminate\Http\JsonResponse;

/**
 * Controller for handling categories.
 */
class CategoryController extends Controller
{
    private SolrService $solrService;

    /**
     * CategoryController constructor.
     *
     * @param SolrService $solrService
     */
    public function __construct(SolrService $solrService)
    {
        $this->solrService = $solrService;
    }

    /**
     * Display all categories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = $this->solrService->getAllCategories();
        return response()->json($categories);
    }
}
