<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithEvent;

use App\Events\ApiEndpointCalledEvent;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class EventAction extends Controller
{
    public function __construct(
        private Dispatcher $eventDispatcher
    ) {
    }

    public function __invoke(): JsonResource
    {
        // event(new ApiEndpointCalledEvent(Route::currentRouteName()));
        // ApiEndpointCalledEvent::dispatch(Route::currentRouteName());
        $this->eventDispatcher->dispatch(
            new ApiEndpointCalledEvent(Route::currentRouteName())
        );

        return new JsonResource(['ok']);
    }
}
