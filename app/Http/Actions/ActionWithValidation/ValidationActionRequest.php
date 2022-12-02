<?php

declare(strict_types=1);

namespace App\Http\Actions\ActionWithValidation;

use App\Http\Requests\ApiRequest;
use App\Models\User;
use App\Rules\InvoiceCutoffDaysConsideringPayDay;

/**
 * @property-read string $pay_day
 * @property-read string $invoice_cutoff_days
 * @property-read string $IBAN
 * @property-read string $some_field
 */
final class ValidationActionRequest extends ApiRequest
{
    public const KEY_PAY_DAY = 'pay_day';
    public const KEY_INVOICE_CUTOFF_DAYS = 'invoice_cutoff_days';
    public const KEY_IBAN = 'IBAN';
    public const KEY_SOME_FIELD = 'some_field';

    public const MIN_PAY_DAY = 1;
    public const MAX_PAY_DAY = 31;

    function rules(): array
    {
        return [
            self::KEY_PAY_DAY => [
                'required',
                'integer',
                'min:' . self::MIN_PAY_DAY,
                'max:' . self::MAX_PAY_DAY,
            ],
            self::KEY_INVOICE_CUTOFF_DAYS => [
                'required',
                'integer',
                'min:' . User::MIN_CUTOFF_DAYS,
                'max:' . User::MAX_CUTOFF_DAYS,
                new InvoiceCutoffDaysConsideringPayDay((int) $this->invoice_cutoff_days, (int) $this->pay_day),
            ],
            self::KEY_IBAN => [
                'required',
                'string',
            ],
            self::KEY_SOME_FIELD => [
                'required',
                'string',
            ],
        ];
    }
}
