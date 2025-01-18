<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionImageModel extends Model
{

    protected $table = 'occasion_image';
    protected $primaryKey = 'OccasionId';
    protected $allowedFields = [
        'OccasionId',
        'OccasionImageFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            oi.OccasionId AS Id,
                            oi.OccasionImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            occasion_image oi
                            JOIN file f ON oi.OccasionImageFileFk = f.FileId 
                        WHERE
                            oi.OccasionId = :occasionId:;';


}
