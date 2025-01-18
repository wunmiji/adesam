<?php

namespace App\ImplModel;



use App\Models\Category\CategoryModel;
use App\Models\Category\CategoryImageModel;
use App\Models\Category\CategoryTextModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Category\CategoryEntity;
use App\Entities\Category\CategoryImageEntity;
use App\Entities\Category\CategoryTextEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class CategoryImplModel extends BaseImplModel
{


    public function list(int $from, int $to)
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CategoryEntity(
                $value['CategoryId'] ?? null,
                SecurityLibrary::encryptUrlId($value['CategoryId']),
                $value['CategoryName'] ?? null,
                null,
                $value['CountProduct'] ?? null,
                $value['CategoryDescription'] ?? null,
                DateLibrary::getDate($value['CategoryDate'] ?? null),

                null,
                null,
                null,

                null,
                null,
                null,

                $this->categoryImage($value['CategoryId']),
                null

            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(int $num)
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlRetrieve, [
            'categoryId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->category($row);
        }
    }

    public function category($value)
    {
        return new CategoryEntity(
            $value['CategoryId'] ?? null,
            SecurityLibrary::encryptUrlId($value['CategoryId']),
            $value['CategoryName'] ?? null,
            $value['CategorySlug'] ?? null,
            $value['CountProduct'] ?? null,
            $value['CategoryDescription'] ?? null,
            DateLibrary::getDate($value['CategoryDate'] ?? null),

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->categoryImage($value['CategoryId']),
            $this->categoryText($value['CategoryId']),

        );

    }

    public function categoryImage(int $num)
    {
        $categoryImageModel = new CategoryImageModel();
        $query = $categoryImageModel->query($categoryImageModel->sqlImage, [
            'categoryId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new CategoryImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileUrlPath'],
            $arr['FileName'] ?? null,
        );

        return $entity;
    }

    public function categoryText(int $num)
    {
        $categoryTextModel = new CategoryTextModel();
        $query = $categoryTextModel->query($categoryTextModel->sqlText, [
            'categoryId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new CategoryTextEntity(
            $num,
            $arr['CategoryText'] ?? null
        );

        return $entity;
    }

    public function save($data, $dataImage, $dataText)
    {
        try {
            $categoryModel = new CategoryModel();
            $utc = DateLibrary::getZoneDateTime();

            $categoryModel->transException(true)->transStart();

            // Insert into category
            $data['CreatedDateTime'] = $utc;
            $data['CategoryDate'] = DateLibrary::getMysqlDate($utc);
            $categoryId = $categoryModel->insert($data);

            // Insert into category_image
            $dataImage['CategoryId'] = $categoryId;
            $categoryImageModel = new CategoryImageModel();
            $categoryImageModel->insert($dataImage);

            // Insert into category_text
            $dataText['CategoryId'] = $categoryId;
            $categoryTextModel = new CategoryTextModel();
            $categoryTextModel->insert($dataText);


            $categoryModel->transComplete();

            if ($categoryModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText)
    {
        try {
            $categoryModel = new CategoryModel();

            $categoryModel->transException(true)->transStart();

            // Update into category
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $categoryModel->update($num, $data);

            // Update into category_text
            $categoryTextModel = new CategoryTextModel();
            $categoryTextModel->update($num, $dataText);

            // Update into category_image
            $categoryImageModel = new CategoryImageModel();
            $categoryImageModel->update($num, $dataImage);

            $categoryModel->transComplete();

            if ($categoryModel->transStatus() === false)
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
            $categoryModel = new CategoryModel();
            $categoryModel->transException(true)->transStart();

            $query = $categoryModel->query($categoryModel->sqlDelete, [
                'categoryId' => $num,
            ]);

            $affected_rows = $categoryModel->affectedRows();

            $categoryModel->transComplete();
            if ($affected_rows >= 1 && $categoryModel->transStatus() === true)
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
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function sumProductQuantity(int $categoryId)
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlSumProductQuantity, [
            'categoryId' => $categoryId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'SumProductQuantity'};
    }

    public function sumProductPrice(int $categoryId)
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlSumProductPrice, [
            'categoryId' => $categoryId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $this->stringCurrency($row->{'SumProductPrice'} ?? 0);
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