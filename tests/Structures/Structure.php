<?php

declare(strict_types=1);

namespace Tests\Structures;

abstract class Structure
{
    abstract public function getStructure(): array;

    final public function getCollectionStructure(): array
    {
        return ['*' => $this->getStructure()];
    }
}
