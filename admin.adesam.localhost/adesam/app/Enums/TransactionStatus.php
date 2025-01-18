<?php

namespace App\Enums;

enum TransactionStatus : string {

    case COMPLETED = 'Completed';
    case EXPIRED = 'Expired';
    case CANCELED = 'Canceled';
    case FAILED = 'Failed';
    case REFUNDED = 'Refunded';
    
    
    public function color(): string {
        return match($this) {
            TransactionStatus::COMPLETED => '#13DEB9',   
            TransactionStatus::EXPIRED => '#E0115F', 
            TransactionStatus::CANCELED => '#13DEB9',   
            TransactionStatus::FAILED => '#13DEB9', 
            TransactionStatus::REFUNDED => '#13DEB9',   
        };
    }

    public static function getValue($arg) {
        $enumsArr = TransactionStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = TransactionStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}