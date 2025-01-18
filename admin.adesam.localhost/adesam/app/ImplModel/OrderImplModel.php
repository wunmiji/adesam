<?php

namespace App\ImplModel;


use App\Models\Order\OrderModel;
use App\Models\Order\OrderItemsModel;
use App\Models\Order\OrderPaymentsModel;
use App\Models\Order\OrderShippingModel;
use App\Models\Order\OrderBillingAddressModel;
use App\Models\Order\OrderShippingAddressModel;
use App\Libraries\DateLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\Order\OrderEntity;
use App\Entities\Order\OrderItemsEntity;
use App\Entities\Order\OrderPaymentsEntity;
use App\Entities\Order\OrderShippingEntity;
use App\Entities\Order\OrderBillingAddressEntity;
use App\Entities\Order\OrderShippingAddressEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class OrderImplModel extends BaseImplModel
{


    public function userOrders(int $userId)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlUserOrders, [
            'userId' => $userId
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OrderEntity(
                $value['OrderId'] ?? null,
                SecurityLibrary::encryptUrlId($value['OrderId']),
                null,
                null,
                $value['OrderNumber'] ?? null,
                null,
                null,
                $value['OrderTotal'] ?? null,
                DateLibrary::getDate($value['OrderDate'] ?? null),
                $value['UserName'] ?? null,
                null,
                null,
                $value['CountOrderItems'] ?? null,

                $value['OrderStatus'] ?? null,
                null,
                null,

                null,
                null,

                null,
                $this->stringCurrency($value['OrderTotal']),

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

    public function list(int $from, int $to)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OrderEntity(
                $value['OrderId'] ?? null,
                SecurityLibrary::encryptUrlId($value['OrderId']),
                $value['UserId'] ?? null,
                SecurityLibrary::encryptUrlId($value['UserId']),
                $value['OrderNumber'] ?? null,
                null,
                null,
                $value['OrderTotal'] ?? null,
                DateLibrary::getDate($value['OrderDate'] ?? null),
                $value['UserName'] ?? null,
                null,
                null,
                null,

                $value['OrderStatus'] ?? null,
                null,
                null,

                null,
                null,

                null,
                $this->stringCurrency($value['OrderTotal']),

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

    public function orderPerMonth(int $year)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->orderPerMonth, [
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

    public function recent()
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlRecent);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new OrderEntity(
                $value['OrderId'] ?? null,
                SecurityLibrary::encryptUrlId($value['OrderId']),
                $value['UserId'] ?? null,
                SecurityLibrary::encryptUrlId($value['UserId']),
                $value['OrderNumber'] ?? null,
                null,
                null,
                $value['OrderTotal'] ?? null,
                DateLibrary::getDate($value['OrderDate'] ?? null),
                $value['UserName'] ?? null,
                null,
                null,
                $value['CountOrderItems'] ?? null,

                $value['OrderStatus'] ?? null,
                null,
                null,

                null,
                null,

                null,
                $this->stringCurrency($value['OrderTotal']),

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

    public function recentPayments()
    {
        $orderPaymentsModel = new OrderPaymentsModel();
        $query = $orderPaymentsModel->query($orderPaymentsModel->sqlRecentPayments);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OrderPaymentsEntity(
                $row['Id'],
                null,
                $row['OrderId'] ?? null,
                SecurityLibrary::encryptUrlId($row['OrderId']),
                $row['OrderPaymentsName'] ?? null,
                $row['OrderNumber'] ?? null,
                $row['OrderPaymentsAmount'] ?? null,
                $row['OrderPaymentsStatus'] ?? null,
                $row['OrderPaymentsMethod'] ?? null,

                $this->stringCurrency($row['OrderPaymentsAmount']),

                DateLibrary::getFormat($row['CreatedDateTime'] ?? null),
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function retrieve(int $num)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlRetrieve, [
            'orderId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->order($row);
        }
    }

    public function order($value)
    {
        return new OrderEntity(
            $value['OrderId'] ?? null,
            SecurityLibrary::encryptUrlId($value['OrderId']),
            $value['UserId'] ?? null,
            SecurityLibrary::encryptUrlId($value['UserId']),
            $value['OrderNumber'] ?? null,
            $value['OrderSubtotal'] ?? null,
            $value['OrderInstruction'] ?? null,
            $value['OrderTotal'] ?? null,
            DateLibrary::getDate($value['OrderDate'] ?? null),
            $value['UserName'] ?? null,
            $value['UserEmail'] ?? null,
            null,
            null,

            $value['OrderStatus'] ?? null,
            $value['OrderPaymentStatus'] ?? null,
            $value['OrderDeliveryStatus'] ?? null,

            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->stringCurrency($value['OrderSubtotal']),
            $this->stringCurrency($value['OrderTotal']),

            $this->orderItems($value['OrderId']),
            $this->orderPayments($value['OrderId']),
            $this->orderShipping($value['OrderId']),
            $this->orderBillingAddress($value['OrderId']),
            $this->orderShippingAddress($value['OrderId']),
        );

    }

    public function orderItems(int $num)
    {
        $orderItemsModel = new OrderItemsModel();
        $query = $orderItemsModel->query($orderItemsModel->sqlList, [
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
                null,
                $row['ProductId'] ?? null,
                SecurityLibrary::encryptUrlId($row['ProductId']),
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
                SecurityLibrary::encryptUrlId($row['Id']),
                $row['OrderId'] ?? null,
                null,
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
                $row['Id'],
                $row['OrderShippingType'] ?? null,
                $row['OrderShippingPrice'],

                $this->stringCurrency($row['OrderShippingPrice']),
            );

            return $entity;
        }

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

    public function orderItemsProduct(int $num)
    {
        $orderItemsModel = new OrderItemsModel();
        $query = $orderItemsModel->query($orderItemsModel->sqlOrder, [
            'productId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new OrderItemsEntity(
                $row['Id'],
                $row['OrderId'] ?? null,
                SecurityLibrary::encryptUrlId($row['OrderId']),
                $row['OrderNumber'] ?? null,
                DateLibrary::getDate($row['OrderDate'] ?? null),
                $row['ProductId'] ?? null,
                null,
                null,
                null,
                $row['OrderItemsQuantity'] ?? null,
                $row['OrderItemsPrice'] ?? null,
                $row['OrderItemsTotal'] ?? null,

                null,
                null,
                null,

                $this->stringCurrency($row['OrderItemsPrice']),
                $this->stringCurrency($row['OrderItemsTotal']),
            );

            $arr[$row['Id']] = $entity;
        }


        return $arr;
    }

    public function storePayment($num, $data, $dataPayments)
    {
        try {
            $orderPaymentsModel = new OrderPaymentsModel();

            $orderPaymentsModel->transException(true)->transStart();

            // Insert into order_payments
            $dataPayments['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $productId = $orderPaymentsModel->insert($dataPayments);

            // Update int order
            $orderModel = new OrderModel();
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $orderModel->update($num, $data);

            $orderPaymentsModel->transComplete();

            if ($orderPaymentsModel->transStatus() === false)
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
            $orderModel = new OrderModel();
            $orderModel->transException(true)->transStart();

            $query = $orderModel->query($orderModel->sqlDelete, [
                'orderId' => $num,
            ]);

            $affected_rows = $orderModel->affectedRows();

            $orderModel->transComplete();
            if ($affected_rows >= 1 && $orderModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }




    // Other 
    public function orderPrice(int $orderId)
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlPrice, [
            'orderId' => $orderId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'OrderTotal'};
    }

    public function sumOrderPayment(int $orderId)
    {
        $orderPaymentsModel = new OrderPaymentsModel();
        $query = $orderPaymentsModel->query($orderPaymentsModel->sqlSumAmount, [
            'orderId' => $orderId
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'SUM(OrderPaymentsAmount)'};
    }

    public function count()
    {
        $orderModel = new OrderModel();
        $query = $orderModel->query($orderModel->sqlCount);
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