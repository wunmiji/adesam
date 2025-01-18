<?php

namespace App\Models\Contact;

use CodeIgniter\Model;

class ContactModel extends Model
{

    protected $table = 'contact';
    protected $primaryKey = 'ContactId';
    protected $allowedFields = [
        'ContactId',
        'ContactNickName',
        'ContactType',
        'ContactFirstName',
        'ContactLastName',
        'ContactGender',
        'ContactEmail',
        'ContactNumber',
        'ContactDob',
        'ContactDescription',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(ContactId) AS COUNT FROM contact WHERE ContactType = "PUBLIC" OR CreatedId = :createdId:';
    protected $sqlDelete = 'DELETE FROM contact WHERE ContactId = :contactId:;';
    protected $sqlList = 'SELECT
                                ContactId,
                                ContactNickName,
                                ContactType,
                                ContactGender,
                                ContactEmail,
                                ContactNumber
                            FROM
                                contact 
                            WHERE 
                                ContactType = "PUBLIC"
                                OR 
                                CreatedId = :createdId:
                            ORDER BY 
                                ContactId DESC 
                            LIMIT 
                                :from:, :to:;';
    protected $sqlContact = 'SELECT
                                ContactId,
                                ContactNickName,
                                ContactType,
                                ContactFirstName,
                                ContactLastName,
                                ContactGender,
                                ContactDescription,
                                ContactGender,
                                ContactEmail,
                                ContactDob,
                                ContactNumber,
                                ContactDescription,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                c.CreatedDateTime,
                                c.CreatedId,
                                me.FamilyFirstName AS ModifiedByFirstName,
                                me.FamilyLastName AS ModifiedByLastName,
                                c.ModifiedDateTime,
                                c.ModifiedId
                            FROM
                                contact c
                                JOIN family ce ON c.CreatedId = ce.FamilyId
                                LEFT JOIN family me ON c.ModifiedId = me.FamilyId
                            WHERE
                                ContactId = :contactId:
                                AND
                                (ContactType = "PUBLIC" OR CreatedId = :createdId:);';
    

}
