<?php

namespace App\Models\Shop\Order;

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
    protected $sqlId = 'SELECT OrderId AS Id FROM order WHERE OrderUserFk = :userId:';
    protected $sqlCount = 'SELECT COUNT(OrderId) AS COUNT FROM order';
    protected $sqlDelete = 'DELETE FROM order WHERE OrderId = :orderId:;';

    protected $sqlPayments = 'SELECT
                                OrderPaymentsId,
                                OrderPaymentsOrderFk,
                                OrderPaymentsName,
                                OrderPaymentsAmount,
                                OrderPaymentsStatus,
                                OrderPaymentsMethod,
                                CreatedDateTime
                            FROM
                                order_payments 
                            WHERE
                                OrderPaymentsOrderFk = :orderId:;';

}
