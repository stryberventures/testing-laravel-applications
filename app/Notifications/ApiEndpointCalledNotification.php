<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ApiEndpointCalledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public const SUBJECT = 'API endpoint called';
    public const TEMPLATE = 'emails.api-endpoint-called';

    public function __construct(
        private string $route
    ) {
        $this->queue = QUEUE_NOTIFICATIONS;
    }

    public function via(User $notifiable): array
    {
        return [MailChannel::class];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(self::SUBJECT)
            ->markdown(self::TEMPLATE, $this->toArray($notifiable))
        ;
    }

    public function toArray(User $notifiable): array
    {
        return [
            'route' => $this->route,
        ];
    }
}
