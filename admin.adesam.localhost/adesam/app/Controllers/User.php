<?php


namespace App\Controllers;



use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\UserImplModel;
use App\ImplModel\OrderImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Enums\SettingType;



class User extends BaseController
{

    protected $userImplModel;
   

    public function __construct()
    {
        $this->userImplModel = new UserImplModel();
    }

    public function index()
    {
        try {
            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->userImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Users';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'users?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('user/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View User';

            $orderImplModel = new OrderImplModel();
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $orderImplModel->setCurrency(currency: $shop->currency->value);

            $user = $this->userImplModel->retrieve($num);
            if (is_null($user))
                return view('null_error', $data);

            $image = $user->image;
            $billingAddresses = $user->billingAddresses;
            $shippingAddresses = $user->shippingAddresses;

            // Get all user orders
            $orders = $orderImplModel->userOrders($num);

            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['data'] = $user;
            $data['dataImage'] = $image;
            $data['dataBillingAdresses'] = $billingAddresses;
            $data['dataShippingAdresses'] = $shippingAddresses;
            $data['orders'] = $orders;

            return view('user/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


}