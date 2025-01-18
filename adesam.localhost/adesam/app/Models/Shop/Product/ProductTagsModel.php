<?php

namespace App\Models\Shop\Product;

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
                            t.TagName,
                            t.TagSlug
                        FROM
                            product_tags pt
                            JOIN tag t ON t.TagId = pt.ProductTagTagFk 
                        WHERE
                            pt.ProductTagProductFk = :productId:;';



}
