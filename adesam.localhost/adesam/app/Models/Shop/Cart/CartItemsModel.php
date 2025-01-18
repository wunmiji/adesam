<?php

namespace App\Models\Shop\Cart;

use CodeIgniter\Model;

class CartItemsModel extends Model
{

    protected $table = 'cart_items';
    protected $primaryKey = 'CartItemsId';
    protected $allowedFields = [
        'CartItemsId',
        'CartItemsCartFk',
        'CartItemsProductFk',
        'CartItemsQuantity',
    ];

    // SQL
    protected $sqlItemId = 'SELECT CartItemsId AS Id FROM cart_items WHERE CartItemsCartFk = :cartId: AND CartItemsProductFk = :productId:;';
    protected $sqlDelete = 'DELETE FROM cart_items WHERE CartItemsProductFk = :productId:;';
    protected $sqlDeleteAll = 'DELETE FROM cart_items WHERE CartItemsCartFk = :cartId:;';
    protected $sqlItems = 'SELECT
                                ci.CartItemsId AS Id,
                                ci.CartItemsCartFk AS CartId,
                                ci.CartItemsProductFk AS ProductId,
                                ci.CartItemsQuantity,
                                p.ProductUnique,
                                p.ProductName,
                                p.ProductActualSellingPrice,
                                pi.ProductImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                cart_items ci
                                JOIN product p ON p.ProductId = ci.CartItemsProductFk
                                JOIN product_image pi ON pi.ProductId = p.ProductId
                                JOIN file f ON pi.ProductImageFileFk = f.FileId
                            WHERE
                                ci.CartItemsCartFk = :cartId:;';


protected $sqlItem = 'SELECT
                                CartItemsId AS Id,
                                CartItemsCartFk AS CartId,
                                CartItemsProductFk AS ProductId,
                                CartItemsQuantity
                            FROM
                                cart_items 
                            WHERE
                                CartItemsId = :id:;';

}
