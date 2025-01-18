<?php

namespace App\Models\Calendar;

use CodeIgniter\Model;

class CalendarAddtionalInformationsModel extends Model
{

    protected $table = 'calendar_additional_informations';
    protected $primaryKey = 'CalendarAddtionalInformationsId';
    protected $allowedFields = [
        'CalendarAddtionalInformationsId',
        'CalendarAddtionalInformationsCalendarFk',
        'CalendarAddtionalInformationsField',
        'CalendarAddtionalInformationsLabel',
    ];

    // SQL
    protected $sqlAddtionalInformations = 'SELECT
                                            CalendarAddtionalInformationsId AS Id,
                                            CalendarAddtionalInformationsCalendarFk AS CalendarId,
                                            CalendarAddtionalInformationsField,
                                            CalendarAddtionalInformationsLabel
                                        FROM
                                            calendar_additional_informations 
                                        WHERE
                                            CalendarAddtionalInformationsCalendarFk = :calendarId:;';

}
