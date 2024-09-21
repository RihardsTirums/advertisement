<?php

namespace App\Services;

use Solarium\Client;
use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Models\Category;

class SolrService
{
    protected Client $client;

    public function __construct()
    {
        $config = config('solarium');

        $adapter = new Curl();
        $eventDispatcher = new EventDispatcher();

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

    /**
     * Index all categories from the database into Solr.
     *
     * @return void
     */
    public function indexAllCategories(): void
    {
        $update = $this->client->createUpdate();

        $categories = Category::with('children')->get();

        $this->indexCategoriesRecursively($update, $categories);

        $update->addCommit();
        $this->client->update($update);
    }

    /**
     * Recursively index categories and subcategories into Solr.
     *
     * @param mixed $update
     * @param mixed $categories
     * @return void
     */
    private function indexCategoriesRecursively($update, $categories): void
    {
        foreach ($categories as $category) {
            $doc = $update->createDocument();
            $doc->id = $category->id;
            $doc->name_lv = $category->name_lv;
            $doc->name_en = $category->name_en;
            $doc->name_ru = $category->name_ru;
            $doc->slug_lv = $category->slug_lv;
            $doc->slug_en = $category->slug_en;
            $doc->slug_ru = $category->slug_ru;
            $doc->parent_id = $category->parent_id;

            $update->addDocument($doc);

            // Recursively index children (subcategories)
            if ($category->children->isNotEmpty()) {
                $this->indexCategoriesRecursively($update, $category->children);
            }
        }
    }
}
