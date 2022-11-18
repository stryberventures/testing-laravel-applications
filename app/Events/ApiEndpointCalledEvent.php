<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ApiEndpointCalledEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(private string $endpointName)
    {
    }

    public function getEndpointName(): string
    {
        return $this->endpointName;
    }
}
