<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithTime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

final class TimeAction extends Controller
{
    public const INVASION_DATE = '2022-02-24';

    public const RESPONSE_DEFAULT = '❤️';
    public const RESPONSE_AFTER_INVASION = 'Russian 🇷🇺 warship go f**ck yourself!';

    public function __invoke(): JsonResource
    {
        $response = TimeAction::RESPONSE_DEFAULT;

        $currentTime = Carbon::now();
        $invasionDate = Carbon::createFromFormat('Y-m-d', TimeAction::INVASION_DATE);

        if ($currentTime->gt($invasionDate)) {
            $response = TimeAction::RESPONSE_AFTER_INVASION;
        }

        return new JsonResource([$response]);
    }
}
