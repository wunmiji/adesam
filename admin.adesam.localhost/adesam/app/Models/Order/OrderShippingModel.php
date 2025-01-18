<?php

namespace App\Models\Order;

use CodeIgniter\Model;

class OrderShippingModel extends Model
{

    protected $table = 'order_shipping';
    protected $primaryKey = 'OrderId';
    protected $allowedFields = [
        'OrderId',
        'OrderShippingType',
        'OrderShippingPrice',
    ];

    // SQL
    protected $sqlShipping = 'SELECT
                            OrderId AS Id,
                            OrderShippingType,
                            OrderShippingPrice
                        FROM
                            order_shipping 
                        WHERE
                            OrderId = :orderId:;';

}
