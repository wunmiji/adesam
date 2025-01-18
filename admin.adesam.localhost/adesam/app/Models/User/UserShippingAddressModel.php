<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserShippingAddressModel extends Model
{

    protected $table = 'user_shipping_address';
    protected $primaryKey = 'UserShippingAddressId';
    protected $allowedFields = [
        'UserShippingAddressId',
        'UserShippingAddressUserFk',
        'UserFirstName',
        'UserLastName',
        'UserEmail',
        'UserNumber',
        'UserAddressAddressOne',
        'UserAddressAddressTwo',
        'UserAddressPostalCode',
        'UserAddressCity',
        'UserAddressStateName',
        'UserAddressStateCode',
        'UserAddressCountryName',
        'UserAddressCountryCode',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlAddress = 'SELECT
                            UserShippingAddressId AS Id,
                            UserShippingAddressUserFk AS UserId,
                            UserFirstName,
                            UserLastName,
                            UserEmail,
                            UserNumber,
                            UserAddressAddressOne,
                            UserAddressAddressTwo,
                            UserAddressPostalCode,
                            UserAddressCity,
                            UserAddressStateName,
                            UserAddressStateCode,
                            UserAddressCountryName,
                            UserAddressCountryCode,
                            CreatedDateTime
                        FROM
                            user_shipping_address 
                        WHERE
                            UserShippingAddressUserFk = :userId:;';


}
