<?php

namespace App\Models\Shop\Product;

use CodeIgniter\Model;

class ProductDiscountModel extends Model
{

    protected $table = 'product_discount';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductDiscountDiscountFk',
    ];

    // SQL
    protected $sqlId = 'SELECT ProductId AS Id FROM product_discount WHERE ProductId = :productId:';
    protected $sqlDiscount = 'SELECT
                                        pd.ProductId AS Id,
                                        pd.ProductDiscountDiscountFk AS DiscountId,
                                        d.DiscountName,
                                        d.DiscountType,
                                        d.DiscountValue 
                                    FROM
                                        product_discount pd
                                        LEFT JOIN discount d ON d.DiscountId = pd.ProductDiscountDiscountFk 
                                    WHERE
                                        pd.ProductId = :productId:;';



}
