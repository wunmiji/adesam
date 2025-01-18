<?php

namespace App\Models\Category;

use CodeIgniter\Model;

class CategoryImageModel extends Model
{

    protected $table = 'category_image';
    protected $primaryKey = 'CategoryId';
    protected $allowedFields = [
        'CategoryId',
        'CategoryImageFileFk',
    ];

    // SQL
    protected $sqlImage = 'SELECT
                            ci.CategoryId AS Id,
                            ci.CategoryImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            category_image ci
                            JOIN file f ON ci.CategoryImageFileFk = f.FileId 
                        WHERE
                            ci.CategoryId = :categoryId:;';


}
