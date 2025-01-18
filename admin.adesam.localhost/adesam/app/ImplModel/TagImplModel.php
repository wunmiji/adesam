<?php

namespace App\ImplModel;


use App\Enums\TagType;
use App\Models\Tag\TagModel;
use App\Models\Contact\ContactTagsModel;
use App\Models\Occasion\OccasionTagsModel;
use App\Models\Product\ProductTagsModel;
use App\Libraries\DateLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Tag\TagEntity;
use App\Entities\Tag\TagContactsEntity;
use App\Entities\Tag\TagOccasionsEntity;
use App\Entities\Tag\TagProductsEntity;
use App\Enums\Gender;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class TagImplModel
{


    public function listContact()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTags, [
            'type' => TagType::CONTACT->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                null,
                $value['TagName'],
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listOccasion()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTags, [
            'type' => TagType::OCCASION->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                null,
                $value['TagName'],
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listProduct()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTags, [
            'type' => TagType::PRODUCT->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                null,
                $value['TagName'],
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableContact()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTable, [
            'type' => TagType::CONTACT->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                SecurityLibrary::encryptUrlId($value['TagId']),
                $value['TagName'],
                $value['TagType'],
                $value['TagSlug'],

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $this->tableContactList($value['TagId']),
                null,
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableOccasion()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTable, [
            'type' => TagType::OCCASION->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                SecurityLibrary::encryptUrlId($value['TagId']),
                $value['TagName'],
                $value['TagType'],
                $value['TagSlug'],

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                null,
                null,
                $this->tableOccasionList($value['TagId']),
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableProduct()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlTable, [
            'type' => TagType::PRODUCT->name
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                SecurityLibrary::encryptUrlId($value['TagId']),
                $value['TagName'],
                $value['TagType'],
                $value['TagSlug'],

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                null,
                $this->tableProductList($value['TagId']),
                null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableContactList(int $num)
    {
        $contactTagsModel = new ContactTagsModel();
        $query = $contactTagsModel->query($contactTagsModel->sqlContacts, [
            'tagId' => $num
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagContactsEntity(
                $value['Id'] ?? null,
                $value['ContactId'],
                SecurityLibrary::encryptUrlId($value['ContactId']),
                $value['ContactNickName'],

                $value['FileId'] ?? null,
                $value['FileUrlPath'],
                $value['FileName'] ?? null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableOccasionList(int $num)
    {
        $occasionTagsModel = new OccasionTagsModel();
        $query = $occasionTagsModel->query($occasionTagsModel->sqlOccasions, [
            'tagId' => $num
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagOccasionsEntity(
                $value['Id'] ?? null,
                $value['OccasionId'],
                SecurityLibrary::encryptUrlId($value['OccasionId']),
                $value['OccasionTitle'],

                $value['FileId'] ?? null,
                $value['FileUrlPath'],
                $value['FileName'] ?? null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableProductList(int $num)
    {
        $productTagsModel = new ProductTagsModel();
        $query = $productTagsModel->query($productTagsModel->sqlProducts, [
            'tagId' => $num
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagProductsEntity(
                $value['Id'] ?? null,
                $value['ProductId'],
                SecurityLibrary::encryptUrlId($value['ProductId']),
                $value['ProductName'],

                $value['FileId'] ?? null,
                $value['FileUrlPath'],
                $value['FileName'] ?? null,
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function store($data)
    {
        try {
            $tagModel = new TagModel();

            $tagModel->transException(true)->transStart();

            // Insert into tag
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $tagId = $tagModel->insert($data);

            $tagModel->transComplete();

            if ($tagModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function delete(int $num)
    {
        try {
            $tagModel = new TagModel();

            $tagModel->transException(true)->transStart();

            $query = $tagModel->query($tagModel->sqlDelete, [
                'tagId' => $num,
            ]);

            $affected_rows = $tagModel->affectedRows();

            $tagModel->transComplete();
            if ($affected_rows >= 1 && $tagModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }


}