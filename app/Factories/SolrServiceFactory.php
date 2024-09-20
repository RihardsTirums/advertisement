<?php

namespace App\Factories;

use App\Services\SolrService;

/**
 * Factory to create SolrService instance
 */
class SolrServiceFactory
{
    /**
     * Create a new SolrService.
     *
     * @return SolrService
     */
    public static function create(): SolrService
    {
        return new SolrService();
    }
}
