<?php

namespace App\Models\Product;

use CodeIgniter\Model;

class ProductImageModel extends Model
{

    protected $table = 'product_image';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = [
        'ProductId',
        'ProductImageFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            pi.ProductId AS Id,
                            pi.ProductImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            product_image pi
                            JOIN file f ON pi.ProductImageFileFk = f.FileId 
                        WHERE
                            pi.ProductId = :productId:;';


}
