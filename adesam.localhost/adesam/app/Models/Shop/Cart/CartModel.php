<?php

namespace App\Models\Shop\Cart;

use CodeIgniter\Model;

class CartModel extends Model
{

    protected $table = 'cart';
    protected $primaryKey = 'CartId';
    protected $allowedFields = [
        'CartId',
        'CartUserUserFk',
        'CartShippingType',
        'CartPaymentMethod'
    ];

    // SQL
    protected $sqlId = 'SELECT CartId AS Id FROM cart WHERE CartUserUserFk = :userId:';
    protected $sqlCount = 'SELECT COUNT(CartId) AS COUNT FROM cart';
    protected $sqlDelete = 'DELETE FROM cart WHERE CartId = :cartId:;';

    protected $sqlRetrieve = 'SELECT
                                c.CartId,
                                c.CartShippingType,
                                c.CartPaymentMethod,
                                c.CartUserUserFk AS UserId
                            FROM
                                cart c
                                JOIN user u ON u.UserId = c.CartUserUserFk
                            WHERE
                                c.CartUserUserFk = :userId:
                            ORDER BY 
                                CartId 
                            DESC;';

}
