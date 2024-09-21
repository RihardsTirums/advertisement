<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SolrService;

class IndexCategoriesToSolr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solr:index-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all categories from the database into Solr';

    private SolrService $solrService;

    /**
     * Create a new command instance.
     *
     * @param SolrService $solrService
     */
    public function __construct(SolrService $solrService)
    {
        parent::__construct();
        $this->solrService = $solrService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->solrService->indexAllCategories();
        $this->info('Categories have been successfully indexed into Solr.');
        return 0;
    }
}
