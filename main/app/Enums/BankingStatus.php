<?php 

namespace App\Enums;

class BankingStatus
{
    const PENDING = 0;
    const PAID = 1;

    public static function toArray(): array
    {
        return [
            self::PENDING => 'Partially Paid',
            self::PAID => 'Fully Paid',
        ];
    }

    public static function getName($value): string
    {
        switch ($value) {
            case self::PENDING:
                return 'Partially Paid';
            case self::PAID:
                return 'Fully Paid';
            default:
                return '';
        }
    }
}