<?php

namespace App\Enums;

enum PaymentStatus : string {

    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case PARTIAL = 'Partial';
    
    
    public function color(): string {
        return match($this) {
            PaymentStatus::PENDING => '#13DEB9',  
            PaymentStatus::COMPLETED => '#13DEB9',   
            PaymentStatus::PARTIAL => '#E0115F',   
        };
    }

    public static function getValue($arg) {
        $enumsArr = PaymentStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = PaymentStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}