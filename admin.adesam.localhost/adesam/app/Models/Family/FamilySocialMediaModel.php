<?php

namespace App\Models\Family;

use CodeIgniter\Model;

class FamilySocialMediaModel extends Model
{

    protected $table = 'family_social_media';
    protected $primaryKey = 'FamilyId';
    protected $allowedFields = [
        'FamilyId',
        'FamilySocialFacebook',
        'FamilySocialInstagram',
        'FamilySocialLinkedIn',
        'FamilySocialTwitter',
        'FamilySocialYoutube',
    ];

    // SQL
    protected $sqlSocialMedia = 'SELECT
                                    FamilyId,
                                    FamilySocialFacebook,
                                    FamilySocialInstagram,
                                    FamilySocialLinkedIn,
                                    FamilySocialTwitter,
                                    FamilySocialYoutube
                                FROM
                                    family_social_media 
                                WHERE
                                    FamilyId = :familyId:;';



}
