<?php

namespace App\Models\Product;

use CodeIgniter\Model;

class ProductTextModel extends Model
{

    protected $table = 'product_text';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductText',
    ];

    // SQL
    protected $sqlText = 'SELECT
                            ProductId,
                            ProductText
                        FROM
                            product_text 
                        WHERE
                            ProductId = :productId:;';

}
