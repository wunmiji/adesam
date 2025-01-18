<?php

namespace App\Models\Order;

use CodeIgniter\Model;

class OrderShippingAddressModel extends Model
{

    protected $table = 'order_shipping_address';
    protected $primaryKey = 'OrderId';
    protected $allowedFields = [
        'OrderId',
        'OrderShippingAddressFirstName',
        'OrderShippingAddressLastName',
        'OrderShippingAddressEmail',
        'OrderShippingAddressNumber',
        'OrderShippingAddressAddressOne',
        'OrderShippingAddressAddressTwo',
        'OrderShippingAddressPostalCode',
        'OrderShippingAddressCity',
        'OrderShippingAddressStateName',
        'OrderShippingAddressStateCode',
        'OrderShippingAddressCountryName',
        'OrderShippingAddressCountryCode'
    ];

    // SQL
    protected $sqlAddress = 'SELECT
                                OrderId AS Id,
                                CONCAT_WS(" ", OrderShippingAddressFirstName, OrderShippingAddressLastName) AS OrderShippingAddressName,
                                OrderShippingAddressEmail,
                                OrderShippingAddressNumber,
                                OrderShippingAddressAddressOne,
                                OrderShippingAddressAddressTwo,
                                OrderShippingAddressPostalCode,
                                OrderShippingAddressCity,
                                OrderShippingAddressStateName,
                                OrderShippingAddressStateCode,
                                OrderShippingAddressCountryName,
                                OrderShippingAddressCountryCode
                            FROM
                                order_shipping_address 
                            WHERE
                                OrderId = :orderId:;';


}
