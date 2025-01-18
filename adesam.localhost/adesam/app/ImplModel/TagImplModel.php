<?php

namespace App\ImplModel;


use App\Models\Tag\TagModel;
use App\Entities\Tag\TagEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class TagImplModel
{

    public function list(string $type)
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlList, [
            'tagType' => $type,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                $value['TagName'],
                null,
                $value['TagSlug'],
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listProduct()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlListProduct);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                $value['TagName'],
                null,
                $value['TagSlug'],
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listOccasion()
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlListOccasion);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new TagEntity(
                $value['TagId'] ?? null,
                $value['TagName'],
                null,
                $value['TagSlug'],
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(string $slug, string $type)
    {
        $tagModel = new TagModel();
        $query = $tagModel->query($tagModel->sqlRetrieve, [
            'tagType' => $type,
            'tagSlug' => $slug,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->tag($row);
        }
    }

    public function tag($value)
    {
        return new TagEntity(
            $value['TagId'] ?? null,
            $value['TagName'],
            null,
            $value['TagSlug'],
        );

    }


}