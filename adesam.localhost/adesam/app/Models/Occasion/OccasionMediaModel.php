<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionMediaModel extends Model
{

    protected $table = 'occasion_media';
    protected $primaryKey = 'OccasionMediaId';
    protected $allowedFields = [
        'OccasionMediaId',
        'OccasionMediaOccasionFk',
        'OccasionMediaFileFk'
    ];

    // SQL
    protected $sqlMedia = 'SELECT
                            om.OccasionMediaId,
                            om.OccasionMediaOccasionFk AS OccasionId,
                            om.OccasionMediaFileFk  AS FileId, 
                            f.FileName,
                            f.FileUrlPath,
                            f.FileMimeType
                        FROM
                            occasion_media om
                            JOIN file f ON om.OccasionMediaFileFk = f.FileId 
                        WHERE
                            om.OccasionMediaOccasionFk = :occasionId:;';



}
