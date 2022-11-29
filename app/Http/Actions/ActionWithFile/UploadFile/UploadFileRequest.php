<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithFile\UploadFile;

use App\Http\Requests\ApiRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

/**
 * @property-read File|UploadedFile|string|null $image
 */
final class UploadFileRequest extends ApiRequest
{
    public const KEY_IMAGE = 'image';

    public const VALIDATION_MIN_WIDTH = 100;
    public const VALIDATION_MAX_WIDTH = 2000;

    public const VALIDATION_MIN_HEIGHT = 100;
    public const VALIDATION_MAX_HEIGHT = 2000;

    public const VALIDATION_MAX_SIZE = 2048;

    public const VALIDATION_ALLOWED_MIMES = ['jpg', 'png', 'jpeg', 'gif', 'svg'];

    public function rules(): array
    {
        return [
            self::KEY_IMAGE => [
                'sometimes',
                'nullable',
                'image',
                'mimes:' . implode(',', self::VALIDATION_ALLOWED_MIMES),
                'max:' . self::VALIDATION_MAX_SIZE,
                'dimensions:min_width=' . self::VALIDATION_MIN_WIDTH . ',min_height=' . self::VALIDATION_MIN_HEIGHT
                . ',max_width=' . self::VALIDATION_MAX_WIDTH . ',max_height=' . self::VALIDATION_MAX_HEIGHT,
            ]
        ];
    }
}
