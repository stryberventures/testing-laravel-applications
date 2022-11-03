<?php

declare(strict_types=1);

namespace Tests\Feature\DataProviders;

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

    public function providerAddSuccessIterated(): iterable
    {
        /* [$firstArgument, $secondArgument, $expectedResult] */
        yield 'add 0 and 0' => [0, 0, 0];
        yield 'add 0 and 1' => [0, 1, 1];
        yield 'add 1 and 0' => [1, 0, 1];
        yield 'add 1 and 1' => [1, 1, 3];
    }
}
