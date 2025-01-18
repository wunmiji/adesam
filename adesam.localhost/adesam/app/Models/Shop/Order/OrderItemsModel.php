<?php

namespace App\Models\Shop\Order;

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
    protected $sqlId = 'SELECT OrderId AS Id FROM order WHERE OrderUserFk = :userId:';
    protected $sqlCount = 'SELECT COUNT(OrderId) AS COUNT FROM order';
    protected $sqlDelete = 'DELETE FROM order WHERE OrderId = :orderId:;';


    protected $sqlRetrieve = 'SELECT
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

    protected $sqlList = 'SELECT
                                oi.OrderItemsId,
                                oi.OrderItemsOrderFk AS OrderId,
                                oi.OrderItemsProductFk AS ProductId,
                                oi.OrderItemsQuantity,
                                oi.OrderItemsPrice,
                                oi.OrderItemsTotal
                            FROM
                                order_items oi
                            WHERE
                                oi.OrderItemsOrderFk = :orderId:
                            ORDER BY 
                                OrderId 
                            DESC;';

}
