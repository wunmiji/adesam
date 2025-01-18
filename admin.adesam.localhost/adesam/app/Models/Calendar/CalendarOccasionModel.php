<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarOccasionModel extends Model
{

    protected $table = 'calendar_occasion';
    protected $primaryKey = 'CalendarId';
    protected $allowedFields = [
        'CalendarId',
        'CalendarOccasionOccasionFk',
    ];

    // SQL
    protected $sqlId = 'SELECT CalendarId FROM calendar_occasion WHERE CalendarOccasionOccasionFk = :occasionId:';
    protected $sqlOccasion = 'SELECT
                                    cc.CalendarId,
                                    cc.CalendarOccasionOccasionFk AS OccasionId,

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
                                    calendar_occasion cc 
                                    JOIN calendar c ON c.CalendarId = cc.CalendarId 
                                    LEFT JOIN calendar_image ci ON ci.CalendarId = cc.CalendarId 
                                    LEFT JOIN file f ON ci.CalendarImageFileFk = f.FileId 
                                WHERE
                                    cc.CalendarOccasionOccasionFk = :occasionId:;';

}
