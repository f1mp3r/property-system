<?php

namespace App\Jobs;

use App\Contracts\PropertyFetchContract;
use App\Mappers\Property\PropertySyncMapper;
use App\Models\Property;
use App\Services\PropertyHashService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessPropertiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $page;
    private int $perPage;

    /**
     * Create a new job instance.
     *
     * @param int $page
     * @param int $perPage
     */
    public function __construct(int $page, int $perPage = 100)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping('sync'))->releaseAfter(10)];
    }

    /**
     * Execute the job.
     *
     * @param PropertyFetchContract $fetcher
     * @return void
     */
    public function handle(PropertyFetchContract $fetcher)
    {
        $logger = Log::channel('property');
        $jobId = $this->job->uuid();
        try {
            $logger->debug(sprintf('[%s] Start sync page %s', $jobId, $this->page));

            $data = $fetcher->fetch($this->page, $this->perPage);

            collect($data['data'])
                ->each(function ($property) {
                    $entry = DB::table('properties')
                        ->select('data_hash')
                        ->where('remote_uuid', $property['uuid'])
                        ->first();
                    $hash = PropertyHashService::hash($property);

                    if ($entry && $entry->data_hash === $hash) {
                        // If hashes match, no changes have been made to the property, no need to update
                        return;
                    }

                    Property::updateOrCreate(
                        [
                            'remote_uuid' => $property['uuid'],
                        ],
                        array_merge(
                            PropertySyncMapper::toLocal((object)$property),
                            ['data_hash' => $hash]
                        )
                    );
                });
            $logger->debug(sprintf('[%s] Finish sync page %s', $jobId, $this->page));
        } catch (Exception $exception) {
            $logger->error('[' . $jobId . '] ' . $exception->getMessage(), ['trace' => $exception->getTraceAsString()]);
        }
    }
}
