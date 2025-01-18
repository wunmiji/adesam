<?php

namespace App\Models\Contact;

use CodeIgniter\Model;

class ContactAddressModel extends Model
{

    protected $table = 'contact_address';
    protected $primaryKey = 'ContactId';
    protected $allowedFields = [
        'ContactId',
        'ContactAddressAddress',
        'ContactAddressPostalCode',
        'ContactAddressCountryName',
        'ContactAddressCountryCode'
    ];

    // SQL
    protected $sqlAddress = 'SELECT
                                ContactId,
                                ContactAddressAddress,
                                ContactAddressPostalCode,
                                ContactAddressCountryName,
                                ContactAddressCountryCode
                            FROM
                                contact_address 
                            WHERE
                                ContactId = :contactId:;';



}
