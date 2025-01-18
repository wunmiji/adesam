<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionTagsModel extends Model
{

    protected $table = 'occasion_tags';
    protected $primaryKey = 'OccasionTagId';
    protected $allowedFields = [
        'OccasionTagId',
        'OccasionTagOccasionFk',
        'OccasionTagTagFk'
    ];

    // SQL
    protected $sqlTags = 'SELECT
                            ot.OccasionTagId AS Id,
                            ot.OccasionTagOccasionFk AS OccasionId,
                            ot.OccasionTagTagFk AS TagId,
                            t.TagName 
                        FROM
                            occasion_tags ot
                            JOIN tag t ON t.TagId = ot.OccasionTagTagFk 
                        WHERE
                            ot.OccasionTagOccasionFk = :occasionId:;';


    protected $sqlOccasions = 'SELECT
                                ot.OccasionTagId AS Id,
                                ot.OccasionTagOccasionFk AS OccasionId,
                                o.OccasionTitle,
                                oi.OccasionImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                occasion_tags ot
                                JOIN occasion o ON o.OccasionId = ot.OccasionTagOccasionFk 
                                LEFT JOIN occasion_image oi ON oi.OccasionId = ot.OccasionTagOccasionFk 
                                LEFT JOIN file f ON oi.OccasionImageFileFk = f.FileId 
                            WHERE
                                ot.OccasionTagTagFk = :tagId:;';



}
