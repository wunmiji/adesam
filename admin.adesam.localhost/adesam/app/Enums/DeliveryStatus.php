<?php

namespace App\Enums;

enum DeliveryStatus : string {

    case PENDING = 'Pending';
    case PROCESSING = 'Processing';
    case DELIVERED = 'Delivered';
    case CANCEL = 'Cancel';
    case RETURN = 'Return';
    case DISPATCHED = 'Dispatched';
    case ON_DELIVERY = 'On Delivery';
    case DECLINED = 'Declined';
    case CONFIRMED = 'Confirmed';


    public function color(): string {
        return match($this) {
            DeliveryStatus::PROCESSING => '#13DEB9',   
            DeliveryStatus::PENDING => '#E0115F',   
            DeliveryStatus::DELIVERED => '#13DEB9',   
            DeliveryStatus::RETURN => '#E0115F',   
            DeliveryStatus::DISPATCHED => '#13DEB9',   
            DeliveryStatus::ON_DELIVERY => '#E0115F',   
            DeliveryStatus::CONFIRMED => '#E0115F',   
            DeliveryStatus::CANCEL => 'grey',
            DeliveryStatus::DECLINED => 'grey'  
        };
    }

    public static function getValue($arg) {
        $enumsArr = DeliveryStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }

    public static function getAll(): array {
        $types = array();
        $enumsArr = DeliveryStatus::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
}