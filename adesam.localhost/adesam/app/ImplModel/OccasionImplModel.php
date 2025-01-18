<?php

namespace App\ImplModel;


use App\Models\Occasion\OccasionModel;
use App\Models\Occasion\OccasionImageModel;
use App\Models\Occasion\OccasionTextModel;
use App\Models\Occasion\OccasionAuthorModel;
use App\Models\Occasion\OccasionTagsModel;
use App\Models\Occasion\OccasionMediaModel;
use App\Models\Occasion\OccasionCommentsModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\UuidLibrary;
use App\Entities\Occasion\OccasionEntity;
use App\Entities\Occasion\OccasionImageEntity;
use App\Entities\Occasion\OccasionTextEntity;
use App\Entities\Occasion\OccasionAuthorEntity;
use App\Entities\Occasion\OccasionTagsEntity;
use App\Entities\Occasion\OccasionMediaEntity;
use App\Entities\Occasion\OccasionCommentsEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class OccasionImplModel
{


    public function list(int $from, int $to)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlList, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OccasionEntity(
                $value['OccasionId'] ?? null,
                $value['OccasionTitle'] ?? null,
                $value['OccasionSlug'],
                $value['OccasionSummary'] ?? null,
                $value['OccasionStatus'] ?? null,
                DateLibrary::getDate($value['OccasionPublishedDate'] ?? null),

                $this->occasionImage($value['OccasionId']),
                null,
                null,
                $this->occasionTags($value['OccasionId']),
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listTags(string $slug, int $from, int $to)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlListTag, [
            'slug' => $slug,
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OccasionEntity(
                $value['OccasionId'] ?? null,
                $value['OccasionTitle'] ?? null,
                $value['OccasionSlug'],
                $value['OccasionSummary'] ?? null,
                $value['OccasionStatus'] ?? null,
                DateLibrary::getDate($value['OccasionPublishedDate'] ?? null),

                $this->occasionImage($value['OccasionId']),
                null,
                null,
                $this->occasionTags($value['OccasionId']),
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listSearch(string $search, int $from, int $to)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlSlugSearch, [
            'search' => $search,
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OccasionEntity(
                $value['OccasionId'] ?? null,
                $value['OccasionTitle'] ?? null,
                $value['OccasionSlug'],
                $value['OccasionSummary'] ?? null,
                $value['OccasionStatus'] ?? null,
                DateLibrary::getDate($value['OccasionPublishedDate'] ?? null),

                $this->occasionImage($value['OccasionId']),
                null,
                null,
                $this->occasionTags($value['OccasionId']),
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(string $slug)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlRetrieve, [
            'slug' => $slug,
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
            $value['OccasionTitle'] ?? null,
            $value['OccasionSlug'] ?? null,
            $value['OccasionSummary'] ?? null,
            $value['OccasionStatus'] ?? null,
            DateLibrary::getDate($value['OccasionPublishedDate'] ?? null),

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

            $arr['FamilySocialFacebook'] ?? null,
            $arr['FamilySocialInstagram'] ?? null,
            $arr['FamilySocialLinkedIn'] ?? null,
            $arr['FamilySocialTwitter'] ?? null,
            $arr['FamilySocialYoutube'] ?? null,

            $arr['FileId'] ?? null,
            $arr['FileUrlPath'],
            $arr['FileName'] ?? null,
        );

        return $entity;
    }

    public function occasionTags(int $num)
    {
        $occasionTagsModel = new OccasionTagsModel();
        $query = $occasionTagsModel->query($occasionTagsModel->sqlTags, [
            'occasionId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OccasionTagsEntity(
                $row['Id'],
                $row['OccasionId'] ?? null,
                $row['TagId'] ?? null,
                $row['TagName'] ?? null,
                $row['TagSlug'] ?? null
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

    public function occasionCommets(string $slug, string $parentId)
    {
        $occasionCommentsModel = new OccasionCommentsModel();
        $query = $occasionCommentsModel->query($occasionCommentsModel->sqlComments, [
            'slug' => $slug,
            'parentId' => $parentId
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OccasionCommentsEntity(
                $row['Id'],
                $row['OccasionId'] ?? null,
                $row['UserId'] ?? null,
                $row['OccasionCommentsParentId'],
                $row['OccasionCommentsChildId'] ?? null,
                $row['OccasionCommentsComment'] ?? null,
                $row['UserFirstName'] . ' ' . $row['UserLastName'],
                $row['Replies'] ?? null,

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,

                DateLibrary::getDate($row['CreatedDateTime'])
            );

            $arr[$row['Id']] = $entity;
        }

        return $arr;
    }

    public function saveComments($data)
    {
        try {
            $occasionCommentsModel = new OccasionCommentsModel();

            $occasionCommentsModel->transException(true)->transStart();

            // Insert into occasion_comments
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $occasionCommentId = $occasionCommentsModel->insert($data);

            // Update into occasion_comments
            $updateData['OccasionCommentsChildId'] = UuidLibrary::versionFive($occasionCommentId);
            ;
            $occasionCommentsModel->update($occasionCommentId, $updateData);

            $occasionCommentsModel->transComplete();

            if ($occasionCommentsModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function removeComment(int $num)
    {
        try {
            $occasionCommentsModel = new OccasionCommentsModel();

            $occasionCommentsModel->transException(true)->transStart();

            $query = $occasionCommentsModel->query($occasionCommentsModel->sqlDelete, [
                'commentId' => $num,
            ]);

            $affected_rows = $occasionCommentsModel->affectedRows();

            $occasionCommentsModel->transComplete();
            if ($affected_rows >= 1 && $occasionCommentsModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }



    // Other 
    public function getId(string $slug)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlId, [
            'slug' => $slug
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'OccasionId'};
    }

    public function getCommentId(string $uuid)
    {
        $occasionCommentsModel = new OccasionCommentsModel();
        $query = $occasionCommentsModel->query($occasionCommentsModel->sqlId, [
            'uuid' => $uuid
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function count()
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function tagsCount(string $slug)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlTagCount, [
            'slug' => $slug
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function searchCount(string $search)
    {
        $occasionModel = new OccasionModel();
        $query = $occasionModel->query($occasionModel->sqlSearchCount, [
            'search' => $search
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
        $pagination['arrayPageCount'] = $arrayPageCount;
        $pagination['next'] = $next;

        return $pagination;
    }

    public function paginationTags(int $queryPage, int $queryLimit, string $slug)
    {
        $pagination = array();
        $totalCount = $this->tagsCount($slug);
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->listTags($slug, $next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

            $pagination['list'] = $list;
            $pagination['arrayPageCount'] = $arrayPageCount;
            $pagination['next'] = $next;

        return $pagination;
    }

    public function paginationSearch(int $queryPage, int $queryLimit, string $search)
    {
        $find = str_replace(' ', '|', $search);
        $pagination = array();
        $totalCount = $this->searchCount($find);
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->listSearch($search, $next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['arrayPageCount'] = $arrayPageCount;
        $pagination['next'] = $next;
        $pagination['search'] = $totalCount . ' posts for ' . "'<b>" . $search . "</b>'";

        return $pagination;
    }



}