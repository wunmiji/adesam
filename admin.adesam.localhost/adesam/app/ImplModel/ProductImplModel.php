<?php

namespace App\ImplModel;



use App\Models\Product\ProductModel;
use App\Models\Product\ProductImageModel;
use App\Models\Product\ProductImagesModel;
use App\Models\Product\ProductTextModel;
use App\Models\Product\ProductDiscountModel;
use App\Models\Product\ProductCategoryModel;
use App\Models\Product\ProductTagsModel;
use App\Models\Product\ProductAddtionalInformationsModel;
use App\Libraries\DateLibrary;
use App\Libraries\ArrayLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Product\ProductEntity;
use App\Entities\Product\ProductImageEntity;
use App\Entities\Product\ProductImagesEntity;
use App\Entities\Product\ProductTextEntity;
use App\Entities\Product\ProductDiscountEntity;
use App\Entities\Product\ProductCategoryEntity;
use App\Entities\Product\ProductTagsEntity;
use App\Entities\Product\ProductAddtionalInformationsEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class ProductImplModel extends BaseImplModel
{


    public function list(int $from, int $to)
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProductEntity(
                $value['ProductId'] ?? null,
                SecurityLibrary::encryptUrlId($value['ProductId']),
                $value['ProductName'] ?? null,
                null,
                $value['ProductVisibilityStatus'] ?? null,
                $value['ProductStockStatus'] ?? null,
                $value['ProductQuantity'] ?? null,
                null,
                null,
                null,
                $value['ProductUnique'] ?? null,
                $value['ProductDescription'] ?? null,

                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                $this->stringCurrency($value['ProductActualSellingPrice']),

                $this->productImage($value['ProductId']),
                null,
                null,
                null,
                $this->productTags($value['ProductId']),
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function listCategoryProducts(int $categoryId)
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlCategoryProducts, [
            'categoryId' => $categoryId
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProductEntity(
                $value['ProductId'] ?? null,
                SecurityLibrary::encryptUrlId($value['ProductId']),
                $value['ProductName'] ?? null,
                null,
                $value['ProductVisibilityStatus'] ?? null,
                $value['ProductStockStatus'] ?? null,
                $value['ProductQuantity'] ?? null,
                null,
                null,
                null,
                $value['ProductUnique'] ?? null,
                null,


                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                $this->stringCurrency($value['ProductActualSellingPrice']),

                $this->productImage($value['ProductId']),
                null,
                null,
                null,
                null,
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function productPerMonth(int $year)
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->productPerMonth, [
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
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlRetrieve, [
            'productId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->product($row);
        }
    }

    public function product($value)
    {
        return new ProductEntity(
            $value['ProductId'] ?? null,
            SecurityLibrary::encryptUrlId($value['ProductId']),
            $value['ProductName'] ?? null,
            $value['ProductSku'] ?? null,
            $value['ProductVisibilityStatus'] ?? null,
            $value['ProductStockStatus'] ?? null,
            $value['ProductQuantity'] ?? null,
            $value['ProductCostPrice'] ?? null,
            $value['ProductSellingPrice'] ?? null,
            $value['ProductActualSellingPrice'] ?? null,
            $value['ProductUnique'] ?? null,
            $value['ProductDescription'] ?? null,

            $value['CreatedId'] ?? null,
            $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

            $value['ModifiedId'] ?? null,
            $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->stringCurrency($value['ProductCostPrice']),
            $this->stringCurrency($value['ProductSellingPrice']),
            $this->stringCurrency($value['ProductActualSellingPrice']),

            $this->productImage($value['ProductId']),
            $this->productText($value['ProductId']),
            $this->productDiscount($value['ProductId']),
            $this->productCategory($value['ProductId']),
            $this->productTags($value['ProductId']),
            $this->productImages($value['ProductId']),
            $this->productAddtionalInformations($value['ProductId'])

        );

    }

    public function productImage(int $num)
    {
        $productImageModel = new ProductImageModel();
        $query = $productImageModel->query($productImageModel->sqlFile, [
            'productId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ProductImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileUrlPath'],
            $arr['FileName'] ?? null,
        );

        return $entity;
    }

    public function productText(int $num)
    {
        $productTextModel = new ProductTextModel();
        $query = $productTextModel->query($productTextModel->sqlText, [
            'productId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new ProductTextEntity(
            $num,
            $arr['ProductText'] ?? null
        );

        return $entity;
    }

    public function productDiscount(int $num)
    {
        $productDiscountModel = new ProductDiscountModel();
        $query = $productDiscountModel->query($productDiscountModel->sqlDiscount, [
            'productId' => $num,
        ]);
        $arr = $query->getRowArray();

        if (is_null($arr)) {
            return null;
        } else {
            $entity = new ProductDiscountEntity(
                $num,
                $arr['DiscountId'] ?? null,
                $arr['DiscountName'] ?? null,
                $arr['DiscountType'] ?? null,
                $arr['DiscountValue'] ?? null,

                (is_null($arr['DiscountId']) ? null : DiscountImplModel::stringDiscount($arr['DiscountType'], $arr['DiscountName'], $arr['DiscountValue']))
            );

            return $entity;
        }
    }

    public function productCategory(int $num)
    {
        $productCategoryModel = new ProductCategoryModel();
        $query = $productCategoryModel->query($productCategoryModel->sqlCategory, [
            'productId' => $num,
        ]);
        $arr = $query->getRowArray();

        if (is_null($arr)) {
            return null;
        } else {
            $entity = new ProductCategoryEntity(
                $num,
                $arr['CategoryId'] ?? null,
                $arr['CategoryName'] ?? null
            );

            return $entity;
        }
    }

    public function productTags(int $num)
    {
        $productTagModel = new ProductTagsModel();
        $query = $productTagModel->query($productTagModel->sqlTags, [
            'productId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProductTagsEntity(
                $row['Id'],
                $row['ProductId'] ?? null,
                $row['TagId'] ?? null,
                $row['TagName'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function productImages(int $num)
    {
        $productImagesModel = new ProductImagesModel();
        $query = $productImagesModel->query($productImagesModel->sqlImages, [
            'productId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProductImagesEntity(
                $row['Id'] ?? null,
                $row['ProductId'] ?? null,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
                $row['FileMimeType'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }

        return $arr;
    }

    public function productAddtionalInformations(int $num)
    {
        $productAddtionalInformationsModel = new ProductAddtionalInformationsModel();
        $query = $productAddtionalInformationsModel->query($productAddtionalInformationsModel->sqlAddtionalInformations, [
            'productId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProductAddtionalInformationsEntity(
                $row['Id'],
                $row['ProductId'] ?? null,
                $row['ProductAddtionalInformationsField'] ?? null,
                $row['ProductAddtionalInformationsTag'] ?? null
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function save($data, $dataImage, $dataText, $dataCategory, $dataDiscount, $dataTags, $dataImages, $dataAddtionalInformations)
    {
        try {
            $productModel = new ProductModel();

            $productModel->transException(true)->transStart();

            // Insert into product
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $productId = $productModel->insert($data);

            // Insert into product_image
            $firstImage = current($dataImages);
            $dataImage['ProductId'] = $productId;
            $dataImage['ProductImageFileFk'] = $firstImage['ProductImagesFileFk'];
            $productImageModel = new ProductImageModel();
            $productImageModel->insert($dataImage);

            // Insert into product_text
            $dataText['ProductId'] = $productId;
            $productTextModel = new ProductTextModel();
            $productTextModel->insert($dataText);

            // Insert into product_category
            $dataCategory['ProductId'] = $productId;
            $productCategoryModel = new ProductCategoryModel();
            $productCategoryModel->insert($dataCategory);

            // Insert into product_discount
            if (!empty($dataDiscount)) {
                $dataDiscount['ProductId'] = $productId;
                $productDiscountModel = new ProductDiscountModel();
                $productDiscountModel->insert($dataDiscount);
            }

            // Insert into product_tags
            $productTagsModel = new ProductTagsModel();
            foreach ($dataTags as $key => $dataTag) {
                $dataTag['ProductTagProductFk'] = $productId;
                $productTagsModel->insert($dataTag);
            }

            // Insert into product_images
            $productImagesModel = new ProductImagesModel();
            foreach ($dataImages as $key => $dataImage) {
                $dataImage['ProductImagesProductFk'] = $productId;
                $productImagesModel->insert($dataImage);
            }

            // Insert into product_additional_informations
            $productAddtionalInformationsModel = new ProductAddtionalInformationsModel();
            foreach ($dataAddtionalInformations as $key => $dataAddtionalInformation) {
                $dataAddtionalInformation['ProductAddtionalInformationsProductFk'] = $productId;
                $productAddtionalInformationsModel->insert($dataAddtionalInformation);
            }

            $productModel->transComplete();

            if ($productModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function update($num, $data, $dataImage, $dataText, $dataCategory, $dataDiscount, $dataTags, $dataImages, $dataAddtionalInformations)
    {
        try {
            $productModel = new ProductModel();

            $productModel->transException(true)->transStart();

            // Update into product
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $productModel->update($num, $data);

            // Update into product_image
            $firstImage = current($dataImages);
            $dataImage['ProductImageFileFk'] = $firstImage['ProductImagesFileFk'];
            $productImageModel = new ProductImageModel();
            $productImageModel->update($num, $dataImage);

            // Update into product_text
            $productTextModel = new ProductTextModel();
            $productTextModel->update($num, $dataText);

            // Update into product_category
            $productCategoryModel = new ProductCategoryModel();
            $productCategoryModel->update($num, $dataCategory);

            // Update into product_discount
            if (!empty($dataDiscount)) {
                $productDiscountModel = new ProductDiscountModel();
                if (is_null($this->productDicountId($num)))
                    $productDiscountModel->insert($dataDiscount);
                else
                    $productDiscountModel->update($num, $dataDiscount);
            }


            // Update into product_tags
            $productTagsModel = new ProductTagsModel();
            $this->updateOneToMany($productTagsModel, 'ProductTagProductFk', $num, $dataTags);

            // Update into product_images
            $productImagesModel = new ProductImagesModel();
            $this->updateOneToMany($productImagesModel, 'ProductImagesProductFk', $num, $dataImages);

            // Update into product_additional_informations
            $productAddtionalInformationsModel = new ProductAddtionalInformationsModel();
            $this->updateOneToMany($productAddtionalInformationsModel, 'ProductAddtionalInformationsProductFk', $num, $dataAddtionalInformations);

            $productModel->transComplete();

            if ($productModel->transStatus() === false)
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
            $productModel = new ProductModel();
            $productModel->transException(true)->transStart();

            $query = $productModel->query($productModel->sqlDelete, [
                'productId' => $num,
            ]);

            $affected_rows = $productModel->affectedRows();

            $productModel->transComplete();
            if ($affected_rows >= 1 && $productModel->transStatus() === true)
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

    public function productDicountId(int $num)
    {
        $productDiscountModel = new ProductDiscountModel();
        $query = $productDiscountModel->query($productDiscountModel->sqlId, [
            'productId' => $num
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function generateUnique()
    {
        $random = mt_rand(1000000000, 9999999999);
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlUnique, [
            'productUnique' => $random
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? $random : $this->generateUnique();
    }

    public function count()
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlCount);
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