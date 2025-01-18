<?php

namespace App\Enums;

enum ProductVisibilityStatus : string {

    case HIDDEN = 'Hidden';
    case PUBLISHED = 'Published';
    
    public function color(): string {
        return match($this) {
            ProductVisibilityStatus::HIDDEN => '#13DEB9',   
            ProductVisibilityStatus::PUBLISHED => '#E0115F',   
        };
    }

    public static function getValue($arg) {
        $enumsArr = ProductVisibilityStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = ProductVisibilityStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}