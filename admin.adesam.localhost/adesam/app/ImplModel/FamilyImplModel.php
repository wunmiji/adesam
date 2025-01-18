<?php

namespace App\ImplModel;



use App\Models\Family\FamilyModel;
use App\Models\Family\FamilyImageModel;
use App\Models\Family\FamilySocialMediaModel;
use App\Models\Family\FamilySecretModel;
use App\Models\Family\FamilySecretResetModel;
use App\Models\Calendar\CalendarModel;
use App\Models\Calendar\CalendarFamilyModel;
use App\Libraries\DateLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Family\FamilyEntity;
use App\Entities\Family\FamilyImageEntity;
use App\Entities\Family\FamilySocialMediaEntity;
use App\Entities\Family\FamilySecretEntity;
use App\Entities\Family\FamilySecretResetEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class FamilyImplModel
{


    public function list()
    {
        $familyModel = new FamilyModel();
        $query = $familyModel->query($familyModel->sqlList, );
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FamilyEntity(
                $value['FamilyId'] ?? null,
                SecurityLibrary::encryptUrlId($value['FamilyId']),
                $value['FamilyFirstName'] . ' ' . $value['FamilyLastName'],
                $value['FamilyFirstName'] ?? null,
                $value['FamilyMiddleName'] ?? null,
                $value['FamilyLastName'] ?? null,
                $value['FamilyRole'] ?? null,
                null,
                null,
                null,
                null,
                null,
                $value['FamilyDescription'] ?? null,

                null,
                null,

                null,
                $this->familyImage($value['FamilyId']) ?? null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }


    public function retrieve(int $num)
    {
        $familyModel = new FamilyModel();
        $query = $familyModel->query($familyModel->sqlFamily, [
            'familyId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->family($row);
        }
    }

    public function family($value)
    {
        return new FamilyEntity(
            $value['FamilyId'] ?? null,
            SecurityLibrary::encryptUrlId($value['FamilyId']),
            $value['FamilyFirstName'] . ' ' . $value['FamilyLastName'],
            $value['FamilyFirstName'] ?? null,
            $value['FamilyMiddleName'] ?? null,
            $value['FamilyLastName'] ?? null,
            $value['FamilyRole'] ?? null,
            $value['FamilyEmail'] ?? null,
            $value['FamilyMobile'] ?? null,
            $value['FamilyTelephone'] ?? null,
            $value['FamilyGender'],
            $value['FamilyDob'] ?? null,
            $value['FamilyDescription'] ?? null,

            DateLibrary::getFormat($value['CreatedDateTime '] ?? null),
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->familySocialMedia($value['FamilyId']) ?? null,
            $this->familyImage($value['FamilyId']) ?? null,
            $this->familySecret($value['FamilyId'] ?? null)
        );

    }

    public function familySocialMedia(int $num)
    {
        $familySocialMediaModel = new FamilySocialMediaModel();
        $query = $familySocialMediaModel->query($familySocialMediaModel->sqlSocialMedia, [
            'familyId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new FamilySocialMediaEntity(
                $num,
                $row['FamilySocialFacebook'] ?? null,
                $row['FamilySocialInstagram'] ?? null,
                $row['FamilySocialLinkedIn'] ?? null,
                $row['FamilySocialTwitter'] ?? null,
                $row['FamilySocialYoutube'] ?? null,
            );

            return $entity;
        }

    }

    public function familyImage(int $num)
    {
        $familyImageModel = new FamilyImageModel();
        $query = $familyImageModel->query($familyImageModel->sqlFile, [
            'familyId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new FamilyImageEntity(
                $num,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            return $entity;
        }

    }

    public function familySecret(int $num)
    {
        $familySecretModel = new FamilySecretModel();
        $query = $familySecretModel->query($familySecretModel->sqlSecret, [
            'familyId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new FamilySecretEntity(
            $num,
            $arr['FamilySecretSalt'] ?? null,
            $arr['FamilySecretPassword'] ?? null
        );

        return $entity;
    }

    public function familySecretReset(string $token)
    {
        $familySecretResetModel = new FamilySecretResetModel();
        $query = $familySecretResetModel->query($familySecretResetModel->sqlToken, [
            'familySecretResetToken' => $token
        ]);
        $row = $query->getRowArray();
        if (is_null($row))
            return null;
        else {
            return new FamilySecretResetEntity(
                $row['FamilyId'] ?? null,
                $token,
                $row['FamilySecretExpiresAt'] ?? null
            );
        }
    }

    public function store($data, $dataSecret, $calendarData)
    {
        try {
            $familyModel = new FamilyModel();

            $familyModel->transException(true)->transStart();

            // Insert into family
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $familyId = $familyModel->insert($data);

            // Insert into family_secret
            $familySecretModel = new FamilySecretModel();
            $dataSecret['FamilyId'] = $familyId;
            $familySecretModel->insert($dataSecret);

            // Insert into calendar
            $calendarModel = new CalendarModel();
            $calendarData['CreatedId'] = $familyId;
            $calendarData['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $calendarId = $calendarModel->insert($calendarData);

            // Insert into calendar_family
            $calendarFamilyModel = new CalendarFamilyModel();
            $calendarDataFamily['CalendarId'] = $calendarId;
            $calendarDataFamily['CalendarFamilyFamilyFk'] = $familyId;
            $calendarDataFamily['CalendarFamilyDob'] = true;
            $calendarFamilyModel->insert($calendarDataFamily);

            $familyModel->transComplete();

            if ($familyModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function update($num, $data, $dataImage, $dataSocial, $calendarNum, $calendarData)
    {
        try {
            $familyModel = new FamilyModel();

            $familyModel->transException(true)->transStart();

            // Update into family
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $familyModel->update($num, $data);

            // Update into family_image
            $familyImageModel = new FamilyImageModel();
            $familyImage = $familyImageModel->find($num);
            if (is_null($familyImage))
                $familyImageModel->insert($dataImage);
            else
                $familyImageModel->update($num, $dataImage);


            // Update into family_social_media
            $familySocialMediaModel = new FamilySocialMediaModel();
            $familyImage = $familySocialMediaModel->find($num);
            if (is_null($familyImage))
                $familySocialMediaModel->insert($dataSocial);
            else
                $familySocialMediaModel->update($num, $dataSocial);

            // Update into calendar
            $calendarModel = new CalendarModel();
            $calendarData['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $calendarModel->update($calendarNum, $calendarData);


            $familyModel->transComplete();

            if ($familyModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function updateSecret($num, $dataSecret, $forgetPassword)
    {
        try {
            $familySecretModel = new FamilySecretModel();

            $familySecretModel->transException(true)->transStart();

            // Update into family_secret
            $familySecretModel->update($num, $dataSecret);

            // Delete forgetPassword if true
            if ($forgetPassword === true) {
                $familySecretResetModel = new FamilySecretResetModel();
                $familySecretResetModel->delete($num);
            }

            // Update into family
            $familyModel = new FamilyModel();
            $dataFamily['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $familyModel->update($num, $dataFamily);

            $familySecretModel->transComplete();

            if ($familySecretModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function saveSecretReset($num, $dataSecretReset)
    {
        try {
            $familySecretResetModel = new FamilySecretResetModel();

            $familySecretResetModel->transException(true)->transStart();

            // Update into family_secret_reset
            $familySecretResetModel->delete($num);
            $familySecretResetModel->insert($dataSecretReset);

            // Update into family
            $familyModel = new FamilyModel();
            $dataFamily['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $familyModel->update($num, $dataFamily);

            $familySecretResetModel->transComplete();

            if ($familySecretResetModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }


    // Other 
    public function getIdByEmail(string $email)
    {
        $familyModel = new FamilyModel();
        $query = $familyModel->query($familyModel->sqlEmail, [
            'email' => $email
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FamilyId'};
    }

    public function session(int $num)
    {
        $familyModel = new FamilyModel();
        $query = $familyModel->query($familyModel->sqlSession, [
            'familyId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row;
    }




}