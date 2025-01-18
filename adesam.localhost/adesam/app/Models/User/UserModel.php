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
    protected $sqlList = 'SELECT
                                UserId,
                                UserFirstName,
                                UserLastName,
                                UserDescription
                            FROM
                                user 
                            ORDER BY 
                                UserId DESC;';
    protected $sqlUser = 'SELECT
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
    protected $sqlEmail = 'SELECT 
                                UserId 
                            FROM 
                                user 
                            WHERE 
                                UserEmail = :email:;';
    
    protected $sqlIdByCookieSelector = 'SELECT 
                                    u.UserId AS UserId
                                FROM 
                                    user u
                                    JOIN user_cookies uc ON uc.UserCookieUserFk = u.UserId
                                WHERE 
                                    uc.UserCookieSelector = :selector:
                                    AND
                                    uc.UserCookieExpires > now()
                                LIMIT 1;';

}
