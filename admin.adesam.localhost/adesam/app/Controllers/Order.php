<?php


namespace App\Controllers;



use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\OrderImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\TransactionStatus;
use App\Enums\SettingType;




class Order extends BaseController
{

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for tag is 15'
            ]
        ]
    ];

    protected $orderImplModel;

    public function __construct()
    {
        $this->orderImplModel = new OrderImplModel();
    }

    public function index()
    {
        try {
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->orderImplModel->setCurrency(currency: $shop->currency->value);

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->orderImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Orders';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['data'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'orders?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('order/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Order';

            $this->orderImplModel = new OrderImplModel();
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->orderImplModel->setCurrency(currency: $shop->currency->value);

            $order = $this->orderImplModel->retrieve($num);
            if (is_null($order))
                return view('null_error', $data);

            $items = $order->items;
            $payments = $order->payments;
            $shipping = $order->shipping;
            $billingAddress = $order->billingAddress;
            $shippingAddress = $order->shippingAddress;

            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['data'] = $order;
            $data['dataItems'] = $items;
            $data['dataPayments'] = $payments;
            $data['dataShipping'] = $shipping;
            $data['dataBillingAdress'] = $billingAddress;
            $data['dataShippingAdress'] = $shippingAddress;


            return view('order/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $this->orderImplModel = new OrderImplModel();

            if ($this->orderImplModel->delete($num)) {
                return redirect()->route('orders')->with('success', 'Order deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops order was not deleted!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function createCashPayment(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $fieldValidation = array_merge(
                $this->fieldName
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $this->orderImplModel = new OrderImplModel();

                $name = $this->request->getPost('name');
                $amount = $this->request->getPost('amount');


                // Get orderPrice
                $orderPrice = $this->orderImplModel->orderPrice($num);

                // Get sumOrderPayments
                $sumOrderPayment = $this->orderImplModel->sumOrderPayment($num) ?? 0;

                if (($amount + $sumOrderPayment) > $orderPrice)
                    return redirect()->back()->with('fail', 'Your payment exceed order total');


                // Set paymentStatus
                $orderStatus = '';
                $orderPaymentStatus = '';
                if (($amount + $sumOrderPayment) == $orderPrice) {
                    $orderStatus = OrderStatus::PAID->name;
                    $orderPaymentStatus = PaymentStatus::COMPLETED->name;
                } else if (($amount + $sumOrderPayment) < $orderPrice) {
                    $orderStatus = OrderStatus::PARTIAL_PAID->name;
                    $orderPaymentStatus = PaymentStatus::PARTIAL->name;
                }

                // Update into order
                $data = [
                    'OrderStatus' => $orderStatus,
                    'OrderPaymentStatus' => $orderPaymentStatus
                ];

                // Insert into orderPayments
                $dataPayments = [
                    'OrderPaymentsOrderFk' => $num,
                    'OrderPaymentsName' => $name,
                    'OrderPaymentsAmount' => $amount,
                    'OrderPaymentsStatus' => TransactionStatus::COMPLETED->name,
                    'OrderPaymentsMethod' => PaymentMethod::CASH->name,
                ];

                if ($this->orderImplModel->storePayment($num, $data, $dataPayments)) {
                    return redirect()->back()->with('success', 'Payment added successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when adding payment!');
                }

            } else
                return redirect()->back()->with('fail', $this->validator->getError('name'));

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}