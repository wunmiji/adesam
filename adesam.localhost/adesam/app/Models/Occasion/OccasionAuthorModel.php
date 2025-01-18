<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionAuthorModel extends Model
{

    protected $table = 'occasion_author';
    protected $primaryKey = 'OccasionId';
    protected $allowedFields = [
        'OccasionId',
        'OccasionAuthorFamilyFk',
    ];

    // SQL
    protected $sqlAuthor = 'SELECT
                            oa.OccasionId,
                            oa.OccasionAuthorFamilyFk,
                            f.FamilyFirstName AS FirstName,
                            f.FamilyLastName AS LastName,
                            f.FamilyDescription,
                            fi.FamilyImageFileFk AS FileId,
                            file.FileName,
                            file.FileUrlPath
                        FROM
                            occasion_author oa
                            JOIN family f ON oa.OccasionAuthorFamilyFk = f.FamilyId
                            JOIN family_image fi ON oa.OccasionAuthorFamilyFk = fi.FamilyId
                            JOIN file file ON fi.FamilyImageFileFk = file.FileId 
                        WHERE
                            oa.OccasionId = :occasionId:;';

}
