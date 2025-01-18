<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserCookieModel extends Model
{

    protected $table = 'user_cookies';
    protected $primaryKey = 'UserCookieId';
    protected $allowedFields = [
        'UserCookieId',
        'UserCookieUserFk',
        'UserCookieSelector',
        'UserCookieHashedValidator',
        'UserCookieExpires'
    ];

    // SQL
    protected $sqlDelete = 'DELETE FROM user_cookies WHERE UserCookieUserFk = :userId:;';
    protected $sqlCookie = 'SELECT
                                UserCookieId AS Id,
                                UserCookieUserFk,
                                UserCookieSelector,
                                UserCookieHashedValidator,
                                UserCookieExpires
                            FROM
                                user_cookies 
                            WHERE
                                UserCookieSelector = :userCookieSelector:
                                AND
                                UserCookieExpires >= now();';

   




}
