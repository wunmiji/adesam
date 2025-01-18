<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserImageModel extends Model
{

    protected $table = 'user_image';
    protected $primaryKey = 'UserId';
    protected $allowedFields = [
        'UserId',
        'UserImageFileFk',
    ];

    // SQL
    protected $sqlUserImageFileFk = 'SELECT UserImageFileFk FROM user_image WHERE UserId = :userId:';
    protected $sqlFile = 'SELECT
                            ui.UserId AS Id,
                            ui.UserImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            user_image ui
                            JOIN file f ON ui.UserImageFileFk = f.FileId 
                        WHERE
                            ui.UserId = :userId:;';


}
