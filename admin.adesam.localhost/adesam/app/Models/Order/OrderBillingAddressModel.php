<?php

namespace App\Models\Order;

use CodeIgniter\Model;

class OrderBillingAddressModel extends Model
{

    protected $table = 'order_billing_address';
    protected $primaryKey = 'OrderId';
    protected $allowedFields = [
        'OrderId',
        'OrderBillingAddressFirstName',
        'OrderBillingAddressLastName',
        'OrderBillingAddressEmail',
        'OrderBillingAddressNumber',
        'OrderBillingAddressAddressOne',
        'OrderBillingAddressAddressTwo',
        'OrderBillingAddressPostalCode',
        'OrderBillingAddressCity',
        'OrderBillingAddressStateName',
        'OrderBillingAddressStateCode',
        'OrderBillingAddressCountryName',
        'OrderBillingAddressCountryCode'
    ];

    // SQL
    protected $sqlAddress = 'SELECT
                                OrderId AS Id,
                                CONCAT_WS(" ", OrderBillingAddressFirstName, OrderBillingAddressLastName) AS OrderBillingAddressName,
                                OrderBillingAddressEmail,
                                OrderBillingAddressNumber,
                                OrderBillingAddressAddressOne,
                                OrderBillingAddressAddressTwo,
                                OrderBillingAddressPostalCode,
                                OrderBillingAddressCity,
                                OrderBillingAddressStateName,
                                OrderBillingAddressStateCode,
                                OrderBillingAddressCountryName,
                                OrderBillingAddressCountryCode
                            FROM
                                order_billing_address 
                            WHERE
                                OrderId = :orderId:;';


}
