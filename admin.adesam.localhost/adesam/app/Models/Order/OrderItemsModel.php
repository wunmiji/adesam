<?php

namespace App\Models\Order;

use CodeIgniter\Model;

class OrderItemsModel extends Model
{

    protected $table = 'order_items';
    protected $primaryKey = 'OrderItemsId';
    protected $allowedFields = [
        'OrderItemsId',
        'OrderItemsOrderFk',
        'OrderItemsProductFk',
        'OrderItemsQuantity',
        'OrderItemsPrice',
        'OrderItemsTotal',
    ];

    // SQL
    protected $sqlList = 'SELECT
                                oi.OrderItemsId AS Id,
                                oi.OrderItemsOrderFk AS OrderId,
                                oi.OrderItemsProductFk AS ProductId,
                                oi.OrderItemsQuantity,
                                oi.OrderItemsPrice,
                                oi.OrderItemsTotal,
                                p.ProductName,
                                p.ProductUnique,
                                pi.ProductImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                order_items oi
                                JOIN product p ON p.ProductId = oi.OrderItemsProductFk
                                JOIN product_image pi ON pi.ProductId = p.ProductId
                                JOIN file f ON pi.ProductImageFileFk = f.FileId 
                            WHERE
                                oi.OrderItemsOrderFk = :orderId:
                            ORDER BY 
                                OrderId DESC;';


    protected $sqlOrder = 'SELECT
                                oi.OrderItemsId AS Id,
                                oi.OrderItemsOrderFk AS OrderId,
                                oi.OrderItemsProductFk AS ProductId,
                                oi.OrderItemsQuantity,
                                oi.OrderItemsPrice,
                                oi.OrderItemsTotal,
                                o.OrderNumber,
                                o.OrderDate
                            FROM
                                order_items oi
                                JOIN adesam.order o ON o.OrderId = oi.OrderItemsOrderFk
                                JOIN product p ON p.ProductId = oi.OrderItemsProductFk
                            WHERE
                                oi.OrderItemsProductFk = :productId:
                            ORDER BY 
                                o.OrderDate ASC;';

}
