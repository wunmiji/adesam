<?php

namespace App\Enums;

enum OccasionStatus : string {

    case DRAFT = 'Draft';
    case PUBLISHED = 'Published';
    case ARCHIVED = 'Archived';
    case SCHEDULED = 'Scheduled';
    
    public function color(): string {
        return match($this) {
            OccasionStatus::DRAFT => '#8F2D56',   
            OccasionStatus::PUBLISHED => '#A5E3E9',   
            OccasionStatus::ARCHIVED => '#D9305A', 
            OccasionStatus::SCHEDULED => '#F9B13E',   
        };
    }

    public static function getValue($arg) {
        $enumsArr = OccasionStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = OccasionStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}