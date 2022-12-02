<?php

namespace Tests\Feature\ValidationError;

use App\Http\Actions\ActionWithValidation\ValidationAction;
use App\Http\Actions\ActionWithValidation\ValidationActionRequest;
use App\Models\User;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

final class ValidationErrorTest extends TestCase
{
    public function testRequiredValidationErrorIsThrown(): void
    {
        $payDay = $this->faker->numberBetween(1, 30);
        $invoiceCutoffDays = $payDay + 1;

        $response = $this->getJson(
            $this->urlGenerator->action(ValidationAction::class, [
                ValidationActionRequest::KEY_PAY_DAY => $payDay,
                ValidationActionRequest::KEY_INVOICE_CUTOFF_DAYS => $invoiceCutoffDays,

                // Without required field
                // ValidationActionRequest::KEY_IBAN => $this->faker->iban,
                // ValidationActionRequest::KEY_SOME_FIELD => $this->faker->name,
            ])
        )->assertUnprocessable();

        $errors = $response->json('errors');

        // =============================================================================================================
        // Check custom validation message

        $this->assertArrayHasKey(ValidationActionRequest::KEY_INVOICE_CUTOFF_DAYS, $errors);
        $this->assertContains(
            __(
                'validation.custom.wrong_invoice_cutoff_days',
                [
                    'pay_day' => $payDay
                ]
            ),
            $response->json('errors.' . ValidationActionRequest::KEY_INVOICE_CUTOFF_DAYS)
        );

        // =============================================================================================================
        // Check required field validation error with custom validation attribute

        /** @var Translator $translator */
        $translator = app(Translator::class);

        $requiredMissingFields = [
            ValidationActionRequest::KEY_IBAN,
            ValidationActionRequest::KEY_SOME_FIELD
        ];

        foreach ($requiredMissingFields as $requiredMissingField) {
            $this->assertArrayHasKey($requiredMissingField, $errors);
            $this->assertContains(
                __(
                    'validation.required',
                    [
                        // 'The i b a n field is required.' => 'The IBAN field is required.'
                        // 'The some field field is required.'
                        'attribute' => Arr::get(
                            $translator->get('validation.attributes'),
                            $requiredMissingField
                        )
                        ?? str_replace('_', ' ', Str::snake($requiredMissingField))
                    ]
                ),
                $response->json('errors.' . $requiredMissingField)
            );
        }
    }

    public function testMinPayDayValidationErrorIsThrown(): void
    {
        $payDay = $this->faker->numberBetween(ValidationActionRequest::MIN_PAY_DAY - 100, ValidationActionRequest::MIN_PAY_DAY - 1);
        $invoiceCutoffDays = $this->faker->numberBetween(User::MIN_CUTOFF_DAYS, User::MAX_CUTOFF_DAYS);

        $response = $this->getJson(
            $this->urlGenerator->action(ValidationAction::class, [
                ValidationActionRequest::KEY_PAY_DAY => $payDay,
                ValidationActionRequest::KEY_INVOICE_CUTOFF_DAYS => $invoiceCutoffDays,
                ValidationActionRequest::KEY_IBAN => $this->faker->iban,
                ValidationActionRequest::KEY_SOME_FIELD => $this->faker->name,
            ])
        )->assertUnprocessable();

        $errors = $response->json('errors');

        // =============================================================================================================
        // Check min validation message

        $validationField = ValidationActionRequest::KEY_PAY_DAY;

        /** @var Translator $translator */
        $translator = app(Translator::class);
        $this->assertArrayHasKey($validationField, $errors);
        $this->assertContains(
            __(
                'validation.min.numeric',
                [
                    'attribute' => Arr::get(
                        $translator->get('validation.attributes'), $validationField
                    ) ?? str_replace('_', ' ', Str::snake($validationField)),
                    'min' => ValidationActionRequest::MIN_PAY_DAY
                ]
            ),
            $response->json('errors.' . $validationField)
        );
    }

    public function testMaxPayDayValidationErrorIsThrown(): void
    {
        $payDay = $this->faker->numberBetween(ValidationActionRequest::MAX_PAY_DAY + 1, ValidationActionRequest::MIN_PAY_DAY + 100);
        $invoiceCutoffDays = $this->faker->numberBetween(User::MIN_CUTOFF_DAYS, User::MAX_CUTOFF_DAYS);

        $response = $this->getJson(
            $this->urlGenerator->action(ValidationAction::class, [
                ValidationActionRequest::KEY_PAY_DAY => $payDay,
                ValidationActionRequest::KEY_INVOICE_CUTOFF_DAYS => $invoiceCutoffDays,
                ValidationActionRequest::KEY_IBAN => $this->faker->iban,
                ValidationActionRequest::KEY_SOME_FIELD => $this->faker->name,
            ])
        )->assertUnprocessable();

        $errors = $response->json('errors');

        // =============================================================================================================
        // Check max validation message

        $validationField = ValidationActionRequest::KEY_PAY_DAY;

        /** @var Translator $translator */
        $translator = app(Translator::class);
        $this->assertArrayHasKey($validationField, $errors);
        $this->assertContains(
            __(
                'validation.max.numeric',
                [
                    'attribute' => Arr::get(
                            $translator->get('validation.attributes'), $validationField
                        ) ?? str_replace('_', ' ', Str::snake($validationField)),
                    'max' => ValidationActionRequest::MAX_PAY_DAY
                ]
            ),
            $response->json('errors.' . $validationField)
        );
    }
}
