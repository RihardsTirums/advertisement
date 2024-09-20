<?php

namespace App\Http\Controllers;

use App\Factories\SolrServiceFactory;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $solrService = SolrServiceFactory::create();
        $categories = $solrService->getAllCategories();

        return response()->json($categories);
    }
}
