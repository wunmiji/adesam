<?php

namespace App\Enums;

enum CalendarRecurringType : string {

    case YEARLY = 'Yearly';
    case MONTHLY = 'Monthly';
    case WEEKLY = 'Weekly';
    case null = 'None';



    public function color(): string {
        return match($this) {
            CalendarRecurringType::YEARLY => '#741B47',   
            CalendarRecurringType::MONTHLY => '#E0115F',   
            CalendarRecurringType::WEEKLY => '#CE7E00',    
        };
    }

    public static function getValue($arg) {
        $enumsArr = CalendarRecurringType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }


    public static function getAll(): array {
        $types = array();
        $enumsArr = CalendarRecurringType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
    
}