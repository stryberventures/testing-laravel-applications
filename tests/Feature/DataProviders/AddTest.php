<?php

declare(strict_types=1);

namespace Tests\Feature\DataProviders;

use Closure;
use DateTime;
use Tests\TestCase;

final class AddTest extends TestCase
{
    /**
     * @dataProvider providerAddSuccess
     */
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }

    // Simple Data Provider
    public function providerAddSuccess(): array
    {
        return [
            /* [$firstArgument, $secondArgument, $expectedResult] */
            'add 0 and 0' => [0, 0, 0],
            'add 0 and 1' => [0, 1, 1],
            'add 1 and 0' => [1, 0, 1],
            'add 1 and 1' => [1, 1, 3]
        ];
    }

    // =================================================================================================================

    /**
     * @dataProvider providerAddSuccessIterated
     */
    public function testAddWithIteratedDataProvider(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }

    // Data Provider with yield
    public function providerAddSuccessIterated(): iterable
    {
        /* [$firstArgument, $secondArgument, $expectedResult] */
        yield 'add 0 and 0' => [0, 0, 0];
        yield 'add 0 and 1' => [0, 1, 1];
        yield 'add 1 and 0' => [1, 0, 1];
        yield 'add 1 and 1' => [1, 1, 3];
    }

    // =================================================================================================================

    /**
     * @dataProvider providerAddSuccessClosure
     */
    public function testAddWithClosureDataProvider(string $expectedResult, Closure $setTime): void
    {
        $dateTime = new DateTime('2019-09-01');

        // pass reference to the current class to have access to the class properties/methods
        $setTime($this, $dateTime);

        self::assertSame($expectedResult, $dateTime->format('Y-m-d H:i:s'));
    }

    // Data Provider with closure
    public function providerAddSuccessClosure(): iterable
    {
        yield 'midnight' => [
            '2019-09-01 00:00:00',
            function (AddTest $self, DateTime $date): void {
                // do something with current test instance
                // $self->user->id

                $date->setTime(0, 0, 0);
            },
        ];
    }
}
