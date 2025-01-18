<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserBillingAddressModel extends Model
{

    protected $table = 'user_billing_address';
    protected $primaryKey = 'UserBillingAddressId';
    protected $allowedFields = [
        'UserBillingAddressId',
        'UserBillingAddressUserFk',
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
    protected $sqlDelete = 'DELETE FROM user_billing_address WHERE UserBillingAddressId = :id:;';
    protected $sqlAddress = 'SELECT
                                        UserBillingAddressId AS Id,
                                        UserBillingAddressUserFk AS UserId,
                                        UserFirstName,
                                        UserLastName,
                                        CONCAT_WS(" ", UserFirstName, UserLastName) AS UserName,
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
                                        user_billing_address 
                                    WHERE
                                        UserBillingAddressUserFk = :userId:;';


}
