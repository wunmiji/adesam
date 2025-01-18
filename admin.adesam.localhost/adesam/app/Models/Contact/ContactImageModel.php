<?php

namespace App\Models\Contact;

use CodeIgniter\Model;

class ContactImageModel extends Model
{

    protected $table = 'contact_image';
    protected $primaryKey = 'ContactId';
    protected $allowedFields = [
        'ContactId',
        'ContactImageFileFk',
    ];

    // SQL
    protected $sqlImage = 'SELECT
                            ci.ContactId AS Id,
                            ci.ContactImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            contact_image ci
                            JOIN file f ON ci.ContactImageFileFk = f.FileId 
                        WHERE
                            ci.ContactId = :contactId:;';


}
