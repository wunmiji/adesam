<?php

namespace App\ImplModel;



use App\Models\Category\CategoryModel;
use App\Models\Category\CategoryImageModel;
use App\Models\Category\CategoryTextModel;
use App\Libraries\DateLibrary;
use App\Entities\Category\CategoryEntity;
use App\Entities\Category\CategoryImageEntity;
use App\Entities\Category\CategoryTextEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class CategoryImplModel
{


    public function list()
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlList);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CategoryEntity(
                $value['CategoryId'] ?? null,
                $value['CategoryName'] ?? null,
                $value['CategorySlug'] ?? null,
                $value['CountProducts'] ?? null,
                $value['CategoryDescription'] ?? null,
                null,

                $this->categoryImage($value['CategoryId']),
                null

            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listFilter()
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlListFilter);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new CategoryEntity(
                $value['CategoryId'] ?? null,
                $value['CategoryName'] ?? null,
                $value['CategorySlug'] ?? null,
                $value['CountProducts'] ?? null,
                null,
                null,

                null,
                null

            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(string $slug)
    {
        $categoryModel = new CategoryModel();
        $query = $categoryModel->query($categoryModel->sqlRetrieve, [
            'categorySlug' => $slug,
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
            $value['CategoryName'] ?? null,
            $value['CategorySlug'] ?? null,
            $value['CountProducts'] ?? null,
            $value['CategoryDescription'] ?? null,
            DateLibrary::getDate($value['CategoryDate'] ?? null),

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
            $arr['FileUrlPath'] ?? null,
            $arr['FileName'],
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


}