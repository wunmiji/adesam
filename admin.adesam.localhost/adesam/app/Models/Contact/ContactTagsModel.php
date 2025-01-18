<?php

namespace App\Models\Contact;

use CodeIgniter\Model;

class ContactTagsModel extends Model
{

    protected $table = 'contact_tags';
    protected $primaryKey = 'ContactTagId';
    protected $allowedFields = [
        'ContactTagId',
        'ContactTagTagFk',
        'ContactTagContactFk'
    ];

    // SQL
    protected $sqlTags = 'SELECT
                                ct.ContactTagId AS Id,
                                ct.ContactTagTagFk AS TagId,
                                ct.ContactTagContactFk AS ContactId,
                                t.TagName
                            FROM
                                contact_tags ct
                                JOIN tag t ON t.TagId = ct.ContactTagTagFk 
                            WHERE
                                ct.ContactTagContactFk = :contactId:;';

    protected $sqlContacts = 'SELECT
                                ct.ContactTagId AS Id,
                                ct.ContactTagContactFk AS ContactId,
                                c.ContactNickName,
                                ci.ContactImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                contact_tags ct
                                JOIN contact c ON c.ContactId = ct.ContactTagContactFk 
                                LEFT JOIN contact_image ci ON ci.ContactId = ct.ContactTagContactFk 
                                LEFT JOIN file f ON ci.ContactImageFileFk = f.FileId 
                            WHERE
                                ct.ContactTagTagFk = :tagId:;';

}
