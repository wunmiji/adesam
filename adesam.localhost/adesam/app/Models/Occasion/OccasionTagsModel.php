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
                            t.TagName,
                            t.TagSlug  
                        FROM
                            occasion_tags ot
                            JOIN tag t ON t.TagId = ot.OccasionTagTagFk 
                        WHERE
                            ot.OccasionTagOccasionFk = :occasionId:;';



}
