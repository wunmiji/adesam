<?php

namespace App\Models\Shop\Order;

use CodeIgniter\Model;

class OrderModel extends Model
{

    protected $table = 'order';
    protected $primaryKey = 'OrderId';
    protected $allowedFields = [
        'OrderId',
        'OrderUserFk',
        'OrderNumber',
        'OrderSubtotal',
        'OrderStatus',
        'OrderPaymentStatus',
        'OrderDeliveryStatus',
        'OrderInstruction',
        'OrderTotal',
        'OrderDate',
        'CreatedDateTime',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT OrderId AS Id FROM order WHERE OrderUserFk = :userId:';
    protected $sqlCount = 'SELECT COUNT(OrderId) AS COUNT FROM order';
    protected $sqlDelete = 'DELETE FROM order WHERE OrderId = :orderId:;';


    protected $sqlRetrieve = 'SELECT
                                OrderId,
                                OrderNumber,
                                OrderStatus,
                                OrderSubtotal,
                                OrderInstruction,
                                OrderTotal,
                                OrderDate,
                                OrderPaymentStatus,
                                OrderDeliveryStatus,
                                OrderUserFk AS UserId,
                                CreatedDateTime
                            FROM
                                adesam.order 
                            WHERE
                                OrderNumber = :number:
                                AND 
                                OrderUserFk = :userId:';

    protected $sqlList = 'SELECT
                                o.OrderId,
                                o.OrderNumber,
                                o.OrderStatus,
                                o.OrderSubtotal,
                                o.OrderInstruction,
                                o.OrderTotal,
                                o.OrderDate,
                                o.OrderUserFk AS UserId,
                                o.CreatedDateTime
                            FROM
                                adesam.order o
                                JOIN user u ON u.UserId = o.OrderUserFk
                            WHERE
                                o.OrderUserFk = :userId:
                            ORDER BY 
                                o.OrderId 
                            DESC;';

}
