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
    protected $sqlId = 'SELECT CategoryId FROM category ORDER BY CategoryId DESC LIMIT :from:, :to:';
    protected $sqlCount = 'SELECT COUNT(CategoryId) AS COUNT FROM category';
    protected $sqlDelete = 'DELETE FROM category WHERE CategoryId = :categoryId:;';

    protected $sqlList = 'SELECT
                                CategoryId,
                                CategoryName,
                                CategorySlug,
                                CategoryDescription,
                                (SELECT 
                                        count(ProductId) 
                                    FROM 
                                        product_category 
                                    WHERE 
                                        ProductCategoryCategoryFk = CategoryId) 
                                    as CountProducts
                            FROM
                                category 
                            ORDER BY 
                                CategoryId
                            DESC;';
    protected $sqlListFilter = 'SELECT
                                CategoryId,
                                CategoryName,
                                CategorySlug,
                                (SELECT 
                                        count(ProductId) 
                                    FROM 
                                        product_category 
                                    WHERE 
                                        ProductCategoryCategoryFk = CategoryId) 
                                    as CountProducts
                            FROM
                                category 
                            ORDER BY 
                                CategoryId
                            DESC;';
    protected $sqlRetrieve = 'SELECT
                                CategoryId,
                                CategoryName,
                                CategorySlug,
                                CategoryDate,
                                CategoryDescription
                            FROM
                                category
                            WHERE
                                CategorySlug = :categorySlug:;';
    

}
