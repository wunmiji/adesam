<?php

namespace App\Enums;

enum PaymentMethod : string {

    case CASH = 'Cash on Delivery';
    case BANK_TRANSFER = 'Direct bank transfer';
    case CREDIT_CARD = 'Credit Card';
    case PAYPAL = 'Paypal';
    
    
    public function color(): string {
        return match($this) {
            PaymentMethod::CASH => '#EDAFB8',   
            PaymentMethod::BANK_TRANSFER => '#4A5759',   
            PaymentMethod::CREDIT_CARD => '#B0C4B1',   
            PaymentMethod::PAYPAL => '#F7E1D7'
        };
    }

    public static function getValue($arg) {
        $enumsArr = PaymentMethod::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = PaymentMethod::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}