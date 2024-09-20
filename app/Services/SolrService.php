<?php

namespace App\Services;

use Solarium\Client;
use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SolrService
{
    protected Client $client;

    public function __construct()
    {
        // Set up Solr configuration
        $config = config('solarium');

        // Create the adapter and event dispatcher
        $adapter = new Curl();
        $eventDispatcher = new EventDispatcher();

        // Initialize Solarium client
        $this->client = new Client($adapter, $eventDispatcher, $config);
    }

    /**
     * Fetch all categories from Solr.
     *
     * @return array
     */
    public function getAllCategories(): array
    {
        $query = $this->client->createSelect();
        $query->setQuery('document_type:category AND parent_id:0');

        $resultset = $this->client->select($query);
        $categories = [];

        foreach ($resultset as $doc) {
            $categories[] = [
                'id' => $doc->id,
                'name_lv' => $doc->name_lv[0] ?? null,
                'name_en' => $doc->name_en[0] ?? null,
                'name_ru' => $doc->name_ru[0] ?? null,
                'slug_lv' => $doc->slug_lv[0] ?? null,
                'slug_en' => $doc->slug_en[0] ?? null,
                'slug_ru' => $doc->slug_ru[0] ?? null,
            ];
        }

        return $categories;
    }
}
