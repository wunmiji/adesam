<?php

namespace App\ImplModel;



use App\Enums\DiscountType;
use App\Models\Shop\Product\ProductModel;
use App\Models\Shop\Product\ProductImageModel;
use App\Models\Shop\Product\ProductImagesModel;
use App\Models\Shop\Product\ProductTextModel;
use App\Models\Shop\Product\ProductDiscountModel;
use App\Models\Shop\Product\ProductCategoryModel;
use App\Models\Shop\Product\ProductTagsModel;
use App\Models\Shop\Product\ProductAddtionalInformationsModel;
use App\Models\Shop\Cart\CartModel;
use App\Models\Shop\Cart\CartItemsModel;
use App\Models\Shop\Order\OrderModel;
use App\Models\Shop\Order\OrderItemsModel;
use App\Models\Shop\Order\OrderShippingModel;
use App\Models\Shop\Order\OrderBillingAddressModel;
use App\Models\Shop\Order\OrderShippingAddressModel;
use App\Models\Shop\Order\OrderPaymentsModel;
use App\Libraries\DateLibrary;
use App\Enums\ProductStatus;
use App\Enums\ShippingType;
use App\Enums\PaymentMethod;
use App\Entities\Shop\Product\ProductEntity;
use App\Entities\Shop\Product\ProductImageEntity;
use App\Entities\Shop\Product\ProductImagesEntity;
use App\Entities\Shop\Product\ProductTextEntity;
use App\Entities\Shop\Product\ProductDiscountEntity;
use App\Entities\Shop\Product\ProductCategoryEntity;
use App\Entities\Shop\Product\ProductTagsEntity;
use App\Entities\Shop\Product\ProductAddtionalInformationsEntity;
use App\Entities\Shop\Cart\CartEntity;
use App\Entities\Shop\Cart\CartItemsEntity;
use App\Entities\Shop\Order\OrderEntity;
use App\Entities\Shop\Order\OrderItemsEntity;
use App\Entities\Shop\Order\OrderShippingEntity;
use App\Entities\Shop\Order\OrderPaymentsEntity;
use App\Entities\Shop\Order\OrderBillingAddressEntity;
use App\Entities\Shop\Order\OrderShippingAddressEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class ShopImplModel extends BaseImplModel
{

    public function listFilter(string $tag, string $category, string $minPriceQuery, $maxPriceQuery, string $sort, int $from, int $to)
    {
        $order = null;
        if ($sort == 'alphabet')
            $order = 'ProductName ASC';
        elseif ($sort == 'alphabet-desc')
            $order = 'ProductName DESC';
        elseif ($sort == 'date')
            $order = 'ProductPublishedDate ASC';
        elseif ($sort == 'date-desc')
            $order = 'ProductPublishedDate DESC';
        elseif ($sort == 'price')
            $order = 'ProductActualSellingPrice ASC';
        elseif ($sort == 'price-desc')
            $order = 'ProductActualSellingPrice DESC';
        else
            $order = 'ProductId DESC';

        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->select('product.ProductId, product.ProductName, product.ProductStockStatus, product.ProductSellingPrice, product.ProductActualSellingPrice, product.ProductUnique');
        if (!empty($category)) {
            $builder->join('product_category', 'product_category.ProductId = product.ProductId');
            $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');
        }
        if (!empty($tag)) {
            $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
            $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');
        }
        if (!empty($category)) {
            $categoryArray = explode(',', $category);
            $builder->whereIn('category.CategorySlug', $categoryArray);
        }
        if (!empty($tag)) {
            $tagArray = explode(',', $tag);
            $builder->whereIn('tag.TagSlug', $tagArray);
        }
        if (!empty($minPriceQuery))
            $builder->where('product.ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('product.ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $builder->orderBy('product.' . $order);
        $sql = $builder->getCompiledSelect() . ' LIMIT ' . $from . ', ' . $to;

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProductEntity(
                $value['ProductId'] ?? null,
                $value['ProductName'] ?? null,
                null,
                null,
                $value['ProductStockStatus'] ?? null,
                null,
                null,
                $value['ProductSellingPrice'],
                $value['ProductActualSellingPrice'],
                $value['ProductUnique'] ?? null,
                null,

                null,
                $this->stringCurrency($value['ProductSellingPrice']),
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

    public function categoryListFilter(string $categorySlug, string $tag, string $minPriceQuery, $maxPriceQuery, string $sort, int $from, int $to)
    {
        $order = null;
        if ($sort == 'alphabet')
            $order = 'ProductName ASC';
        elseif ($sort == 'alphabet-desc')
            $order = 'ProductName DESC';
        elseif ($sort == 'date')
            $order = 'ProductPublishedDate ASC';
        elseif ($sort == 'date-desc')
            $order = 'ProductPublishedDate DESC';
        elseif ($sort == 'price')
            $order = 'ProductActualSellingPrice ASC';
        elseif ($sort == 'price-desc')
            $order = 'ProductActualSellingPrice DESC';
        else
            $order = 'ProductId DESC';

        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->select('product.ProductId, product.ProductName, product.ProductStockStatus, product.ProductSellingPrice, product.ProductActualSellingPrice, product.ProductUnique');

        $builder->join('product_category', 'product_category.ProductId = product.ProductId');
        $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');

        if (!empty($tag)) {
            $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
            $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');
        }
        if (!empty($tag)) {
            $tagArray = explode(',', $tag);
            $builder->whereIn('tag.TagSlug', $tagArray);
        }
        if (!empty($minPriceQuery))
            $builder->where('product.ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('product.ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $builder->where('category.CategorySlug =', $categorySlug);
        $builder->orderBy('product.' . $order);
        $sql = $builder->getCompiledSelect() . ' LIMIT ' . $from . ', ' . $to;

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProductEntity(
                $value['ProductId'] ?? null,
                $value['ProductName'] ?? null,
                null,
                null,
                $value['ProductStockStatus'] ?? null,
                null,
                null,
                $value['ProductSellingPrice'],
                $value['ProductActualSellingPrice'],
                $value['ProductUnique'] ?? null,
                null,

                null,
                $this->stringCurrency($value['ProductSellingPrice']),
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

    public function tagListFilter(string $tagSlug, string $category, string $minPriceQuery, $maxPriceQuery, string $sort, int $from, int $to)
    {
        $order = null;
        if ($sort == 'alphabet')
            $order = 'ProductName ASC';
        elseif ($sort == 'alphabet-desc')
            $order = 'ProductName DESC';
        elseif ($sort == 'date')
            $order = 'ProductPublishedDate ASC';
        elseif ($sort == 'date-desc')
            $order = 'ProductPublishedDate DESC';
        elseif ($sort == 'price')
            $order = 'ProductActualSellingPrice ASC';
        elseif ($sort == 'price-desc')
            $order = 'ProductActualSellingPrice DESC';
        else
            $order = 'ProductId DESC';

        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->select('product.ProductId, product.ProductName, product.ProductStockStatus, product.ProductSellingPrice, product.ProductActualSellingPrice, product.ProductUnique');

        $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
        $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');

        if (!empty($category)) {
            $builder->join('product_category', 'product_category.ProductId = product.ProductId');
            $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');
        }
        if (!empty($category)) {
            $categoryArray = explode(',', $category);
            $builder->whereIn('category.CategorySlug', $categoryArray);
        }

        if (!empty($minPriceQuery))
            $builder->where('product.ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('product.ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $builder->where('tag.TagSlug =', $tagSlug);
        $builder->orderBy('product.' . $order);
        $sql = $builder->getCompiledSelect() . ' LIMIT ' . $from . ', ' . $to;

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new ProductEntity(
                $value['ProductId'] ?? null,
                $value['ProductName'] ?? null,
                null,
                null,
                $value['ProductStockStatus'] ?? null,
                null,
                null,
                $value['ProductSellingPrice'],
                $value['ProductActualSellingPrice'],
                $value['ProductUnique'] ?? null,
                null,

                null,
                $this->stringCurrency($value['ProductSellingPrice']),
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

    public function retrieveCart(int $userId)
    {
        $cartModel = new CartModel();
        $query = $cartModel->query($cartModel->sqlRetrieve, [
            'userId' => $userId
        ]);
        $arr = $query->getRowArray();

        if (is_null($arr)) {
            return null;
        } else {
            return $this->cart($arr);
        }

    }

    public function listOrder(int $userId)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlList, [
            'userId' => $userId
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = $this->order($value);

            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieveOrder(int $userId, string $number)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlRetrieve, [
            'number' => $number,
            'userId' => $userId
        ]);
        $arr = $query->getRowArray();

        if (is_null($arr)) {
            return null;
        } else {
            return $this->order($arr);
        }

    }

    public function retrieve(int $num)
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlUnique, [
            'productUnique' => $num,
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

                (is_null($arr['DiscountId']) ? null : $this->stringDiscount($arr['DiscountType'], $arr['DiscountName'], $arr['DiscountValue']))
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
                $arr['CategoryName'] ?? null,
                $arr['CategorySlug'] ?? null
            );

            return $entity;
        }
    }

    public function productTags(int $num)
    {
        $productTagsModel = new ProductTagsModel();
        $query = $productTagsModel->query($productTagsModel->sqlTags, [
            'productId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new ProductTagsEntity(
                $row['Id'],
                $row['ProductId'] ?? null,
                $row['TagId'] ?? null,
                $row['TagName'] ?? null,
                $row['TagSlug'] ?? null
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

    public function cart($value)
    {
        return new CartEntity(
            $value['CartId'] ?? null,
            $value['UserId'] ?? null,
            $value['CartShippingType'] ?? null,
            $value['CartPaymentMethod'] ?? null,

            $this->cartItems($value['CartId'])
        );
    }

    public function cartItems(int $num)
    {
        $cartItemsModel = new CartItemsModel();
        $query = $cartItemsModel->query($cartItemsModel->sqlItems, [
            'cartId' => $num,
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $total = $row['ProductActualSellingPrice'] * $row['CartItemsQuantity'];
            $entity = new CartItemsEntity(
                $row['Id'],
                $row['CartId'] ?? null,
                $row['ProductId'] ?? null,
                $row['CartItemsQuantity'] ?? null,
                $row['ProductUnique'] ?? null,
                $row['ProductName'] ?? null,
                $row['ProductActualSellingPrice'],
                $total,

                $this->stringCurrency($row['ProductActualSellingPrice']),
                $this->stringCurrency($total),

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function cartItem(int $num)
    {
        $cartItemsModel = new CartItemsModel();
        $query = $cartItemsModel->query($cartItemsModel->sqlItem, [
            'id' => $num,
        ]);

        $row = $query->getRowArray();

        if (is_null($row)) {
            return null;
        } else {
            return new CartItemsEntity(
                $row['Id'],
                $row['CartId'] ?? null,
                $row['ProductId'] ?? null,
                $row['CartItemsQuantity'] ?? null,
                null,
                null,
                null,
                null,

                null,
                null,

                null,
                null,
                null,
            );
        }


    }

    public function order($value)
    {
        return new OrderEntity(
            $value['OrderId'] ?? null,
            $value['UserId'] ?? null,
            $value['OrderNumber'] ?? null,
            $value['OrderStatus'] ?? null,
            $value['OrderSubtotal'] ?? null,
            $value['OrderInstruction'] ?? null,
            $value['OrderTotal'] ?? null,
            DateLibrary::getDate($value['OrderDate'] ?? null),
            $value['OrderPaymentStatus'] ?? null,
            $value['OrderDeliveryStatus'] ?? null,

            DateLibrary::getDate($value['CreatedDateTime'] ?? null),

            $this->stringCurrency($value['OrderSubtotal']),
            $this->stringCurrency($value['OrderTotal']),

            $this->orderBillingAddress($value['OrderId']) ?? null,
            $this->orderShippingAddress($value['OrderId']) ?? null,
            $this->orderItems($value['OrderId']),
            $this->orderShipping($value['OrderId']) ?? null,
        );
    }

    public function orderItems(int $num)
    {
        $orderItemsModel = new OrderItemsModel();
        $query = $orderItemsModel->query($orderItemsModel->sqlRetrieve, [
            'orderId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OrderItemsEntity(
                $row['Id'],
                $row['OrderId'] ?? null,
                null,
                null,
                $row['ProductId'] ?? null,
                $row['ProductName'] ?? null,
                $row['ProductUnique'] ?? null,
                $row['OrderItemsQuantity'] ?? null,
                $row['OrderItemsPrice'] ?? null,
                $row['OrderItemsTotal'] ?? null,

                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,

                $this->stringCurrency($row['OrderItemsPrice']),
                $this->stringCurrency($row['OrderItemsTotal']),
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function orderShipping(int $num)
    {
        $orderShippingModel = new OrderShippingModel();
        $query = $orderShippingModel->query($orderShippingModel->sqlShipping, [
            'orderId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new OrderShippingEntity(
                $row['OrderId'],
                $row['OrderShippingType'] ?? null,
                $row['OrderShippingPrice'],

                $this->stringCurrency($row['OrderShippingPrice']),
            );

            return $entity;
        }

    }

    public function orderPayments(int $num)
    {
        $orderPaymentsModel = new OrderPaymentsModel();
        $query = $orderPaymentsModel->query($orderPaymentsModel->sqlPayments, [
            'orderId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OrderPaymentsEntity(
                $row['Id'],
                $row['OrderId'] ?? null,
                $row['OrderPaymentsName'] ?? null,
                null,
                $row['OrderPaymentsAmount'] ?? null,
                $row['OrderPaymentsStatus'] ?? null,
                $row['OrderPaymentsMethod'] ?? null,

                $this->stringCurrency($row['OrderPaymentsAmount']) ?? null,

                DateLibrary::getFormat($row['CreatedDateTime'] ?? null),
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function orderBillingAddress(int $num)
    {
        $orderBillingAddressModel = new OrderBillingAddressModel();
        $query = $orderBillingAddressModel->query($orderBillingAddressModel->sqlAddress, [
            'orderId' => $num
        ]);

        $row = $query->getRowArray();

        if (is_null($row))
            return null;
        else
            return new OrderBillingAddressEntity(
                $row['Id'] ?? null,
                $row['OrderBillingAddressName'] ?? null,
                $row['OrderBillingAddressEmail'] ?? null,
                $row['OrderBillingAddressNumber'] ?? null,
                $row['OrderBillingAddressAddressOne'] ?? null,
                $row['OrderBillingAddressAddressTwo'] ?? null,
                $row['OrderBillingAddressCity'] ?? null,
                $row['OrderBillingAddressPostalCode'] ?? null,
                $row['OrderBillingAddressStateName'] ?? null,
                $row['OrderBillingAddressStateCode'] ?? null,
                $row['OrderBillingAddressCountryName'] ?? null,
                $row['OrderBillingAddressCountryCode'] ?? null,

            );


    }

    public function orderShippingAddress(int $num)
    {
        $orderShippingAddressModel = new OrderShippingAddressModel();
        $query = $orderShippingAddressModel->query($orderShippingAddressModel->sqlAddress, [
            'orderId' => $num
        ]);

        $row = $query->getRowArray();

        if (is_null($row))
            return null;
        else
            return new OrderShippingAddressEntity(
                $row['Id'] ?? null,
                $row['OrderShippingAddressName'] ?? null,
                $row['OrderShippingAddressEmail'] ?? null,
                $row['OrderShippingAddressNumber'] ?? null,
                $row['OrderShippingAddressAddressOne'] ?? null,
                $row['OrderShippingAddressAddressTwo'] ?? null,
                $row['OrderShippingAddressCity'] ?? null,
                $row['OrderShippingAddressPostalCode'] ?? null,
                $row['OrderShippingAddressStateName'] ?? null,
                $row['OrderShippingAddressStateCode'] ?? null,
                $row['OrderShippingAddressCountryName'] ?? null,
                $row['OrderShippingAddressCountryCode'] ?? null,

            );


    }

    public function related(array $productTagTagFks)
    {
        $relatedProducts = array();
        foreach ($productTagTagFks as $productTagTagFk) {
            $productModel = new ProductModel();
            $query = $productModel->query($productModel->sqlRelated, [
                'productTagTagFk' => $productTagTagFk
            ]);
            $list = $query->getResultArray();

            $output = array();
            foreach ($list as $key => $value) {
                $entity = new ProductEntity(
                    $value['ProductId'] ?? null,
                    $value['ProductName'] ?? null,
                    null,
                    null,
                    $value['ProductStockStatus'] ?? null,
                    null,
                    null,
                    $value['ProductSellingPrice'],
                    $value['ProductActualSellingPrice'],
                    $value['ProductUnique'] ?? null,
                    null,

                    null,
                    $this->stringCurrency($value['ProductSellingPrice']),
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

            // Merge into single array of objects
            $relatedProducts = array_merge($relatedProducts, $output);
        }

        // Remove duplicates
        $relatedProducts = array_intersect_key($relatedProducts, array_unique(array_column($relatedProducts, 'id')));

        return $relatedProducts;
    }

    public function saveCart($userId, $data, $dataItems)
    {
        try {
            $cartModel = new CartModel();

            $cartModel->transException(true)->transStart();

            // Get cartId
            $cartId = $this->getCartId($userId);
            if (is_null($cartId)) {
                // Insert into cart
                $data['CartShippingType'] = ShippingType::LOCAL_PICKUP->name;
                $data['CartPaymentMethod'] = PaymentMethod::CASH->name;
                $cartId = $cartModel->insert($data);

                // Insert into cart_items
                foreach ($dataItems as $key => $dataItem) {
                    $cartItemsModel = new cartItemsModel();
                    $dataItem['CartItemsCartFk'] = $cartId;
                    $cartItemsModel->insert($dataItem);
                }

            } else {
                // Update into cart_items
                foreach ($dataItems as $key => $dataItem) {
                    $dataItem['CartItemsCartFk'] = $cartId;
                    $cartItemId = $this->getCartItemId($cartId, $dataItem['CartItemsProductFk']);

                    $cartItemsModel = new cartItemsModel();
                    if (is_null($cartItemId)) {
                        $cartItemsModel->insert($dataItem);
                    } else {
                        $cartItem = $this->cartItem($cartItemId);
                        $dataItem['CartItemsQuantity'] += $cartItem->quantity;
                        $cartItemsModel->update($cartItemId, $dataItem);
                    }
                }
            }


            $cartModel->transComplete();

            if ($cartModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function updateCart($userId, $data, $dataItems)
    {
        try {
            $cartModel = new CartModel();

            $cartModel->transException(true)->transStart();

            // Get cartId
            $cartId = $this->getCartId($userId);

            // Update into cart
            $cartModel->update($cartId, $data);

            // Update into cart_items
            $cartItemsModel = new cartItemsModel();
            foreach ($dataItems as $dataItem) {
                $dataItem['CartItemsCartFk'] = $cartId;

                $cartItemId = $dataItem['CartItemsId'];
                $cartItemsModel->update($cartItemId, $dataItem);
            }

            $cartModel->transComplete();

            if ($cartModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function saveOrder($data, $dataItems, $dataShipping, $dataBillingAddress, $dataShippigAddress, $dataPayment)
    {
        try {
            $orderModel = new OrderModel();
            $utc = DateLibrary::getZoneDateTime();

            $orderModel->transException(true)->transStart();

            // Insert into order
            $data['CreatedDateTime'] = $utc;
            $data['OrderDate'] = DateLibrary::getMysqlDate($utc);
            $orderId = $orderModel->insert($data);

            // Insert into order_items
            $orderItemsModel = new OrderItemsModel();
            foreach ($dataItems as $key => $dataItem) {
                $dataItem['OrderItemsOrderFk'] = $orderId;
                $orderItemsModel->insert($dataItem);
            }

            // Insert into order_shipping
            $orderShippingModel = new OrderShippingModel();
            $dataShipping['OrderId'] = $orderId;
            $orderShippingModel->insert($dataShipping);

            if (!empty($dataBillingAddress)) {
                // Insert into order_billing_address
                $orderBillingAddressModel = new OrderBillingAddressModel();
                $dataBillingAddress['OrderId'] = $orderId;
                $orderBillingAddressModel->insert($dataBillingAddress);
            }

            if (!empty($dataShippigAddress)) {
                // Insert into order_shipping_address
                $orderShippingAddressModel = new OrderShippingAddressModel();
                $dataShippigAddress['OrderId'] = $orderId;
                $orderShippingAddressModel->insert($dataShippigAddress);
            }

            if (!empty($dataPayment)) {
                // Insert into order_payments
                $orderPaymentsModel = new OrderPaymentsModel();
                $dataPayment['OrderPaymentsOrderFk'] = $orderId;
                $dataPayment['CreatedDateTime'] = $utc;
                $orderPaymentsModel->insert($dataPayment);
            }

            // Empty cart
            $this->emptyCart($data['OrderUserFk']);

            // Reduce productQuantity
            foreach ($dataItems as $key => $dataItem) {
                $quantity = $dataItem['OrderItemsQuantity'];
                $productId = $dataItem['OrderItemsProductFk'];

                $productModel = new ProductModel();
                $productQuantiy = $this->getProductQuantity($productModel, $productId);
                $newQuantity = $productQuantiy - $quantity;

                // Update into product
                $dataProduct['ProductQuantity'] = $newQuantity;
                $dataProduct['ProductStatus'] = ($newQuantity <= 0) ? ProductStatus::OUT_OF_STOCK->name : ProductStatus::IN_STOCK->name;
                $productModel->update($productId, $dataProduct);
            }

            $orderModel->transComplete();

            if ($orderModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function removeCart(int $num)
    {
        try {
            $cartItemsModel = new CartItemsModel();

            $cartItemsModel->transException(true)->transStart();

            $query = $cartItemsModel->query($cartItemsModel->sqlDelete, [
                'productId' => $num,
            ]);

            $affected_rows = $cartItemsModel->affectedRows();

            $cartItemsModel->transComplete();
            if ($affected_rows >= 1 && $cartItemsModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }

    public function emptyCart(int $userId)
    {
        try {
            $cartItemsModel = new CartItemsModel();

            $cartItemsModel->transException(true)->transStart();

            // Get cartId
            $cartId = $this->getCartId($userId);

            $query = $cartItemsModel->query($cartItemsModel->sqlDeleteAll, [
                'cartId' => $cartId,
            ]);

            $affected_rows = $cartItemsModel->affectedRows();

            $cartItemsModel->transComplete();
            if ($affected_rows >= 1 && $cartItemsModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }


    // Other 
    private function stringDiscount(string $type, string $name, int $value)
    {
        $stringDiscount = null;
        if ($type == DiscountType::PERCENTAGE->name) {
            $stringDiscount = $name . ' ' . $value . '%';
        } elseif ($type == DiscountType::AMOUNT->name) {
            $stringDiscount = $name . ' #' . $value;
        }
        return $stringDiscount;
    }

    public function getProductId($productUnique)
    {
        $productModel = new ProductModel();
        $query = $productModel->query($productModel->sqlId, [
            'productUnique' => $productUnique
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function getProductQuantity(ProductModel $productModel, $productId)
    {
        $query = $productModel->query($productModel->sqlQuantity, [
            'productId' => $productId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Quantity'};
    }

    public function getCartId($userId)
    {
        $cartModel = new CartModel();
        $query = $cartModel->query($cartModel->sqlId, [
            'userId' => $userId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function getCartItemId($cartId, $productId)
    {
        $cartItemsModel = new CartItemsModel();
        $query = $cartItemsModel->query($cartItemsModel->sqlItemId, [
            'cartId' => $cartId,
            'productId' => $productId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function generateOrderNumber()
    {
        $random = mt_rand(1000000000, 9999999999);
        return $random;
    }

    public function count(string $tag, string $category, string $minPriceQuery, $maxPriceQuery)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->selectCount('product.ProductId', 'COUNT');
        if (!empty($category)) {
            $builder->join('product_category', 'product_category.ProductId = product.ProductId');
            $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');
        }
        if (!empty($tag)) {
            $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
            $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');
        }
        if (!empty($category)) {
            $categoryArray = explode(',', $category);
            $builder->orWhereIn('category.CategorySlug', $categoryArray);
        }
        if (!empty($tag)) {
            $tagArray = explode(',', $tag);
            $builder->whereIn('tag.TagSlug', $tagArray);
        }
        if (!empty($minPriceQuery))
            $builder->where('ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $sql = $builder->getCompiledSelect();

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function categoryCount(string $categorySlug, string $tag, string $minPriceQuery, $maxPriceQuery)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->selectCount('product.ProductId', 'COUNT');

        $builder->join('product_category', 'product_category.ProductId = product.ProductId');
        $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');

        if (!empty($tag)) {
            $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
            $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');
        }
        if (!empty($tag)) {
            $tagArray = explode(',', $tag);
            $builder->whereIn('tag.TagSlug', $tagArray);
        }
        if (!empty($minPriceQuery))
            $builder->where('ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $builder->where('category.CategorySlug =', $categorySlug);
        $sql = $builder->getCompiledSelect();

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function tagCount(string $tagSlug, string $category, string $minPriceQuery, $maxPriceQuery)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->selectCount('product.ProductId', 'COUNT');

        $builder->join('product_tags', 'product_tags.ProductTagProductFk = product.ProductId');
        $builder->join('tag', 'tag.TagId = product_tags.ProductTagTagFk');

        if (!empty($category)) {
            $builder->join('product_category', 'product_category.ProductId = product.ProductId');
            $builder->join('category', 'category.CategoryId = product_category.ProductCategoryCategoryFk');
        }

        if (!empty($category)) {
            $categoryArray = explode(',', $category);
            $builder->orWhereIn('category.CategorySlug', $categoryArray);
        }


        if (!empty($minPriceQuery))
            $builder->where('ProductActualSellingPrice >=', $minPriceQuery);
        if (!empty($maxPriceQuery))
            $builder->where('ProductActualSellingPrice <=', $maxPriceQuery);
        $builder->where('product.ProductVisibilityStatus =', "PUBLISHED");
        $builder->where('tag.TagSlug =', $tagSlug);
        $sql = $builder->getCompiledSelect();

        $productModel = new ProductModel();
        $query = $productModel->query($sql);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function pagination(string $tag, string $category, string $minPriceQuery, $maxPriceQuery, string $sortQuery, int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->count($tag, $category, $minPriceQuery, $maxPriceQuery);
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->listFilter($tag, $category, $minPriceQuery, $maxPriceQuery, $sortQuery, $next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }

    public function categoryPagination(string $categorySlug, string $tag, string $minPriceQuery, $maxPriceQuery, string $sortQuery, int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->categoryCount($categorySlug, $tag, $minPriceQuery, $maxPriceQuery);
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->categoryListFilter($categorySlug, $tag, $minPriceQuery, $maxPriceQuery, $sortQuery, $next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }

    public function tagPagination(string $tagSlug, string $category, string $minPriceQuery, $maxPriceQuery, string $sortQuery, int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->tagCount($tagSlug, $category, $minPriceQuery, $maxPriceQuery);
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->tagListFilter($tagSlug, $category, $minPriceQuery, $maxPriceQuery, $sortQuery, $next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }


}