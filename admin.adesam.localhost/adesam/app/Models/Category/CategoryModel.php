<?php

namespace App\Models\Category;

use CodeIgniter\Model;

class CategoryModel extends Model
{

    protected $table = 'category';
    protected $primaryKey = 'CategoryId';
    protected $allowedFields = [
        'CategoryId',
        'CategoryName',
        'CategorySlug',
        'CategoryDescription',
        'CategoryDate',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(CategoryId) AS COUNT FROM category';
    protected $sqlDelete = 'DELETE FROM category WHERE CategoryId = :categoryId:;';
    protected $sqlTable = 'SELECT
                                CategoryId,
                                CategoryName,
                                CategoryDate,
                                (SELECT 
                                        count(ProductId) 
                                    FROM 
                                        product_category 
                                    WHERE 
                                        ProductCategoryCategoryFk = CategoryId) 
                                        as CountProduct,
                                CategoryDescription
                            FROM
                                category 
                            ORDER BY 
                                CategoryId
                            DESC 
                            LIMIT 
                                :from:, :to:;';
    protected $sqlRetrieve = 'SELECT
                                CategoryId,
                                CategoryName,
                                CategorySlug,
                                CategoryDate,
                                (SELECT count(ProductId) 
                                    FROM product_category 
                                    WHERE ProductCategoryCategoryFk = CategoryId) 
                                    as CountProduct,
                                CategoryDescription,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                c.CreatedDateTime,
                                c.CreatedId,
                                me.FamilyFirstName AS ModifiedByFirstName,
                                me.FamilyLastName AS ModifiedByLastName,
                                c.ModifiedDateTime,
                                c.ModifiedId
                            FROM
                                category c
                                JOIN family ce ON c.CreatedId = ce.FamilyId
                                LEFT JOIN family me ON c.ModifiedId = me.FamilyId
                            WHERE
                                CategoryId = :categoryId:;';
    

    protected $sqlSumProductQuantity = 'SELECT sum(p.ProductQuantity) as SumProductQuantity 
									    FROM product p
                                        JOIN product_category pc ON pc.ProductId = p.ProductId
								        WHERE pc.ProductCategoryCategoryFk = :categoryId:';

    protected $sqlSumProductPrice = 'SELECT sum(p.ProductActualSellingPrice) as SumProductPrice 
									    FROM product p
                                        JOIN product_category pc ON pc.ProductId = p.ProductId
									    WHERE pc.ProductCategoryCategoryFk = :categoryId:';


}
