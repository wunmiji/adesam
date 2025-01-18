<?php

namespace App\Models\Product;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected $table = 'product';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductName',
        'ProductVisibilityStatus',
        'ProductDescription',
        'ProductSku',
        'ProductUnique',
        'ProductQuantity',
        'ProductCostPrice',
        'ProductSellingPrice',
        'ProductActualSellingPrice',
        'ProductStockStatus',
        'ProductPublishedDate',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlUnique = 'SELECT ProductUnique FROM product WHERE ProductUnique = :productUnique:';
    protected $sqlCount = 'SELECT COUNT(ProductId) AS COUNT FROM product';
    protected $sqlDelete = 'DELETE FROM product WHERE ProductId = :productId:;';
    protected $sqlStatus = 'SELECT ProductStockStatus FROM product WHERE ProductId = :productId:;';
    protected $sqlTable = 'SELECT
                                ProductId,
                                ProductName,
                                ProductVisibilityStatus,
                                ProductStockStatus,
                                ProductActualSellingPrice,
                                ProductQuantity,
                                ProductUnique,
                                ProductDescription
                            FROM
                                product 
                            ORDER BY 
                                ProductId 
                            DESC 
                            LIMIT 
                                :from:, :to:;';
    protected $sqlRetrieve = 'SELECT
                                p.ProductId,
                                p.ProductName,
                                p.ProductSku,
                                p.ProductVisibilityStatus,
                                p.ProductStockStatus,
                                p.ProductQuantity,
                                p.ProductCostPrice,
                                p.ProductSellingPrice,
                                p.ProductActualSellingPrice,
                                p.ProductUnique,
                                p.ProductDescription,
                                p.ProductPublishedDate,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                p.CreatedDateTime,
                                p.CreatedId,
                                me.FamilyFirstName AS ModifiedByFirstName,
                                me.FamilyLastName AS ModifiedByLastName,
                                p.ModifiedDateTime,
                                p.ModifiedId
                            FROM
                                product p
                                JOIN family ce ON p.CreatedId = ce.FamilyId
                                LEFT JOIN family me ON p.ModifiedId = me.FamilyId
                            WHERE
                                p.ProductId = :productId:;';

    protected $sqlCategoryProducts = 'SELECT
                                        p.ProductId,
                                        p.ProductName,
                                        p.ProductVisibilityStatus,
                                        p.ProductStockStatus,
                                        p.ProductQuantity,
                                        p.ProductActualSellingPrice,
                                        p.ProductUnique 
                                    FROM
                                        product p
                                        JOIN product_category pc ON pc.ProductId = p.ProductId
                                    WHERE
                                        pc.ProductCategoryCategoryFk = :categoryId:;';


    protected $productPerMonth = 'SELECT 
	                                DISTINCT DATE_FORMAT(ProductPublishedDate, "%b") AS x,
	                                (SELECT COUNT(ProductId) 
		                                FROM 
                                            product
		                                WHERE 
			                                DATE_FORMAT(ProductPublishedDate, "%b") = x
                                            AND 
                                            DATE_FORMAT(ProductPublishedDate, "%Y") = :year:
	                                ) AS y
                                FROM 
	                                product 
                                WHERE
	                                DATE_FORMAT(ProductPublishedDate, "%Y") = :year:;';


}
