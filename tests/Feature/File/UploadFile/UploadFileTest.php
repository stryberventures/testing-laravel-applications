<?php

declare(strict_types=1);

namespace Tests\Feature\File\UploadFile;

use App\Http\Actions\ActionWithFile\UploadFile\UploadFileRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class UploadFileTest extends TestCase
{
    public function testUploadImageSuccess(): void
    {
        $storage = Storage::fake();

        // GD library required
        $fakeImage = UploadedFile::fake()->image(
            'photo1.jpg',
            $this->faker->numberBetween(
                UploadFileRequest::VALIDATION_MIN_WIDTH,
                UploadFileRequest::VALIDATION_MAX_WIDTH
            ),
            $this->faker->numberBetween(
                UploadFileRequest::VALIDATION_MIN_HEIGHT,
                UploadFileRequest::VALIDATION_MAX_HEIGHT
            ),
        );

        $response = $this->postJson($this->urlGenerator->route('upload-file'), [
            UploadFileRequest::KEY_IMAGE => $fakeImage
        ]);

        $response->assertOk();
        $storage->assertExists($response->json('data.0'));
    }

    /**
     * @dataProvider providerWrongDimensions
     */
    final public function testUploadImageDimensionErrors(int $width, int $height): void
    {
        Storage::fake();

        $fakeImage = UploadedFile::fake()->image(
            'photo1.jpg',
            $width,
            $height,
        );

        $response = $this->postJson($this->urlGenerator->route('upload-file'), [
            UploadFileRequest::KEY_IMAGE => $fakeImage
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertContains(
            __('validation.dimensions', ['attribute' => UploadFileRequest::KEY_IMAGE]),
            $response->json('errors.' . UploadFileRequest::KEY_IMAGE)
        );
    }

    final public function providerWrongDimensions(): iterable
    {
        yield 'less_than_min' => [
            UploadFileRequest::VALIDATION_MIN_WIDTH - 1,
            UploadFileRequest::VALIDATION_MIN_HEIGHT - 1
        ];

        yield 'greater_than_max' => [
            UploadFileRequest::VALIDATION_MAX_WIDTH + 1,
            UploadFileRequest::VALIDATION_MAX_HEIGHT + 1
        ];
    }

    final public function testUploadImageSizeErrors(): void
    {
        Storage::fake();

        $fakeImage = UploadedFile::fake()->create(
            'photo1.jpg',
            UploadFileRequest::VALIDATION_MAX_SIZE + 1
        );

        $response = $this->postJson($this->urlGenerator->route('upload-file'), [
            UploadFileRequest::KEY_IMAGE => $fakeImage
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertContains(
            __('validation.max.file', [
                'attribute' => UploadFileRequest::KEY_IMAGE,
                'max' => UploadFileRequest::VALIDATION_MAX_SIZE
            ]),
            $response->json('errors.' . UploadFileRequest::KEY_IMAGE)
        );
    }

    final public function testUploadImageMimeErrors(): void
    {
        Storage::fake();

        $fakeImage = UploadedFile::fake()->create(
            'photo1.txt',
            $this->faker->numberBetween(1, UploadFileRequest::VALIDATION_MAX_SIZE),
        );

        $response = $this->postJson($this->urlGenerator->route('upload-file'), [
            UploadFileRequest::KEY_IMAGE => $fakeImage
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertContains(
            __('validation.mimes', [
                'attribute' => UploadFileRequest::KEY_IMAGE,
                'values' => implode(', ', UploadFileRequest::VALIDATION_ALLOWED_MIMES)
            ]),
            $response->json('errors.' . UploadFileRequest::KEY_IMAGE)
        );
    }
}
