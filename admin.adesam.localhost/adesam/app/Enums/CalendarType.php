<?php

namespace App\Enums;

enum CalendarType : string {

    case BIRTHDAY = 'Birthday';
    case EVENT = 'Event';
    case HOLIDAY = 'Holiday';



    public function color(): string {
        return match($this) {
            CalendarType::BIRTHDAY => '#741B47',   
            CalendarType::EVENT => '#E0115F',   
            CalendarType::HOLIDAY => '#CE7E00',   
        };
    }

    public static function getColor($arg): string {
        return match($arg) {
            CalendarType::BIRTHDAY->name => '#741B47',   
            CalendarType::EVENT->name => '#E0115F',   
            CalendarType::HOLIDAY->name => '#CE7E00',
        };
    }

    public static function getValue($arg) {
        $enumsArr = CalendarType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }


    public static function getAll(): array {
        $types = array();
        $enumsArr = CalendarType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
    
}