<?php

namespace App\Models\Product;

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

    protected $sqlProducts = 'SELECT
                                pd.ProductId AS ProductId,
                                p.ProductName,
                                pi.ProductImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                product_discount pd
                                JOIN product p ON p.ProductId = pd.ProductId 
                                LEFT JOIN product_image pi ON pi.ProductId = pd.ProductId 
                                LEFT JOIN file f ON pi.ProductImageFileFk = f.FileId 
                            WHERE
                                pd.ProductDiscountDiscountFk = :discountId:;';

}
