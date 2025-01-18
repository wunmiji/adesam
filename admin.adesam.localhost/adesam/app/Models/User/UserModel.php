<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'user';
    protected $primaryKey = 'UserId';
    protected $allowedFields = [
        'UserId',
        'UserFirstName',
        'UserLastName',
        'UserEmail',
        'UserNumber',
        'UserDescription',
        'CreatedDateTime',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(UserId) AS COUNT FROM user';
    protected $sqlDelete = 'DELETE FROM user WHERE UserId = :userId:;';
    protected $sqlTable = 'SELECT
                                UserId,
                                concat_ws(" ", UserFirstName, UserLastName) AS Name,
                                UserEmail,
                                UserDescription
                            FROM
                                user 
                            ORDER BY 
                                UserId DESC;';
    protected $sqlRetrieve = 'SELECT
                                UserId,
                                UserFirstName,
                                UserLastName,
                                UserEmail,
                                UserNumber,
                                UserDescription,
                                CreatedDateTime,
                                ModifiedDateTime
                            FROM
                                user 
                            WHERE
                                UserId = :userId:;';

}
