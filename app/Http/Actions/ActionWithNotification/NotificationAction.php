<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithNotification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ApiEndpointCalledNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;

final class NotificationAction extends Controller
{
    public function __invoke(): JsonResource
    {
        try {
            /** @var Notifiable $user */
            $user = User::query()->latest()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return new JsonResource([
                'no active users'
            ]);
        }

        try {
            // In the real life application it's better to create event and listener for sending email
            $user->notify(new ApiEndpointCalledNotification(Route::currentRouteName()));
        } catch (\Throwable $t) {
            return new JsonResource([
                $t->getMessage()
            ]);
        }

        return new JsonResource([
            'Notification send'
        ]);
    }
}
