<?php

namespace App\Models\Shop\Product;

use CodeIgniter\Model;

class ProductAddtionalInformationsModel extends Model
{

    protected $table = 'product_additional_informations';
    protected $primaryKey = 'ProductAddtionalInformationsId';
    protected $allowedFields = [
        'ProductAddtionalInformationsId',
        'ProductAddtionalInformationsProductFk',
        'ProductAddtionalInformationsField',
        'ProductAddtionalInformationsLabel',
    ];

    // SQL
    protected $sqlAddtionalInformations = 'SELECT
                                            ProductAddtionalInformationsId AS Id,
                                            ProductAddtionalInformationsProductFk AS ProductId,
                                            ProductAddtionalInformationsField,
                                            ProductAddtionalInformationsLabel
                                        FROM
                                            product_additional_informations 
                                        WHERE
                                            ProductAddtionalInformationsProductFk = :productId:;';

}
