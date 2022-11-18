<?php

namespace App\Listeners;

use App\Events\ApiEndpointCalledEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Psr\Log\LoggerInterface;

final class ListenToApiEndpointCalled implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApiEndpointCalledEvent  $event
     *
     * @return void
     */
    public function handle(ApiEndpointCalledEvent $event): void
    {
        $this->logger->info($event->getEndpointName() . ' Endpoint called');
    }
}
