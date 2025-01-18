<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarFamilyModel extends Model
{

    protected $table = 'calendar_family';
    protected $primaryKey = 'CalendarId';
    protected $allowedFields = [
        'CalendarId',
        'CalendarFamilyFamilyFk',
        'CalendarFamilyDob',
    ];

    // SQL
    protected $sqlIdBirthday = 'SELECT CalendarId FROM calendar_family WHERE CalendarFamilyFamilyFk = :familyId: AND CalendarFamilyDob = true';
    protected $sqlFamily = 'SELECT
                                    cf.CalendarId,
                                    cf.CalendarFamilyFamilyFk AS FamilyId,
                                    cf.CalendarFamilyDob,

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
                                    calendar_family cf 
                                    JOIN calendar c ON c.CalendarId = cf.CalendarId 
                                    LEFT JOIN calendar_image ci ON ci.CalendarId = cf.CalendarId 
                                    LEFT JOIN file f ON ci.CalendarImageFileFk = f.FileId 
                                WHERE
                                    cf.CalendarFamilyFamilyFk = :familyId:;';

}
