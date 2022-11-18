<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithException;

use App\Exceptions\SomeException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class ExceptionAction extends Controller
{
    public function __invoke(): JsonResource
    {
        throw new SomeException();
    }
}
