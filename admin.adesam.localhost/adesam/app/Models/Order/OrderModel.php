<?php

namespace App\Models\Order;

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
        'OrderPaymentsStatus',
        'CreatedDateTime',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(OrderId) AS COUNT FROM adesam.order';
    protected $sqlDelete = 'DELETE FROM adesam.order WHERE OrderId = :orderId:;';
    protected $sqlPrice = 'SELECT OrderTotal FROM adesam.order WHERE OrderId = :orderId:;';

    protected $sqlTable = 'SELECT
                                o.OrderId,
                                o.OrderNumber,
                                o.OrderStatus,
                                o.OrderTotal,
                                o.OrderPaymentStatus,
                                o.OrderDate,
                                o.OrderUserFk AS UserId,
                                CONCAT(u.UserFirstName, " ", u.UserLastName) AS UserName
                            FROM
                                adesam.order o
                                JOIN user u ON u.UserId = o.OrderUserFk
                            ORDER BY 
                                o.OrderId 
                            DESC
                            LIMIT 
                                :from:, :to:;';


    protected $sqlRetrieve = 'SELECT
                                o.OrderId,
                                o.OrderNumber,
                                o.OrderStatus,
                                o.OrderSubtotal,
                                o.OrderTotal,
                                o.OrderInstruction,
                                o.OrderPaymentStatus,
                                o.OrderDeliveryStatus,
                                o.OrderDate,
                                o.CreatedDateTime,
                                o.ModifiedDateTime,
                                o.OrderUserFk AS UserId,
                                CONCAT(u.UserFirstName, " ", u.UserLastName) AS UserName,
                                u.UserEmail
                            FROM
                                adesam.order o
                                JOIN user u ON u.UserId = o.OrderUserFk
                            WHERE
                                o.OrderId = :orderId:;';

    protected $sqlRecent = 'SELECT
                                o.OrderId,
                                o.OrderNumber,
                                o.OrderStatus,
                                o.OrderTotal,
                                o.OrderDate,
                                o.OrderUserFk AS UserId,
                                CONCAT(u.UserFirstName, " ", u.UserLastName) AS UserName,
                                (SELECT COUNT(OrderItemsId) FROM order_items WHERE OrderItemsOrderFk = o.OrderId) AS CountOrderItems
                            FROM
                                adesam.order o
                                JOIN user u ON u.UserId = o.OrderUserFk
                            ORDER BY 
                                o.OrderDate 
                            DESC
                            LIMIT 5;';


    protected $orderPerMonth = 'SELECT 
	                                DISTINCT DATE_FORMAT(OrderDate, "%b") AS x,
	                                (SELECT COUNT(OrderId) 
		                                FROM 
                                            adesam.order
		                                WHERE 
			                                DATE_FORMAT(OrderDate, "%b") = x
                                            AND 
                                            DATE_FORMAT(OrderDate, "%Y") = :year:
	                                ) AS y
                                FROM 
	                                adesam.order 
                                WHERE
	                                DATE_FORMAT(OrderDate, "%Y") = :year:;';


    protected $sqlUserOrders = 'SELECT
                                o.OrderId,
                                o.OrderNumber,
                                o.OrderStatus,
                                o.OrderTotal,
                                o.OrderDate,
                                (SELECT COUNT(OrderItemsId) FROM order_items WHERE OrderItemsOrderFk = o.OrderId) AS CountOrderItems
                            FROM
                                adesam.order o
                                JOIN user u ON u.UserId = o.OrderUserFk
                            WHERE
                                u.UserId = :userId:
                            ORDER BY 
                                o.OrderId DESC;';

}
