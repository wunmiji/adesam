<?php

namespace App\Enums;

enum TagType : string {

    case CONTACT = 'Contact';
    case PRODUCT = 'Product';
    case OCCASION = 'Occasion';


    public static function getValue($arg) {
        $enumsArr = TagType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }


    public static function getAll(): array {
        $types = array();
        $enumsArr = TagType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
    
}