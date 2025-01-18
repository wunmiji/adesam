<?php

namespace App\ImplModel;


use App\Enums\CalendarType;
use App\Models\Calendar\CalendarModel;
use App\Models\Calendar\CalendarImageModel;
use App\Models\Calendar\CalendarAddtionalInformationsModel;
use App\Models\Calendar\CalendarContactModel;
use App\Models\Calendar\CalendarFamilyModel;
use App\Models\Calendar\CalendarOccasionModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Calendar\CalendarEntity;
use App\Entities\Calendar\CalendarImageEntity;
use App\Entities\Calendar\CalendarAddtionalInformationsEntity;
use App\Entities\Calendar\CalendarContactEntity;
use App\Entities\Calendar\CalendarOccasionEntity;
use App\Entities\Calendar\CalendarFamilyEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class CalendarImplModel
{


    public function list(int $year, int $month, int $day)
    {
        $calendarModel = new CalendarModel();
        $query = $calendarModel->query($calendarModel->sqlList, [
            'year' => $year,
            'month' => $month,
            'day' => $day
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CalendarEntity(
                $value['CalendarId'] ?? null,
                SecurityLibrary::encryptUrlId($value['CalendarId']),
                $value['CalendarTitle'],
                $value['CalendarType'],
                $value['CalendarLocked'],
                $value['CalendarIsRecurring'],
                $value['CalendarStartYear'],
                $value['CalendarStartMonth'],
                $value['CalendarStartDay'],
                $value['CalendarStartTime'] ?? null,
                $value['CalendarEndYear'] ?? null,
                $value['CalendarEndMonth'] ?? null,
                $value['CalendarEndDay'] ?? null,
                $value['CalendarEndTime'] ?? null,
                null,
                CalendarType::getColor($value['CalendarType']),

                null,
                (empty($value['CalendarStartDate'])) ? null : $value['CalendarStartDate'],
                (empty($value['CalendarEndDate'])) ? null : $value['CalendarEndDate'],

                (empty($value['CalendarStartDate'])) ? null : DateLibrary::getDate($value['CalendarStartDate']),
                (empty($value['CalendarEndDate'])) ? null : DateLibrary::getDate($value['CalendarEndDate']),
                (empty($value['CalendarStartTime'])) ? null : DateLibrary::formatTime($value['CalendarStartTime']),
                (empty($value['CalendarEndTime'])) ? null : DateLibrary::formatTime($value['CalendarEndTime']),

                null,
                null,
                null,

                null,
                null,
                null,

                $this->calendarImage($value['CalendarId']) ?? null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function recent(int $year, int $month, int $day)
    {
        $calendarModel = new CalendarModel();
        $query = $calendarModel->query($calendarModel->sqlRecent, [
            'year' => $year,
            'month' => $month,
            'day' => $day
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CalendarEntity(
                $value['CalendarId'] ?? null,
                SecurityLibrary::encryptUrlId($value['CalendarId']),
                $value['CalendarTitle'],
                $value['CalendarType'],
                $value['CalendarLocked'],
                $value['CalendarIsRecurring'],
                $value['CalendarStartYear'],
                $value['CalendarStartMonth'],
                $value['CalendarStartDay'],
                $value['CalendarStartTime'] ?? null,
                $value['CalendarEndYear'] ?? null,
                $value['CalendarEndMonth'] ?? null,
                $value['CalendarEndDay'] ?? null,
                $value['CalendarEndTime'] ?? null,
                null,
                CalendarType::getColor($value['CalendarType']),

                null,
                (empty($value['CalendarStartDate'])) ? null : $value['CalendarStartDate'],
                (empty($value['CalendarEndDate'])) ? null : $value['CalendarEndDate'],

                (empty($value['CalendarStartDate'])) ? null : DateLibrary::getDate($value['CalendarStartDate']),
                (empty($value['CalendarEndDate'])) ? null : DateLibrary::getDate($value['CalendarEndDate']),
                (empty($value['CalendarStartTime'])) ? null : DateLibrary::formatTime($value['CalendarStartTime']),
                (empty($value['CalendarEndTime'])) ? null : DateLibrary::formatTime($value['CalendarEndTime']),

                null,
                null,
                null,

                null,
                null,
                null,

                $this->calendarImage($value['CalendarId']) ?? null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function date(int $year, int $month, int $day)
    {
        $calendarModel = new CalendarModel();
        $query = $calendarModel->query($calendarModel->sqlDate, [
            'year' => $year,
            'month' => $month,
            'day' => $day
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CalendarEntity(
                $value['CalendarId'] ?? null,
                SecurityLibrary::encryptUrlId($value['CalendarId']),
                $value['CalendarTitle'],
                $value['CalendarType'],
                $value['CalendarLocked'],
                $value['CalendarIsRecurring'],
                $value['CalendarStartYear'],
                $value['CalendarStartMonth'],
                $value['CalendarStartDay'],
                $value['CalendarStartTime'] ?? null,
                $value['CalendarEndYear'] ?? null,
                $value['CalendarEndMonth'] ?? null,
                $value['CalendarEndDay'] ?? null,
                $value['CalendarEndTime'] ?? null,
                null,
                CalendarType::getColor($value['CalendarType']),


                null,
                (empty($value['CalendarStartDate'])) ? null : $value['CalendarStartDate'],
                (empty($value['CalendarEndDate'])) ? null : $value['CalendarEndDate'],

                (empty($value['CalendarStartDate'])) ? null : DateLibrary::getDate($value['CalendarStartDate']),
                (empty($value['CalendarEndDate'])) ? null : DateLibrary::getDate($value['CalendarEndDate']),
                (empty($value['CalendarStartTime'])) ? null : DateLibrary::formatTime($value['CalendarStartTime']),
                (empty($value['CalendarEndTime'])) ? null : DateLibrary::formatTime($value['CalendarEndTime']),

                null,
                null,
                null,

                null,
                null,
                null,

                $this->calendarImage($value['CalendarId']) ?? null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(int $num)
    {
        $calendarModel = new CalendarModel();
        $query = $calendarModel->query($calendarModel->sqlCalendar, [
            'calendarId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->calendar($row);
        }
    }

    public function calendar($value)
    {
        return new CalendarEntity(
            $value['CalendarId'] ?? null,
            SecurityLibrary::encryptUrlId($value['CalendarId']),
            $value['CalendarTitle'],
            $value['CalendarType'],
            $value['CalendarLocked'],
            $value['CalendarIsRecurring'],
            $value['CalendarStartYear'],
            $value['CalendarStartMonth'],
            $value['CalendarStartDay'],
            $value['CalendarStartTime'] ?? null,
            $value['CalendarEndYear'] ?? null,
            $value['CalendarEndMonth'] ?? null,
            $value['CalendarEndDay'] ?? null,
            $value['CalendarEndTime'] ?? null,
            $value['CalendarDescription'] ?? null,
            CalendarType::getColor($value['CalendarType']),


            ($value['CalendarRecurringType'] == 'null') ? null : $value['CalendarRecurringType'],
            (empty($value['CalendarStartDate'])) ? null : $value['CalendarStartDate'],
            (empty($value['CalendarEndDate'])) ? null : $value['CalendarEndDate'],

            (empty($value['CalendarStartDate'])) ? null : DateLibrary::getDate($value['CalendarStartDate']),
            (empty($value['CalendarEndDate'])) ? null : DateLibrary::getDate($value['CalendarEndDate']),
            (empty($value['CalendarStartTime'])) ? null : DateLibrary::formatTime($value['CalendarStartTime']),
            (empty($value['CalendarEndTime'])) ? null : DateLibrary::formatTime($value['CalendarEndTime']),

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->calendarImage($value['CalendarId']) ?? null,
            $this->calendarAddtionalInformations($value['CalendarId']) ?? null,
        );

    }

    public function calendarImage(int $num)
    {
        $calendarImageModel = new CalendarImageModel();
        $query = $calendarImageModel->query($calendarImageModel->sqlImage, [
            'calendarId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new CalendarImageEntity(
                $num,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            return $entity;
        }

    }

    public function calendarAddtionalInformations(int $num)
    {
        $calendarAddtionalInformationsModel = new CalendarAddtionalInformationsModel();
        $query = $calendarAddtionalInformationsModel->query($calendarAddtionalInformationsModel->sqlAddtionalInformations, [
            'calendarId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new CalendarAddtionalInformationsEntity(
                $row['Id'],
                $row['CalendarId'] ?? null,
                $row['CalendarAddtionalInformationsField'] ?? null,
                $row['CalendarAddtionalInformationsLabel'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function contactCalendars(int $num)
    {
        $calendarContactModel = new CalendarContactModel();
        $query = $calendarContactModel->query($calendarContactModel->sqlContact, [
            'contactId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new CalendarContactEntity(
                $row['CalendarId'],
                $row['ContactId'] ?? null,
                $row['CalendarContactDob'] ?? null,

                SecurityLibrary::encryptUrlId($row['CalendarId']),
                $row['CalendarTitle'],
                CalendarType::getColor($row['CalendarType']),

                (empty($row['CalendarStartDate'])) ? null : $row['CalendarStartDate'],
                (empty($row['CalendarEndDate'])) ? null : $row['CalendarEndDate'],

                (empty($row['CalendarStartDate'])) ? null : DateLibrary::getDate($row['CalendarStartDate']),
                (empty($row['CalendarEndDate'])) ? null : DateLibrary::getDate($row['CalendarEndDate']),

                (empty($row['CalendarStartTime'])) ? null : DateLibrary::formatTime($row['CalendarStartTime']),
                (empty($row['CalendarEndTime'])) ? null : DateLibrary::formatTime($row['CalendarEndTime']),

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            $arr[$row['CalendarId']] = $entity;
        }


        return $arr;
    }

    public function occasionCalendar(int $num)
    {
        $calendarOccasionModel = new CalendarOccasionModel();
        $query = $calendarOccasionModel->query($calendarOccasionModel->sqlOccasion, [
            'occasionId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new CalendarOccasionEntity(
                $row['CalendarId'],
                $row['OccasionId'] ?? null,

                SecurityLibrary::encryptUrlId($row['CalendarId']),
                $row['CalendarTitle'],
                CalendarType::getColor($row['CalendarType']),

                (empty($row['CalendarStartDate'])) ? null : $row['CalendarStartDate'],
                (empty($row['CalendarEndDate'])) ? null : $row['CalendarEndDate'],

                (empty($row['CalendarStartDate'])) ? null : DateLibrary::getDate($row['CalendarStartDate']),
                (empty($row['CalendarEndDate'])) ? null : DateLibrary::getDate($row['CalendarEndDate']),

                (empty($row['CalendarStartTime'])) ? null : DateLibrary::formatTime($row['CalendarStartTime']),
                (empty($row['CalendarEndTime'])) ? null : DateLibrary::formatTime($row['CalendarEndTime']),

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );


            return $entity;
        }

    }

    public function familyCalendar(int $num)
    {
        $calendarFamilyModel = new CalendarFamilyModel();
        $query = $calendarFamilyModel->query($calendarFamilyModel->sqlFamily, [
            'familyId' => $num,
        ]);
        

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new CalendarFamilyEntity(
                $row['CalendarId'],
                $row['FamilyId'] ?? null,
                $row['CalendarFamilyDob'] ?? null,

                SecurityLibrary::encryptUrlId($row['CalendarId']),
                $row['CalendarTitle'],
                CalendarType::getColor($row['CalendarType']),

                (empty($row['CalendarStartDate'])) ? null : $row['CalendarStartDate'],
                (empty($row['CalendarEndDate'])) ? null : $row['CalendarEndDate'],

                (empty($row['CalendarStartDate'])) ? null : DateLibrary::getDate($row['CalendarStartDate']),
                (empty($row['CalendarEndDate'])) ? null : DateLibrary::getDate($row['CalendarEndDate']),

                (empty($row['CalendarStartTime'])) ? null : DateLibrary::formatTime($row['CalendarStartTime']),
                (empty($row['CalendarEndTime'])) ? null : DateLibrary::formatTime($row['CalendarEndTime']),

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            $arr[$row['CalendarId']] = $entity;
        }

        return $arr;

    }

    public function store($data, $dataImage, $dataAddtionalInformations, $dataContact, $dataFamily)
    {
        try {
            $calendarModel = new CalendarModel();

            $calendarModel->transException(true)->transStart();

            // Insert into calendar
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $calendarId = $calendarModel->insert($data);

            // Insert into calendar_image
            if (!empty($dataImage)) {
                $calendarImageModel = new CalendarImageModel();
                $dataImage['CalendarId'] = $calendarId;
                $calendarImageModel->insert($dataImage);
            }

            // Insert into calendar_additional_informations
            $calendarAddtionalInformationsModel = new CalendarAddtionalInformationsModel();
            foreach ($dataAddtionalInformations as $key => $dataAddtionalInformation) {
                $dataAddtionalInformation['CalendarAddtionalInformationsCalendarFk'] = $calendarId;
                $calendarAddtionalInformationsModel->insert($dataAddtionalInformation);
            }

            // Insert into calendar_contact
            if (!empty($dataContact)) {
                $calendarContactModel = new CalendarContactModel();
                $dataContact['CalendarId'] = $calendarId;
                $calendarContactModel->insert($dataContact);
            }

            // Insert into calendar_family
            if (!empty($dataFamily)) {
                $calendarFamilyModel = new CalendarFamilyModel();
                $dataFamily['CalendarId'] = $calendarId;
                $calendarFamilyModel->insert($dataFamily);
            }

            $calendarModel->transComplete();

            if ($calendarModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function update($num, $data, $dataImage, $dataAddtionalInformations)
    {
        try {
            $calendarModel = new CalendarModel();

            $calendarModel->transException(true)->transStart();

            // Update into calendar
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $calendarModel->update($num, $data);

            // Update into calendar_image
            $calendarImageModel = new CalendarImageModel();
            if (empty($dataImage)) {
                $calendarImageModel->delete($num);
            } else {
                $calendarImageModel->update($num, $dataImage);
            }

            // Update into calendar_additional_informations
            $calendarAddtionalInformationsModel = new CalendarAddtionalInformationsModel();
            $this->updateOneToMany($calendarAddtionalInformationsModel, 'CalendarAddtionalInformationsCalendarFk', $num, $dataAddtionalInformations);

            $calendarModel->transComplete();

            if ($calendarModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function delete(int $num)
    {
        try {
            $calendarModel = new CalendarModel();

            $calendarModel->transException(true)->transStart();

            $query = $calendarModel->query($calendarModel->sqlDelete, [
                'calendarId' => $num,
            ]);

            $affected_rows = $calendarModel->affectedRows();

            $calendarModel->transComplete();
            if ($affected_rows >= 1 && $calendarModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function storeOccasion($title, $familyId, $file)
    {
        $data = [
            'CalendarTitle' => $title,
            'CalendarIsRecurring' => false,
            'CalendarDescription' => CalendarType::EVENT->value,
            'CalendarType' => CalendarType::EVENT->name,
            'CalendarStartDate' => DateLibrary::getCurrentDate(),
            'CalendarStartTime' => '00:00:00',
            'CalendarEndDate' => null,
            'CalendarEndTime' => null,
            'CreatedId' => $familyId,
        ];

        // Insert into calendarImage
        $dataImage = [
            'CalendarImageFileFk' => $file->fileId,
        ];

        // Insert into calendarAddtionalInformation
        $dataAddtionalInformations = array();

        // Insert into calendarContact
        $dataContact = array();

        $this->store($data, $dataImage, $dataAddtionalInformations, $dataContact);
    }

    // Other 
    public function getIdBirthdayFamily(int $familyId)
    {
        $calendarFamilyModel = new CalendarFamilyModel();
        $query = $calendarFamilyModel->query($calendarFamilyModel->sqlIdBirthday, [
            'familyId' => $familyId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'CalendarId'};
    }

    public function getIdBirthdayContact(int $contactId)
    {
        $calendarContactModel = new CalendarContactModel();
        $query = $calendarContactModel->query($calendarContactModel->sqlIdBirthday, [
            'contactId' => $contactId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'CalendarId'};
    }

    public function getIdOccasion(int $occasionId)
    {
        $calendarOccasionModel = new CalendarOccasionModel();
        $query = $calendarOccasionModel->query($calendarOccasionModel->sqlId, [
            'occasionId' => $occasionId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'CalendarId'};
    }

    private function updateOneToMany($model, $fk, $num, $datas)
    {
        $old = $model->where($fk, $num)->findAll();
        $oldColumn = array_column($old, $model->primaryKey);
        $newColumn = array_column($datas, $model->primaryKey);
        $diffArray = ArrayLibrary::getOneToMany($oldColumn, $newColumn);
        foreach ($diffArray as $diff) {
            $model->delete(intval($diff));
        }
        foreach ($datas as $each) {
            $model->save($each);
        }
    }


}