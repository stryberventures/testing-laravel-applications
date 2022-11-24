<?php

declare(strict_types=1);

namespace Tests\Feature\Notification;

use App\Http\Actions\ActionWithNotification\NotificationAction;
use App\Models\User;
use App\Notifications\ApiEndpointCalledNotification;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

final class NotificationsTest extends TestCase
{
    public function testNotificationWasSend(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $routeName = 'make-notification';
        $this->getJson(
            $this->urlGenerator->route($routeName)
        )->assertOk();

        Notification::assertSentTo(
            [$user],
            ApiEndpointCalledNotification::class,
            function (ApiEndpointCalledNotification $notification, $channels, $notifiable) use ($user, $routeName) {
                // Check channels
                $this->assertContains(MailChannel::class, $channels);

                // Check the data that is passed to the view
                $notificationArray = $notification->toArray($user);
                $this->assertEquals($routeName, $notificationArray['route']);

                // Check mail attributes
                $mailNotification = (object)$notification->toMail($user);
                $this->assertEquals(ApiEndpointCalledNotification::SUBJECT, $mailNotification->subject);
                $this->assertEquals(ApiEndpointCalledNotification::TEMPLATE, $mailNotification->markdown);
                $this->assertEquals($notificationArray, $mailNotification->viewData);

                // Check mail content
                $mailData = $notification->toMail($user)->render()->toHtml();
                $this->assertStringContainsString('API endpoint ' . $routeName . ' called', $mailData);

                return true;
            }
        );
    }

    public function testNotificationWasQueued(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $this->getJson(
            $this->urlGenerator->action(NotificationAction::class)
        )->assertOk();

        // assertNotPushed if notification doesn't implement Illuminate\Contracts\Queue\ShouldQueue
        Queue::assertPushed(
            SendQueuedNotifications::class,
            function ($job, $queue, $data) use ($user) {
                $this->assertEquals(ApiEndpointCalledNotification::class, get_class($job->notification));
                $this->assertEquals(QUEUE_NOTIFICATIONS, $queue);
                $this->assertContains($user->id, $job->notifiables->pluck('id'));

                return true;
            }
        );
    }
}
