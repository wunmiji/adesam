<?php

namespace App\Models\Shop\Product;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected $table = 'product';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductUnique',
        'ProductName',
        'ProductDiscription',
        'ProductSku',
        'ProductPublishedDate',
        'ProductQuantity',
        'ProductCostPrice',
        'ProductSellingPrice',
        'ProductActualSellingPrice',
        'ProductStockStatus',
        'ProductVisibilityStatus',
    ];

    // SQL
    protected $sqlId = 'SELECT ProductId AS Id FROM product WHERE ProductUnique = :productUnique:';
    protected $sqlDelete = 'DELETE FROM product WHERE ProductId = :productId:;';

    protected $sqlUnique = 'SELECT
                                p.ProductId,
                                p.ProductName,
                                p.ProductSku,
                                p.ProductStockStatus,
                                p.ProductVisibilityStatus,
                                p.ProductQuantity,
                                p.ProductCostPrice,
                                p.ProductSellingPrice,
                                p.ProductActualSellingPrice,
                                p.ProductUnique,
                                p.ProductDescription
                            FROM
                                product p
                            WHERE
                                p.ProductUnique = :productUnique:;';


    protected $sqlRelated = 'SELECT 
                                p.ProductId,
                                p.ProductName,
                                p.ProductStockStatus,
                                p.ProductSellingPrice,
                                p.ProductActualSellingPrice,
                                p.ProductUnique
                            FROM 
                                product p  
                                JOIN product_tags pt ON p.ProductId = pt.ProductTagProductFk 
                            WHERE 
                                p.ProductVisibilityStatus = "PUBLISHED"
                                AND
                                pt.ProductTagTagFk = :productTagTagFk:
                            LIMIT 2';

    protected $sqlQuantity = 'SELECT 
                                    ProductQuantity AS Quantity 
                                FROM 
                                    product 
                                WHERE 
                                    ProductId = :productId:
                                    AND
                                    ProductStatus = "IN_STOCK";';



}
