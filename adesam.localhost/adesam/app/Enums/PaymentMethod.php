<?php

namespace App\Enums;

enum PaymentMethod : string {

    case CASH = 'Cash on Delivery';
    case BANK_TRANSFER = 'Direct bank transfer';
    case CREDIT_CARD = 'Credit Card';
    case PAYPAL = 'Paypal';
    
    
    

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