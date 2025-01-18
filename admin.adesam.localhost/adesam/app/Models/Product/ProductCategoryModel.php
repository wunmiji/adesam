<?php

namespace App\Models\Product;

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
    protected $sqlCategory = 'SELECT
                                pc.ProductId AS Id,
                                pc.ProductCategoryCategoryFk AS CategoryId,
                                c.CategoryName
                            FROM
                                product_category pc
                                JOIN category c ON c.CategoryId = pc.ProductCategoryCategoryFk 
                            WHERE
                                pc.ProductId = :productId:;';


}
