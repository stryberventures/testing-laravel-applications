<?php

declare(strict_types=1);

namespace App\Http\Actions\Some;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class SomeAction extends Controller
{
    public function __invoke(?int $id): JsonResource
    {
        if (!$id) {
            $id = 1;
        }

        return new JsonResource([$id]);
    }
}
