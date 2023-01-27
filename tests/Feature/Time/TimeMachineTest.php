<?php

declare(strict_types=1);

namespace Tests\Feature\Time;

use App\Http\Actions\ActionWithTime\TimeAction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Tests\TestCase;

final class TimeMachineTest extends TestCase
{
    public function testMessageBasedOnCurrentDate(): void
    {
        $currentDate = $this->faker->dateTimeBetween('-2 years', '+2 years')->format('Y-m-d');

        $now = Carbon::createFromFormat('Y-m-d', $currentDate)
            ->setTime(0,0)
        ;
        $this->travelTo($now);

        $expectedResponse = ($currentDate < TimeAction::INVASION_DATE)
            ? TimeAction::RESPONSE_DEFAULT
            : TimeAction::RESPONSE_AFTER_INVASION
        ;

        $url = $this->urlGenerator->action(TimeAction::class);

        $this->getJson($url)
             ->assertOk()
             ->assertExactJson([
                 JsonResource::$wrap => [
                     $expectedResponse
                 ],
             ])
        ;

        $this->debug([$currentDate, $expectedResponse]);
    }
}
