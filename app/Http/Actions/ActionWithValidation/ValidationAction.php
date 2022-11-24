<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithValidation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationAction extends Controller
{
    public function __invoke(ValidationActionRequest $request): JsonResource
    {
        return new JsonResource(['ok']);
    }
}
