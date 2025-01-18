<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserSecretModel extends Model
{

    protected $table = 'user_secret';
    protected $primaryKey = 'UserId';
    protected $allowedFields = [
        'UserId',
        'UserSecretPassword',
        'UserSecretSalt'
    ];

    // SQL
    protected $sqlSecret = 'SELECT
                                UserId,
                                UserSecretPassword,
                                UserSecretSalt
                            FROM
                                user_secret 
                            WHERE
                                UserId = :userId:;';




}
