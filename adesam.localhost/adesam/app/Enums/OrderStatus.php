<?php

namespace App\Enums;

enum OrderStatus : string {

    case NEW = 'New';
    case IN_PROGRESS = 'InProgress';
    case PAID = 'Paid';
    case PARTIAL_PAID = 'Partial Paid';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';


    public function color(): string {
        return match($this) {
            OrderStatus::NEW => '#13DEB9',   
            OrderStatus::IN_PROGRESS => '#E0115F',   
            OrderStatus::PAID => '#13DEB9',   
            OrderStatus::PARTIAL_PAID => '#E0115F',  
            OrderStatus::CANCELLED => '#E0115F',
            OrderStatus::COMPLETED => '#E0115F',    
        };
    }

    public static function getValue($arg) {
        $enumsArr = OrderStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = OrderStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}