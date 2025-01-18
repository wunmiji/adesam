<?php

namespace App\ImplModel;



use App\Models\Occasion\OccasionModel;
use App\Models\Occasion\OccasionImageModel;
use App\Models\Occasion\OccasionTextModel;
use App\Models\Occasion\OccasionAuthorModel;
use App\Models\Occasion\OccasionTagsModel;
use App\Models\Occasion\OccasionMediaModel;
use App\Models\Calendar\CalendarModel;
use App\Models\Calendar\CalendarImageModel;
use App\Models\Calendar\CalendarOccasionModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\SecurityLibrary;
use App\Enums\OccasionStatus;
use App\Entities\Occasion\OccasionEntity;
use App\Entities\Occasion\OccasionImageEntity;
use App\Entities\Occasion\OccasionTextEntity;
use App\Entities\Occasion\OccasionAuthorEntity;
use App\Entities\Occasion\OccasionTagsEntity;
use App\Entities\Occasion\OccasionMediaEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class OccasionImplModel
{


    public function list(int $from, int $to)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OccasionEntity(
                $value['OccasionId'] ?? null,
                SecurityLibrary::encryptUrlId($value['OccasionId']),
                $value['OccasionTitle'] ?? null,
                null,
                $value['OccasionSummary'] ?? null,
                $value['OccasionStatus'] ?? null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,

                $this->occasionImage($value['OccasionId']),
                null,
                null,
                $this->occasionTags($value['OccasionId']),
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function occasionPerMonth(int $year)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->occasionPerMonth, [
            'year' => $year
        ]);
        $list = $query->getResultArray();

        $default = [
            ['x' => 'Jan', 'y' => '0'],
            ['x' => 'Feb', 'y' => '0'],
            ['x' => 'Mar', 'y' => '0'],
            ['x' => 'Apr', 'y' => '0'],
            ['x' => 'May', 'y' => '0'],
            ['x' => 'Jun', 'y' => '0'],
            ['x' => 'Jul', 'y' => '0'],
            ['x' => 'Aug', 'y' => '0'],
            ['x' => 'Sep', 'y' => '0'],
            ['x' => 'Oct', 'y' => '0'],
            ['x' => 'Nov', 'y' => '0'],
            ['x' => 'Dec', 'y' => '0']
        ];

        foreach ($default as $defaultKey => $value) {
            foreach ($list as $key => $each) {
                if ($value['x'] == $each['x']) {
                    $default[$defaultKey] = $each;
                }
            }
        }

        $list = array_column($default, 'y');

        return json_encode($list);
    }

    public function retrieve(int $num)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlRetrieve, [
            'occasionId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->occasion($row);
        }
    }

    public function occasion($value)
    {
        return new OccasionEntity(
            $value['OccasionId'] ?? null,
            SecurityLibrary::encryptUrlId($value['OccasionId']),
            $value['OccasionTitle'] ?? null,
            $value['OccasionSlug'] ?? null,
            $value['OccasionSummary'] ?? null,
            $value['OccasionStatus'] ?? null,
            DateLibrary::getFormat($value['OccasionPublishedDate'] ?? null),

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->occasionImage($value['OccasionId']),
            $this->occasionText($value['OccasionId']),
            $this->occasionAuthor($value['OccasionId']),
            $this->occasionTags($value['OccasionId']),
            $this->occasionMedias($value['OccasionId'])

        );

    }

    public function occasionImage(int $num)
    {
        $occasionImageModel = new OccasionImageModel();
        $query = $occasionImageModel->query($occasionImageModel->sqlFile, [
            'occasionId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new OccasionImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileUrlPath'],
            $arr['FileName'] ?? null,
        );

        return $entity;
    }

    public function occasionText(int $num)
    {
        $occasionTextModel = new OccasionTextModel();
        $query = $occasionTextModel->query($occasionTextModel->sqlText, [
            'occasionId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new OccasionTextEntity(
            $num,
            $arr['OccasionText'] ?? null
        );

        return $entity;
    }

    public function occasionAuthor(int $num)
    {
        $occasionAuthorModel = new OccasionAuthorModel();
        $query = $occasionAuthorModel->query($occasionAuthorModel->sqlAuthor, [
            'occasionId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new OccasionAuthorEntity(
            $num,
            $arr['OccasionAuthorFamilyFk'] ?? null,
            $arr['FirstName'] . ' ' . $arr['LastName'],
            $arr['FamilyDescription'] ?? null,
            $arr['FileId'] ?? null,
            $arr['FileUrlPath'],
            $arr['FileName'] ?? null,
        );

        return $entity;
    }

    public function occasionTags(int $num)
    {
        $occasionTagModel = new OccasionTagsModel();
        $query = $occasionTagModel->query($occasionTagModel->sqlTags, [
            'occasionId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OccasionTagsEntity(
                $row['Id'],
                $row['OccasionId'] ?? null,
                $row['TagId'] ?? null,
                $row['TagName'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function occasionMedias(int $num)
    {
        $occasionMediaModel = new OccasionMediaModel();
        $query = $occasionMediaModel->query($occasionMediaModel->sqlMedia, [
            'occasionId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OccasionMediaEntity(
                $row['OccasionMediaId'] ?? null,
                $row['OccasionId'] ?? null,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
                $row['FileMimeType'] ?? null
            );

            $arr[$row['OccasionMediaId']] = $entity;
        }

        return $arr;
    }

    public function save($data, $dataImage, $dataText, $dataAuthor, $dataTags, $dataMedias, $calendarData)
    {
        try {
            $occasionModel = new OccasionModel();

            $occasionModel->transException(true)->transStart();

            // Insert into occasion
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $occasionId = $occasionModel->insert($data);

            // Insert into occasion_image
            $dataImage['OccasionId'] = $occasionId;
            $occasionImageModel = new OccasionImageModel();
            $occasionImageModel->insert($dataImage);

            // Insert into occasion_text
            $dataText['OccasionId'] = $occasionId;
            $occasionTextModel = new OccasionTextModel();
            $occasionTextModel->insert($dataText);

            // Insert into occasion_author
            $dataAuthor['OccasionId'] = $occasionId;
            $occasionAuthorModel = new OccasionAuthorModel();
            $occasionAuthorModel->insert($dataAuthor);

            // Insert into occasion_tags
            $occasionTagModel = new OccasionTagsModel();
            foreach ($dataTags as $key => $dataTag) {
                $dataTag['OccasionTagOccasionFk'] = $occasionId;
                $occasionTagModel->insert($dataTag);
            }

            // Insert into occasion_media
            $occasionMediaModel = new OccasionMediaModel();
            foreach ($dataMedias as $key => $dataMedia) {
                $dataMedia['OccasionMediaOccasionFk'] = $occasionId;
                $occasionMediaModel->insert($dataMedia);
            }

            // Insert into calendar, calendar_image and calendar_occasion
            if (!empty($calendarData)) {
                // calender
                $calendarModel = new CalendarModel();
                $calendarData['CreatedDateTime'] = DateLibrary::getZoneDateTime();
                $calendarId = $calendarModel->insert($calendarData);

                // calendar_image
                $calendarImageModel = new CalendarImageModel();
                $calendarDataImage['CalendarId'] = $calendarId;
                $calendarDataImage['CalendarImageFileFk'] = $dataImage['OccasionImageFileFk'];
                $calendarImageModel->insert($calendarDataImage);

                // calendar_occasion
                $calendarOccasionModel = new CalendarOccasionModel();
                $calendarDataOccasion['CalendarId'] = $calendarId;
                $calendarDataOccasion['CalendarOccasionOccasionFk'] = $occasionId;
                $calendarOccasionModel->insert($calendarDataOccasion);
            }

            $occasionModel->transComplete();

            if ($occasionModel->transStatus() === false)
                return false;
            else {
                // if ($data['OccasionStatus'] == OccasionStatus::SCHEDULED->name) {
                //     service('queue')->push('queue_occasions', 'occasion', [
                //         'id' => $occasionId,
                //         'published_date' => $data['OccasionPublishedDate']
                //     ]);
                // }
                return true;
            }
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText, $dataAuthor, $dataTags, $dataMedias, $calendarNum, $calendarData)
    {
        try {
            $occasionModel = new OccasionModel();

            $occasionModel->transException(true)->transStart();

            // Update into occasion
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $occasionModel->update($num, $data);

            // Update into occasion_text
            $occasionTextModel = new OccasionTextModel();
            $occasionTextModel->update($num, $dataText);

            // Update into occasion_image
            $occasionImageModel = new OccasionImageModel();
            $occasionImageModel->update($num, $dataImage);

            // Update into occasion_author
            $occasionAuthorModel = new OccasionAuthorModel();
            $occasionAuthorModel->update($num, $dataAuthor);

            // Update into occasion_labels
            $occasionTagModel = new OccasionTagsModel();
            $this->updateOneToMany($occasionTagModel, 'OccasionTagOccasionFk', $num, $dataTags);

            // Update into occasion_medias
            $occasionMediaModel = new OccasionMediaModel();
            $this->updateOneToMany($occasionMediaModel, 'OccasionMediaOccasionFk', $num, $dataMedias);


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
                    $calendarDataImage['CalendarId'] = $calendarNum;
                    $calendarDataImage['CalendarImageFileFk'] = $dataImage['OccasionImageFileFk'];
                    $calendarImageModel->insert($calendarDataImage);

                    // calendar_contact
                    $calendarOccasionModel = new CalendarOccasionModel();
                    $calendarDataOccasion['CalendarId'] = $calendarNum;
                    $calendarDataOccasion['CalendarOccasionOccasionFk'] = $num;
                    $calendarOccasionModel->insert($calendarDataOccasion);
                } else {
                    $calendarData['ModifiedId'] = $data['ModifiedId'];
                    $calendarData['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
                    $calendarModel->update($calendarNum, $calendarData);

                    // calendar_image
                    $calendarDataImage['CalendarImageFileFk'] = $dataImage['OccasionImageFileFk'];
                    $calendarImageModel->update($calendarNum, $calendarDataImage);
                }

            }

            $occasionModel->transComplete();

            if ($occasionModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function updatePublishedDate($num, $date)
    {
        try {
            $occasionModel = new OccasionModel();

            $occasionModel->transException(true)->transStart();

            // Update into occasion
            $data['OccasionPublishedDate'] = $date;
            $data['OccasionStatus'] = OccasionStatus::PUBLISHED->name;
            $occasionModel->update($num, $data);

            $occasionModel->transComplete();

            if ($occasionModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function delete(int $num, ?int $calendarId)
    {
        try {
            $occasionModel = new OccasionModel();

            $occasionModel->transException(true)->transStart();

            $query = $occasionModel->query($occasionModel->sqlDelete, [
                'occasionId' => $num,
            ]);

            if (!is_null($calendarId)) {
                $calendarModel = new CalendarModel();
                $calendarModel->delete($calendarId);
            }

            $affected_rows = $occasionModel->affectedRows();

            $occasionModel->transComplete();
            if ($affected_rows >= 1 && $occasionModel->transStatus() === true)
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
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlCount);
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