<?php

declare(strict_types=1);

namespace Tests\Feature\SkippedTest;

use Tests\TestCase;

final class SkippedTest extends TestCase
{
    /** @dataProvider providerSkip */
    public function testSkip(bool $shouldSkipTest): void
    {
        if ($shouldSkipTest) {
            $this->markTestSkipped('some useful info');
        }

        $this->assertFalse($shouldSkipTest);
    }

    public function providerSkip(): iterable
    {
        yield 'should skip the test' => [true];
        yield 'should run the test' => [false];
    }
}
