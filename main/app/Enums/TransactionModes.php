<?php

namespace App\Enums;

class TransactionModes
{
    public const CASH = 0;
    public const MPESA = 1;
    public const BANK = 2;
    public const CHEQUE = 3;


    public static function toArray(): array
    {
        return [
            self::CASH => 'Cash',
            self::MPESA => 'M-Pesa',
            self::BANK => 'Bank/RTGS',
            self::CHEQUE => 'Cheque',
        ];
    }

    public static function getName($value): string
    {
        switch ($value) {
            case self::CASH:
                return 'Cash';
            case self::MPESA:
                return 'M-Pesa';
            case self::BANK:
                return 'Bank/RTGS';
            case self::CHEQUE:
                return 'Cheque';
            default:
                return '';
        }
    }
}
