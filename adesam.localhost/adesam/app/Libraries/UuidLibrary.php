<?php 

namespace App\Libraries;


use Ramsey\Uuid\Uuid;
/**
 * 
 */
class UuidLibrary {
	
	public static function versionFive ($name) {
        return Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
    }

   
}