<?php

namespace App\Models\Product;

use CodeIgniter\Model;

class ProductTagsModel extends Model
{

    protected $table = 'product_tags';
    protected $primaryKey = 'ProductTagId';
    protected $allowedFields = [
        'ProductTagId',
        'ProductTagProductFk',
        'ProductTagTagFk'
    ];

    // SQL
    protected $sqlTags = 'SELECT
                            pt.ProductTagId AS Id,
                            pt.ProductTagProductFk AS ProductId,
                            pt.ProductTagTagFk AS TagId,
                            t.TagName 
                        FROM
                            product_tags pt
                            JOIN tag t ON t.TagId = pt.ProductTagTagFk 
                        WHERE
                            pt.ProductTagProductFk = :productId:;';


    protected $sqlProducts = 'SELECT
                                pt.ProductTagId AS Id,
                                pt.ProductTagProductFk AS ProductId,
                                p.ProductName,
                                pi.ProductImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                product_tags pt
                                JOIN product p ON p.ProductId = pt.ProductTagProductFk 
                                LEFT JOIN product_image pi ON pi.ProductId = pt.ProductTagProductFk 
                                LEFT JOIN file f ON pi.ProductImageFileFk = f.FileId 
                            WHERE
                                pt.ProductTagTagFk = :tagId:;';



}
