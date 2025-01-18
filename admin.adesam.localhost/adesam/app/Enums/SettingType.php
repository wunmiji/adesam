<?php

namespace App\Enums;

enum SettingType : string {

    case CONTACT = 'Contact';
    case SHOP = 'Shop';
    case FILE = 'File';
    case DEVELOPER = 'Developer';
    case GENERAL = 'General';
    case CALENDAR = 'Calendar';


    public static function getValue($arg) {
        $enumsArr = SettingType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }


    public static function getAll(): array {
        $types = array();
        $enumsArr = SettingType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
    
}