<?php

namespace App\Models\Order;

use CodeIgniter\Model;

class OrderPaymentsModel extends Model
{

    protected $table = 'order_payments';
    protected $primaryKey = 'OrderPaymentsId';
    protected $allowedFields = [
        'OrderPaymentsId',
        'OrderPaymentsOrderFk',
        'OrderPaymentsName',
        'OrderPaymentsAmount',
        'OrderPaymentsStatus',
        'OrderPaymentsMethod',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlSumAmount = 'SELECT SUM(OrderPaymentsAmount) FROM order_payments WHERE OrderPaymentsStatus = "COMPLETED" AND OrderPaymentsOrderFk = :orderId:;';

    protected $sqlPayments = 'SELECT
                                OrderPaymentsId AS Id,
                                OrderPaymentsOrderFk AS OrderId,
                                OrderPaymentsName,
                                OrderPaymentsAmount,
                                OrderPaymentsStatus,
                                OrderPaymentsMethod,
                                CreatedDateTime
                            FROM
                                order_payments 
                            WHERE
                                OrderPaymentsOrderFk = :orderId:;';


    protected $sqlRecentPayments = 'SELECT
                                op.OrderPaymentsId AS Id,
                                op.OrderPaymentsOrderFk AS OrderId,
                                op.OrderPaymentsName,
                                o.OrderNumber,
                                op.OrderPaymentsAmount,
                                op.OrderPaymentsStatus,
                                op.OrderPaymentsMethod,
                                op.CreatedDateTime
                            FROM
                                order_payments op
                                JOIN adesam.order o ON o.OrderId = op.OrderPaymentsOrderFk
                            ORDER BY 
                                op.OrderPaymentsId 
                            DESC
                            LIMIT 5;';

}
