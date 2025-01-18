<?php

namespace App\Models\Contact;

use CodeIgniter\Model;

class ContactAddtionalInformationsModel extends Model
{

    protected $table = 'contact_additional_informations';
    protected $primaryKey = 'ContactAddtionalInformationsId';
    protected $allowedFields = [
        'ContactAddtionalInformationsId',
        'ContactAddtionalInformationsContactFk',
        'ContactAddtionalInformationsField',
        'ContactAddtionalInformationsLabel',
    ];

    // SQL
    protected $sqlAddtionalInformations = 'SELECT
                                            ContactAddtionalInformationsId AS Id,
                                            ContactAddtionalInformationsContactFk AS ContactId,
                                            ContactAddtionalInformationsField,
                                            ContactAddtionalInformationsLabel
                                        FROM
                                            contact_additional_informations 
                                        WHERE
                                            ContactAddtionalInformationsContactFk = :contactId:;';

}
