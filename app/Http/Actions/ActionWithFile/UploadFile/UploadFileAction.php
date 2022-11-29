<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithFile\UploadFile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

final class UploadFileAction extends Controller
{
    public function __invoke(UploadFileRequest $request): JsonResource
    {
        if (!$request->image) {
            // remove file from DB ...
            // Storage::delete($user->file)

            return new JsonResource([
                'removed'
            ]);
        }


        $path = Storage::putFile(
            \App\Infrastructure\Storage::KEY_STORAGE_PATH,
            $request->image
        );

        return new JsonResource([
            $path
        ]);
    }
}
