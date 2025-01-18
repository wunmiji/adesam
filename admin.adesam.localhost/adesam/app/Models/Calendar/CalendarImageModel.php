<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarImageModel extends Model
{

    protected $table = 'calendar_image';
    protected $primaryKey = 'CalendarId';
    protected $allowedFields = [
        'CalendarId',
        'CalendarImageFileFk',
    ];

    // SQL
    protected $sqlImage = 'SELECT
                            ci.CalendarId AS Id,
                            ci.CalendarImageFileFk AS FileId,
                            f.FileName,
                            f.FileUrlPath
                        FROM
                            calendar_image ci
                            JOIN file f ON ci.CalendarImageFileFk = f.FileId 
                        WHERE
                            ci.CalendarId = :calendarId:;';


}
