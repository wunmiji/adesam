<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarContactModel extends Model
{

    protected $table = 'calendar_contact';
    protected $primaryKey = 'CalendarId';
    protected $allowedFields = [
        'CalendarId',
        'CalendarContactContactFk',
        'CalendarContactDob',
    ];

    // SQL
    protected $sqlIdBirthday = 'SELECT CalendarId FROM calendar_contact WHERE CalendarContactContactFk = :contactId: AND CalendarContactDob = true';
    protected $sqlContact = 'SELECT
                                    cc.CalendarId,
                                    cc.CalendarContactContactFk AS ContactId,
                                    cc.CalendarContactDob,

                                    c.CalendarTitle,
                                    c.CalendarType,
                                    c.CalendarStartTime,
                                    CONCAT_WS("-", c.CalendarStartYear, LPAD(c.CalendarStartMonth, 2, "0"), LPAD(c.CalendarStartDay, 2, "0")) AS CalendarStartDate,
                                    c.CalendarEndTime,
                                    CONCAT_WS("-", c.CalendarEndYear, LPAD(c.CalendarEndMonth, 2, "0"), LPAD(c.CalendarEndDay, 2, "0")) AS CalendarEndDate,

                                    ci.CalendarImageFileFk AS FileId,
                                    f.FileName,
                                    f.FileUrlPath
                                FROM
                                    calendar_contact cc 
                                    JOIN calendar c ON c.CalendarId = cc.CalendarId 
                                    LEFT JOIN calendar_image ci ON ci.CalendarId = cc.CalendarId 
                                    LEFT JOIN file f ON ci.CalendarImageFileFk = f.FileId 
                                WHERE
                                    cc.CalendarContactContactFk = :contactId:;';

}
