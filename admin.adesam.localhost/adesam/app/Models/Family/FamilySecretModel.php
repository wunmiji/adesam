<?php

namespace App\Models\Family;

use CodeIgniter\Model;

class FamilySecretModel extends Model {

    protected $table            = 'family_secret';
    protected $primaryKey       = 'FamilyId';
    protected $allowedFields    = ['FamilyId', 'FamilySecretPassword', 'FamilySecretSalt'];

    // SQL
    protected $sqlSecret = 'SELECT
                                FamilyId,
                                FamilySecretPassword,
                                FamilySecretSalt
                            FROM
                                family_secret 
                            WHERE
                                FamilyId = :familyId:;';




}
