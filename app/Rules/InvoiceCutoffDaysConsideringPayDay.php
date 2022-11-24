<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class InvoiceCutoffDaysConsideringPayDay implements Rule
{
    public function __construct(
        private int $invoiceCutoffDays,
        private int $payDay,
    ) {
    }

    public function passes($attribute, $value): bool
    {
        return $this->invoiceCutoffDays <= $this->payDay;
    }

    public function message(): string
    {
        return __('validation.custom.wrong_invoice_cutoff_days', [
            'pay_day' => $this->payDay,
        ]);
    }
}
