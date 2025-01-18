<?php

namespace App\Models\Family;

use CodeIgniter\Model;

class FamilyImageModel extends Model
{

    protected $table = 'family_image';
    protected $primaryKey = 'FamilyId';
    protected $allowedFields = [
        'FamilyId',
        'FamilyImageFileFk',
    ];

    // SQL
    protected $sqlFile = 'SELECT
                            fi.FamilyId AS Id,
                            fi.FamilyImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            family_image fi
                            JOIN file f ON fi.FamilyImageFileFk = f.FileId 
                        WHERE
                            fi.FamilyId = :familyId:;';


}
