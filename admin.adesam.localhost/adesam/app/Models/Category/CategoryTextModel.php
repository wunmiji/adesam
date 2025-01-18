<?php

namespace App\Models\Category;

use CodeIgniter\Model;

class CategoryTextModel extends Model
{

    protected $table = 'category_text';
    protected $primaryKey = 'CategoryId';
    protected $allowedFields = [
        'CategoryId',
        'CategoryText',
    ];

    // SQL
    protected $sqlText = 'SELECT
                            CategoryId,
                            CategoryText
                        FROM
                            category_text 
                        WHERE
                            CategoryId = :categoryId:;';

}
