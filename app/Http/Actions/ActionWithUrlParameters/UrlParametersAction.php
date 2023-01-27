<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithUrlParameters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlParametersAction extends Controller
{
    public function __invoke(?int $id): JsonResource
    {
        if (!$id) {
            $id = 1;
        }

        return new JsonResource([$id]);
    }
}
