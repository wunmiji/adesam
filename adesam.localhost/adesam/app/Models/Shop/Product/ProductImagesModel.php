<?php

namespace App\Models\Shop\Product;

use CodeIgniter\Model;

class ProductImagesModel extends Model
{

    protected $table = 'product_images';
    protected $primaryKey = 'ProductImagesId';
    protected $allowedFields = [
        'ProductImagesId',
        'ProductImagesProductFk',
        'ProductImagesFileFk'
    ];

    // SQL
    protected $sqlImages = 'SELECT
                            pi.ProductImagesId AS Id,
                            pi.ProductImagesProductFk AS ProductId,
                            pi.ProductImagesFileFk  AS FileId, 
                            f.FileName,
                            f.FileUrlPath,
                            f.FileMimeType
                        FROM
                            product_images pi
                            JOIN file f ON pi.ProductImagesFileFk = f.FileId 
                        WHERE
                            pi.ProductImagesProductFk = :productId:
                        ORDER BY 
                            ProductImagesId 
                        ASC ;';

}
