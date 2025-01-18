<?php

namespace App\Models\Family;

use CodeIgniter\Model;

class FamilyModel extends Model
{

    protected $table = 'family';
    protected $primaryKey = 'FamilyId';
    protected $allowedFields = [
        'FamilyId',
        'FamilyFirstName',
        'FamilyMiddleName',
        'FamilyMiddleName',
        'FamilyRole',
        'FamilyEmail',
        'FamilyMobile',
        'FamilyTelephone',
        'FamilyGender',
        'FamilyDob',
        'FamilyLastName',
        'FamilyDescription',
        'CreatedDateTime',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlList = 'SELECT
                                FamilyId,
                                FamilyFirstName,
                                FamilyLastName,
                                FamilyRole,
                                FamilyDescription
                            FROM
                                family 
                            ORDER BY 
                                FamilyId DESC;';
    protected $sqlFamily = 'SELECT
                                FamilyId,
                                FamilyFirstName,
                                FamilyMiddleName,
                                FamilyLastName,
                                FamilyRole,
                                FamilyEmail,
                                FamilyMobile,
                                FamilyTelephone,
                                FamilyDescription,
                                FamilyGender,
                                FamilyDob,
                                CreatedDateTime,
                                ModifiedDateTime
                            FROM
                                family 
                            WHERE
                                FamilyId = :familyId:;';
    protected $sqlEmail = 'SELECT 
                                FamilyId 
                            FROM 
                                family  
                            WHERE 
                                FamilyEmail = :email:;';

    protected $sqlSession = 'SELECT 
                                CONCAT_WS(" ", family.FamilyFirstName, family.FamilyLastName) AS name,
                                file.FileName AS fileAlt,
                                file.FileUrlPath AS fileSrc
                            FROM 
                                family  
                                JOIN family_image ON family.FamilyId = family_image.FamilyId 
                                JOIN file  ON FamilyImageFileFk = FileId 
                            WHERE 
                                family.FamilyId = :familyId:;';

}
