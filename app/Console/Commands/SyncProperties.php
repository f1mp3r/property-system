<?php

namespace App\Console\Commands;

use App\Contracts\PropertyFetchContract;
use App\Jobs\ProcessPropertiesJob;
use Illuminate\Console\Command;

class SyncProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:sync {--perPage=} {--pages=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and sync properties';

    /**
     * Execute the console command.
     *
     * @param PropertyFetchContract $fetcher
     * @return int
     */
    public function handle(PropertyFetchContract $fetcher)
    {
        $this->info('Start processing');

        if (!env('API_KEY')) {
            $this->error('Missing API_KEY');
            return 1;
        }
        $perPage = $this->option('perPage') ?: 100;

        // Calculate total number of pages
        $initialData = $fetcher->fetch(1, 1);
        $totalPages = $pageLimit = floor($initialData['total'] / $perPage);

        if ($this->option('pages') && (int) $this->option('pages') < $totalPages) {
            $pageLimit = $this->option('pages');
        }

        foreach (range(1, $pageLimit) as $page) {
            $this->info('Job for page ' . $page . ' dispatched');
            dispatch(new ProcessPropertiesJob($page, $perPage));
        }

        return 0;
    }
}
