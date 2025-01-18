<?php

namespace App\Models\Family;

use CodeIgniter\Model;

class FamilySecretResetModel extends Model
{

    protected $table = 'family_secret_reset';
    protected $primaryKey = 'FamilyId';
    protected $allowedFields = [
        'FamilyId',
        'FamilySecretResetToken',
        'FamilySecretExpiresAt'
    ];

    // SQL
    protected $sqlSecretReset = 'SELECT
                                FamilyId,
                                FamilySecretResetToken,
                                FamilySecretExpiresAt
                            FROM
                                family_secret_reset 
                            WHERE
                                FamilyId = :familyId:;';

    protected $sqlToken = 'SELECT 
                                FamilyId, 
                                FamilySecretExpiresAt
                            FROM 
                                family_secret_reset 
                            WHERE 
                                FamilySecretResetToken = :familySecretResetToken:';




}
