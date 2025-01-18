<?php

namespace App\Models\Shop\Product;

use CodeIgniter\Model;

class ProductCategoryModel extends Model
{

    protected $table = 'product_category';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductCategoryCategoryFk',
    ];

    // SQL
    protected $sqlId = 'SELECT ProductId AS Id FROM product_category WHERE ProductId = :productId:';
    protected $sqlCategory = 'SELECT
                                pc.ProductId AS Id,
                                pc.ProductCategoryCategoryFk AS CategoryId,
                                c.CategoryName,
                                c.CategorySlug
                            FROM
                                product_category pc
                                JOIN category c ON c.CategoryId = pc.ProductCategoryCategoryFk 
                            WHERE
                                pc.ProductId = :productId:;';


}
