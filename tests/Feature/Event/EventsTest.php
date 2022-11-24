<?php

declare(strict_types=1);

namespace Tests\Feature\Event;

use App\Events\ApiEndpointCalledEvent;
use App\Listeners\ListenToApiEndpointCalled;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

final class EventsTest extends TestCase
{
    public function testEventWasDispatched(): void
    {
        // All events will be fake
        // Prevent all listeners from executing
        // Event::fake();

        // Prevent only ApiEndpointCalledEvent::class listeners from executing
        // Event::fake([
        //     ApiEndpointCalledEvent::class,
        // ]);

        $dispatcher = Event::fake([
            ApiEndpointCalledEvent::class,
        ]);

        $routeName = 'create-event';
        $url = $this->urlGenerator->route($routeName);
        $this->getJson($url)->assertOk();

        // Event::assertDispatched(ApiEndpointCalledEvent::class);
        $dispatcher->assertDispatched(ApiEndpointCalledEvent::class);

        // Event::assertDispatched(function (ApiEndpointCalledEvent $event) use ($routeName) {
        //     return $event->getEndpointName() === $routeName;
        // });
        $dispatcher->assertDispatched(function (ApiEndpointCalledEvent $event) use ($routeName) {
            return $event->getEndpointName() === $routeName;
        });
    }

    public function testListenerIsListening(): void
    {
        $dispatcher = Event::fake([
            ApiEndpointCalledEvent::class,
        ]);

        $routeName = 'create-event';
        $url = $this->urlGenerator->route($routeName);
        $this->getJson($url)->assertOk();

        // If event listener was described like:
        //     protected $listen = [
        //         ApiEndpointCalledEvent::class => [
        //             ListenToApiEndpointCalled::class
        //         ]
        //     ];
        // inside EventServiceProvider::class
        //
        // $dispatcher->assertListening(
        //     ApiEndpointCalledEvent::class,
        //     ListenToApiEndpointCalled::class
        // );

        // If event listener was described like:
        //     public function boot()
        //     {
        //         Event::listen(
        //             ApiEndpointCalledEvent::class,
        //             [ListenToApiEndpointCalled::class, 'handle']
        //         );
        //     }
        // inside EventServiceProvider::class
        $dispatcher->assertListening(
            ApiEndpointCalledEvent::class,
            [ListenToApiEndpointCalled::class, 'handle']
        );
    }

    public function testEventListenerWasQueued(): void
    {
        Queue::fake();

        $routeName = 'create-event';
        $url = $this->urlGenerator->route($routeName);
        $this->getJson($url)->assertOk();

        // assertNotPushed if listener doesn't implement Illuminate\Contracts\Queue\ShouldQueue
        Queue::assertPushed(
            CallQueuedListener::class,
            function ($job, $queue, $data) {
                $this->assertEquals(ListenToApiEndpointCalled::class, $job->class);
                $this->assertEquals(QUEUE_LISTENERS, $queue);

                return true;
            }
        );
    }

    public function testEventListenerWork(): void
    {
        /** @var MockInterface|LoggerInterface $listener */
        $logger = $this->partialMock(LoggerInterface::class);

        $routeName = 'create-event';

        $logger
            ->shouldReceive('info')
            ->with($routeName . ' Endpoint called')
            ->once()
        ;

        $url = $this->urlGenerator->route($routeName);
        $response = $this->getJson($url);
        $response->assertOk();
    }

    public function testEventListenerWorkOtherWay(): void
    {
        /** @var MockInterface|LoggerInterface $listener */
        $logger = $this->partialMock(LoggerInterface::class);

        $routeName = 'create-event';

        $logger
            ->shouldReceive('info')
            ->with($routeName . ' Endpoint called')
            ->once()
        ;

        (new ListenToApiEndpointCalled($logger))->handle(new ApiEndpointCalledEvent($routeName));
    }
}
