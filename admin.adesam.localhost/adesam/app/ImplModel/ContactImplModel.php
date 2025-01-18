<?php

namespace App\ImplModel;


use App\Enums\ContactType;
use App\Models\Contact\ContactModel;
use App\Models\Contact\ContactImageModel;
use App\Models\Contact\ContactAddressModel;
use App\Models\Contact\ContactTagsModel;
use App\Models\Contact\ContactAddtionalInformationsModel;
use App\Models\Calendar\CalendarModel;
use App\Models\Calendar\CalendarImageModel;
use App\Models\Calendar\CalendarContactModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Contact\ContactEntity;
use App\Entities\Contact\ContactImageEntity;
use App\Entities\Contact\ContactAddressEntity;
use App\Entities\Contact\ContactTagsEntity;
use App\Entities\Contact\ContactAddtionalInformationsEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class ContactImplModel extends BaseImplModel
{


    public function list(int $from, int $to)
    {
        $contactModel = new ContactModel();
        $query = $contactModel->query($contactModel->sqlList, [
            'from' => $from,
            'to' => $to,
            'createdId' => $this->getCreatedId()
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ContactEntity(
                $value['ContactId'] ?? null,
                SecurityLibrary::encryptUrlId($value['ContactId']),
                $value['ContactNickName'],
                ContactType::getValue($value['ContactType']),
                null,
                null,
                null,
                $value['ContactEmail'] ?? null,
                null,
                $value['ContactNumber'] ?? null,
                null,

                null,

                null,
                null,
                null,

                null,
                null,
                null,

                $this->contactImage($value['ContactId']) ?? null,
                null,
                $this->contactTags($value['ContactId']) ?? null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(int $num)
    {
        $contactModel = new ContactModel();
        $query = $contactModel->query($contactModel->sqlContact, [
            'contactId' => $num,
            'createdId' => $this->getCreatedId()
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->contact($row);
        }
    }

    public function contact($value)
    {
        return new ContactEntity(
            $value['ContactId'] ?? null,
            SecurityLibrary::encryptUrlId($value['ContactId']),
            $value['ContactNickName'],
            $value['ContactType'],
            $value['ContactFirstName'] ?? null,
            $value['ContactLastName'] ?? null,
            $value['ContactGender'],
            $value['ContactEmail'],
            $value['ContactDescription'] ?? null,
            $value['ContactNumber'] ?? null,
            $value['ContactDob'] ?? null,

            DateLibrary::getDate($value['ContactDob']) ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->contactImage($value['ContactId']) ?? null,
            $this->contactAddress($value['ContactId']) ?? null,
            $this->contactTags($value['ContactId']) ?? null,
            $this->contactAddtionalInformations($value['ContactId']) ?? null,
        );

    }

    public function contactImage(int $num)
    {
        $contactImageModel = new ContactImageModel();
        $query = $contactImageModel->query($contactImageModel->sqlImage, [
            'contactId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new ContactImageEntity(
                $num,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            return $entity;
        }

    }

    public function contactAddress(int $num)
    {
        $contactAddressModel = new ContactAddressModel();
        $query = $contactAddressModel->query($contactAddressModel->sqlAddress, [
            'contactId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new ContactAddressEntity(
                $num,
                $row['ContactAddressAddress'] ?? null,
                $row['ContactAddressPostalCode'] ?? null,
                $row['ContactAddressCountryName'] ?? null,
                $row['ContactAddressCountryCode'] ?? null
            );

            return $entity;
        }

    }

    public function contactTags(int $num)
    {
        $contactTagModel = new ContactTagsModel();
        $query = $contactTagModel->query($contactTagModel->sqlTags, [
            'contactId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ContactTagsEntity(
                $row['Id'],
                $row['TagId'] ?? null,
                $row['ContactId'] ?? null,
                $row['TagName'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function contactAddtionalInformations(int $num)
    {
        $contactAddtionalInformationsModel = new ContactAddtionalInformationsModel();
        $query = $contactAddtionalInformationsModel->query($contactAddtionalInformationsModel->sqlAddtionalInformations, [
            'contactId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ContactAddtionalInformationsEntity(
                $row['Id'],
                $row['ContactId'] ?? null,
                $row['ContactAddtionalInformationsField'] ?? null,
                $row['ContactAddtionalInformationsLabel'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function store($data, $dataImage, $dataAddress, $dataTags, $dataAddtionalInformations, $calendarData)
    {
        try {
            $contactModel = new ContactModel();

            $contactModel->transException(true)->transStart();

            // Insert into contacts
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $contactId = $contactModel->insert($data);

            // Insert into contact_image
            if (!empty($dataImage)) {
                $contactImageModel = new ContactImageModel();
                $dataImage['ContactId'] = $contactId;
                $contactImageModel->insert($dataImage);
            }

            // Insert into contact_address
            if (!empty($dataAddress)) {
                $contactAddressModel = new ContactAddressModel();
                $dataAddress['ContactId'] = $contactId;
                $contactAddressModel->insert($dataAddress);
            }

            // Insert into contact_tags
            $contactTagModel = new ContactTagsModel();
            foreach ($dataTags as $key => $dataTag) {
                $dataTag['ContactTagContactFk'] = $contactId;
                $contactTagModel->insert($dataTag);
            }

            // Insert into contact_additional_informations
            $contactAddtionalInformationsModel = new ContactAddtionalInformationsModel();
            foreach ($dataAddtionalInformations as $key => $dataAddtionalInformation) {
                $dataAddtionalInformation['ContactAddtionalInformationsContactFk'] = $contactId;
                $contactAddtionalInformationsModel->insert($dataAddtionalInformation);
            }

            // Insert into calendar, calendar_image and calendar_contact
            if (!empty($calendarData)) {
                // calender
                $calendarModel = new CalendarModel();
                $calendarData['CreatedDateTime'] = DateLibrary::getZoneDateTime();
                $calendarId = $calendarModel->insert($calendarData);

                // calendar_image
                if (!empty($dataImage)) {
                    $calendarImageModel = new CalendarImageModel();
                    $calendarDataImage['CalendarId'] = $calendarId;
                    $calendarDataImage['CalendarImageFileFk'] = $dataImage['ContactImageFileFk'];
                    $calendarImageModel->insert($calendarDataImage);
                }

                // calendar_contact
                $calendarContactModel = new CalendarContactModel();
                $calendarDataContact['CalendarId'] = $calendarId;
                $calendarDataContact['CalendarContactContactFk'] = $contactId;
                $calendarDataContact['CalendarContactDob'] = true;
                $calendarContactModel->insert($calendarDataContact);
            }


            $contactModel->transComplete();

            if ($contactModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }

    public function update($num, $data, $dataImage, $dataAddress, $dataTags, $dataAddtionalInformations, $calendarNum, $calendarData)
    {
        try {
            $contactModel = new ContactModel();

            $contactModel->transException(true)->transStart();

            // Update into contact
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $contactModel->update($num, $data);

            // Update into contact_image
            $contactImageModel = new ContactImageModel();
            if (empty($dataImage)) {
                $contactImageModel->delete($num);
            } else {
                $contactImage = $contactImageModel->find($num);
                if (is_null($contactImage))
                    $contactImageModel->insert($dataImage);
                else
                    $contactImageModel->update($num, $dataImage);
            }

            // Update into contact_address
            $contactAddressModel = new ContactAddressModel();
            $contactAddressModel->update($num, $dataAddress);

            // Update into contact_tags
            $contactTagModel = new ContactTagsModel();
            $this->updateOneToMany($contactTagModel, 'ContactTagContactFk', $num, $dataTags);

            // Update into contact_additional_informations
            $contactAddtionalInformationsModel = new ContactAddtionalInformationsModel();
            $this->updateOneToMany($contactAddtionalInformationsModel, 'ContactAddtionalInformationsContactFk', $num, $dataAddtionalInformations);

            // Update into calendar, calendar_image
            if (!empty($calendarData)) {
                // calendar
                $calendarModel = new CalendarModel();
                $calendarImageModel = new CalendarImageModel();
                if (empty($calendarNum)) {
                    $calendarData['CreatedId'] = $data['ModifiedId'];
                    $calendarData['CreatedDateTime'] = DateLibrary::getZoneDateTime();
                    $calendarNum = $calendarModel->insert($calendarData);

                    // calendar_image
                    if (!empty($dataImage)) {
                        $calendarDataImage['CalendarId'] = $calendarNum;
                        $calendarDataImage['CalendarImageFileFk'] = $dataImage['ContactImageFileFk'];
                        $calendarImageModel->insert($calendarDataImage);
                    }

                    // calendar_contact
                    $calendarContactModel = new CalendarContactModel();
                    $calendarDataContact['CalendarId'] = $calendarNum;
                    $calendarDataContact['CalendarContactContactFk'] = $num;
                    $calendarDataContact['CalendarContactDob'] = true;
                    $calendarContactModel->insert($calendarDataContact);
                } else {
                    $calendarData['ModifiedId'] = $data['ModifiedId'];
                    $calendarData['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
                    $calendarModel->update($calendarNum, $calendarData);

                    // calendar_image
                    if (empty($dataImage)) {
                        $calendarImageModel->delete($calendarNum);
                    } else {
                        $calendarImage = $calendarImageModel->find($calendarNum);
                        if (is_null($calendarImage)) {
                            $calendarDataImage['CalendarId'] = $calendarNum;
                            $calendarDataImage['CalendarImageFileFk'] = $dataImage['ContactImageFileFk'];
                            $calendarImageModel->insert($calendarDataImage);
                        } else {
                            $calendarDataImage['CalendarImageFileFk'] = $dataImage['ContactImageFileFk'];
                            $calendarImageModel->update($calendarNum, $calendarDataImage);
                        }
                    }
                }

            }


            $contactModel->transComplete();

            if ($contactModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }

    public function delete(int $num, ?int $calendarId)
    {
        try {
            $contactModel = new ContactModel();

            $contactModel->transException(true)->transStart();

            $query = $contactModel->query($contactModel->sqlDelete, [
                'contactId' => $num,
            ]);

            if (!is_null($calendarId)) {
                $calendarModel = new CalendarModel();
                $calendarModel->delete($calendarId);
            }

            $affected_rows = $contactModel->affectedRows();

            $contactModel->transComplete();
            if ($affected_rows >= 1 && $contactModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    // Other 
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

    public function count()
    {
        $contactModel = new ContactModel();
        $query = $contactModel->query($contactModel->sqlCount, [
            'createdId' => $this->getCreatedId()
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function pagination(int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->count();
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->list($next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }


}