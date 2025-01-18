<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserSecretResetModel extends Model
{

    protected $table = 'user_secret_reset';
    protected $primaryKey = 'UserId';
    protected $allowedFields = [
        'UserId',
        'UserSecretResetToken',
        'UserSecretExpiresAt'
    ];

    // SQL
    protected $sqlSecretReset = 'SELECT
                                UserId,
                                UserSecretResetToken,
                                UserSecretExpiresAt
                            FROM
                                user_secret_reset 
                            WHERE
                                UserId = :userId:;';

    protected $sqlToken = 'SELECT 
                                UserId, 
                                UserSecretExpiresAt
                            FROM 
                                user_secret_reset 
                            WHERE 
                                UserSecretResetToken = :userSecretResetToken:';




}
