<?php

namespace App\Enums;

class RemmittanceStatus
{
    public const PENDING = 0;
    public const SUBMITTED = 1;
    public const RECEIVED = 2;

    public static function toArray(): array
    {
        return [
            self::PENDING => 'Pending submission',
            self::SUBMITTED => 'Submitted to insurance',
            self::RECEIVED => 'Received Payments',
        ];
    }

    public static function getName($value): string
    {
        switch ($value) {
            case self::PENDING:
                return 'Pending submission';
            case self::SUBMITTED:
                return 'Submitted to insurance';
            case self::RECEIVED:
                return 'Received Payments';
            default:
                return '';
        }
    }
}
