<?php

namespace App\Enums;

enum ShippingType : string {

    case LOCAL_PICKUP = 'Local Pickup';
    case FLAT_RATE = 'Flat Rate';
    
    
    

    public static function getValue($arg) {
        $enumsArr = ShippingType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = ShippingType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}