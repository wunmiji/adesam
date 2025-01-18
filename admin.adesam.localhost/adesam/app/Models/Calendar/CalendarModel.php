<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarModel extends Model
{

    protected $table = 'calendar';
    protected $primaryKey = 'CalendarId';
    protected $allowedFields = [
        'CalendarId',
        'CalendarTitle',
        'CalendarType',
        'CalendarLocked',
        'CalendarIsRecurring',
        'CalendarRecurringType',
        'CalendarStartYear',
        'CalendarStartMonth',
        'CalendarStartDay',
        'CalendarStartTime',
        'CalendarEndYear',
        'CalendarEndMonth',
        'CalendarEndDay',
        'CalendarEndTime',
        'CalendarDescription',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlDelete = 'DELETE FROM calendar WHERE CalendarId = :calendarId:;';
    protected $sqlList = 'SELECT
                                CalendarId,
                                CalendarTitle,
                                CalendarType,
                                CalendarLocked,
                                CalendarIsRecurring,
                                CalendarStartYear,
                                CalendarStartMonth,
                                CalendarStartDay,
                                CalendarStartTime,
                                (CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(:month:, 2, "0"), null), LPAD(CalendarStartDay, 2, "0"))) AS CalendarStartDate,   
                                CalendarEndYear,
                                CalendarEndMonth,
                                CalendarEndDay,
                                CalendarEndTime,
                                CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(CalendarEndMonth, 2, "0"), null), LPAD(CalendarEndDay, 2, "0")) AS CalendarEndDate
                            FROM
                                calendar 
                            WHERE
								(CalendarRecurringType IS NULL AND CalendarStartYear = :year: AND CalendarStartMonth = :month:) 
                                OR 
                                (CalendarRecurringType = "YEARLY" AND CalendarStartMonth = :month:)
                                OR 
                                (CalendarRecurringType = "MONTHLY")
                                OR 
                                (CalendarRecurringType = "WEEKLY")
                            ORDER BY 
                                CalendarId
                            DESC;';
    protected $sqlDate = 'SELECT
                                CalendarId,
                                CalendarTitle,
                                CalendarType,
                                CalendarLocked,
                                CalendarIsRecurring,
                                CalendarStartYear,
                                CalendarStartMonth,
                                CalendarStartDay,
                                CalendarStartTime,
                                (CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(:month:, 2, "0"), null), LPAD(CalendarStartDay, 2, "0"))) AS CalendarStartDate,   
                                CalendarEndYear,
                                CalendarEndMonth,
                                CalendarEndDay,
                                CalendarEndTime,
                                CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(CalendarEndMonth, 2, "0"), null), LPAD(CalendarEndDay, 2, "0")) AS CalendarEndDate
                            FROM
                                calendar 
                            WHERE
                                (CalendarRecurringType IS NULL AND CalendarStartYear = :year: AND CalendarStartMonth = :month: AND CalendarStartDay = :day:) 
                                OR 
                                (CalendarRecurringType = "YEARLY" AND CalendarStartMonth = :month: AND CalendarStartDay = :day:)
                                OR 
                                (CalendarRecurringType = "MONTHLY" AND CalendarStartDay = :day:)
                                OR 
                                (CalendarRecurringType = "WEEKLY" AND CalendarStartDay = :day:)
                            ORDER BY 
                                CalendarId
                            DESC;';


    protected $sqlCalendar = 'SELECT
                                c.CalendarId,
                                c.CalendarTitle,
                                c.CalendarType,
                                c.CalendarLocked,
                                c.CalendarIsRecurring,
                                c.CalendarRecurringType,
                                c.CalendarStartYear,
                                c.CalendarStartMonth,
                                c.CalendarStartDay,
                                c.CalendarStartTime,
                                (CONCAT_WS("-", IFNULL(c.CalendarStartYear, null), IFNULL(LPAD(c.CalendarStartMonth, 2, "0"), null), LPAD(c.CalendarStartDay, 2, "0"))) AS CalendarStartDate,   
                                c.CalendarEndYear,
                                c.CalendarEndMonth,
                                c.CalendarEndDay,
                                c.CalendarEndTime,
                                CONCAT_WS("-", IFNULL(c.CalendarStartYear, null), IFNULL(LPAD(c.CalendarEndMonth, 2, "0"), null), LPAD(c.CalendarEndDay, 2, "0")) AS CalendarEndDate,
                                c.CalendarDescription,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                c.CreatedDateTime,
                                c.CreatedId,
                                me.FamilyFirstName AS ModifiedByFirstName,
                                me.FamilyLastName AS ModifiedByLastName,
                                c.ModifiedDateTime,
                                c.ModifiedId
                            FROM
                                calendar c
                                JOIN family ce ON c.CreatedId = ce.FamilyId
                                LEFT JOIN family me ON c.ModifiedId = me.FamilyId
                            WHERE
                                c.CalendarId = :calendarId:;';


    protected $sqlRecent = 'SELECT
                                CalendarId,
                                CalendarTitle,
                                CalendarType,
                                CalendarLocked,
                                CalendarIsRecurring,
                                CalendarStartYear,
                                CalendarStartMonth,
                                CalendarStartDay,
                                CalendarStartTime,
                                (CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(:month:, 2, "0"), null), LPAD(CalendarStartDay, 2, "0"))) AS CalendarStartDate,   
                                CalendarEndYear,
                                CalendarEndMonth,
                                CalendarEndDay,
                                CalendarEndTime,
                                CONCAT_WS("-", IFNULL(:year:, null), IFNULL(LPAD(CalendarEndMonth, 2, "0"), null), LPAD(CalendarEndDay, 2, "0")) AS CalendarEndDate
                            FROM
                                calendar 
                            WHERE
								(CalendarStartYear >= :year: AND CalendarStartMonth >= :month: AND CalendarStartDay >= :day:) 
                                OR 
                                (CalendarIsRecurring = true AND CalendarStartMonth = :month:  AND CalendarStartDay >= :day:)
                            ORDER BY 
                                CalendarStartYear ASC,
                                CalendarStartMonth ASC,
                                CalendarStartDay ASC
                            LIMIT 5;';

}
