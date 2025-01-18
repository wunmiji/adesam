<?php

namespace App\ImplModel;


use App\Enums\DiscountType;
use App\Models\Discount\DiscountModel;
use App\Models\Product\ProductDiscountModel;
use App\Libraries\DateLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Discount\DiscountEntity;
use App\Entities\Discount\DiscountProductsEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class DiscountImplModel
{


    public function list()
    {
        $discountModel = new DiscountModel();
        $query = $discountModel->query($discountModel->sqlList);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new DiscountEntity(
                $value['DiscountId'] ?? null,
                null,
                $value['DiscountType'],
                $value['DiscountName'],
                $value['DiscountValue'],

                null,
                null,
                null,

                self::stringDiscount($value['DiscountType'], $value['DiscountName'], $value['DiscountValue']),
                
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableProduct()
    {
        $discountModel = new DiscountModel();
        $query = $discountModel->query($discountModel->sqlTable);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new DiscountEntity(
                $value['DiscountId'] ?? null,
                SecurityLibrary::encryptUrlId($value['DiscountId']),
                DiscountType::getValue($value['DiscountType']),
                $value['DiscountName'],
                $value['DiscountValue'],

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                self::stringDiscount($value['DiscountType'], $value['DiscountName'], $value['DiscountValue']),
                $this->tableProductList($value['DiscountId']),
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function tableProductList(int $num)
    {
        $productDiscountModel = new ProductDiscountModel();
        $query = $productDiscountModel->query($productDiscountModel->sqlProducts, [
            'discountId' => $num
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new DiscountProductsEntity(
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
            $discountModel = new DiscountModel();

            $discountModel->transException(true)->transStart();

            // Insert into discount
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $discountId = $discountModel->insert($data);

            $discountModel->transComplete();

            if ($discountModel->transStatus() === false)
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
            $discountModel = new DiscountModel();

            $discountModel->transException(true)->transStart();

            $query = $discountModel->query($discountModel->sqlDelete, [
                'discountId' => $num,
            ]);

            $affected_rows = $discountModel->affectedRows();

            $discountModel->transComplete();
            if ($affected_rows >= 1 && $discountModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public static function stringDiscount(string $type, string $name, int $value)
    {
        $stringDiscount = null;
        if ($type == DiscountType::PERCENTAGE->name) {
            $stringDiscount = $name . ' ' . $value . '%';
        } elseif ($type == DiscountType::AMOUNT->name) {
            $stringDiscount = $name . ' #' . $value;
        }
        return $stringDiscount;
    }




    // Other
    public function getType(int $num)
    {
        $discountModel = new DiscountModel();
        $query = $discountModel->query($discountModel->sqlType, [
            'discountId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'DiscountType'};
    }


}