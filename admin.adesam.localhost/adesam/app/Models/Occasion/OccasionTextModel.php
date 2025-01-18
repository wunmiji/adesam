<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionTextModel extends Model
{

    protected $table = 'occasion_text';
    protected $primaryKey = 'OccasionId';
    protected $allowedFields = [
        'OccasionId',
        'OccasionText',
    ];

    // SQL
    protected $sqlText = 'SELECT
                            OccasionId,
                            OccasionText
                        FROM
                            occasion_text 
                        WHERE
                            OccasionId = :occasionId:;';

}
