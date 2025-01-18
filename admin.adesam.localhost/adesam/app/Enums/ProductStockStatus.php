<?php

namespace App\Enums;

enum ProductStockStatus : string {

    case IN_STOCK = 'In Stock';
    case OUT_OF_STOCK = 'Out of Stock';
    
    public function color(): string {
        return match($this) {
            ProductStockStatus::IN_STOCK => '#13DEB9',   
            ProductStockStatus::OUT_OF_STOCK => '#E0115F',   
        };
    }

    public static function getValue($arg) {
        $enumsArr = ProductStockStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = ProductStockStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}