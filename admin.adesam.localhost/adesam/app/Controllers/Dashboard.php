<?php


namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\SettingImplModel;
use App\ImplModel\OrderImplModel;
use App\ImplModel\CalendarImplModel;
use App\ImplModel\UserImplModel;
use App\ImplModel\ContactImplModel;
use App\ImplModel\OccasionImplModel;
use App\ImplModel\ProductImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\DateLibrary;
use App\Libraries\FileLibrary;
use App\Enums\SettingType;

class Dashboard extends BaseController
{

    public function __construct()
    {
        
    }

    public function index()
    {
        try {
            $settingImplModel = new SettingImplModel();
            $orderImplModel = new OrderImplModel();
            $calendarImplModel = new CalendarImplModel();
            $userImplModel = new UserImplModel();
            $contactImplModel = new ContactImplModel();
            $occasionImplModel = new OccasionImplModel();
            $productImplModel = new ProductImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $orderImplModel->setCurrency(currency: $shop->currency->value);

            // set createdId
            $contactImplModel->setCreatedId(session()->get('familyId'));


            // Get all total
            $userTotal = $userImplModel->count();
            $contactTotal = $contactImplModel->count();
            $productTotal = $productImplModel->count();
            $occasionTotal = $occasionImplModel->count();
            $orderTotal = $orderImplModel->count();
            $orderTotal = $orderImplModel->count();
            $fileTotal = FileLibrary::formatBytes($fileManagerImplModel->sumAllFileSize());

            // Get insight using ajax 
            if ($this->request->isAJAX()) {
                $occasionPerMonthYear = $this->request->getVar('occasion_per_month_year');
                $productPerMonthYear = $this->request->getVar('product_per_month_year');
                $orderPerMonthYear = $this->request->getVar('order_per_month_year');

                if (!is_null($occasionPerMonthYear))
                    return $occasionImplModel->occasionPerMonth($occasionPerMonthYear);

                if (!is_null($productPerMonthYear))
                    return $productImplModel->productPerMonth($productPerMonthYear);

                if (!is_null($orderPerMonthYear))
                    return $orderImplModel->orderPerMonth($orderPerMonthYear);

            }

            // Recent Ordersc
            $orders = $orderImplModel->recent();

            // Recent Payments
            $payments = $orderImplModel->recentPayments();

            // Recent Calendars
            $currentYear = DateLibrary::getCurrentYear();
            $currentMonth = DateLibrary::getCurrentMonthNumber();
            $currentDay = DateLibrary::getCurrentDayNumber();
            $calendars = $calendarImplModel->recent($currentYear, $currentMonth, $currentDay);

            // Get all session
            //$session = $familyImplModel->session(session()->get('familyId'));

            $data['title'] = 'Dashboard';
            $data['js_library'] = '<script type="module" src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>' .
                '<script type="module" src="/assets/js/library/chart-utils.min.js"></script>' . 
                '<script src="/assets/js/library/moment.min.js"></script>';
            $data['js_custom'] = '<script type="module" src="/assets/js/custom/chart.js"></script>';
            $data['founded'] = $this->information['founded'];
            $data['orders'] = $orders;
            $data['calendars'] = $calendars;
            $data['userTotal'] = $userTotal;
            $data['contactTotal'] = $contactTotal;
            $data['productTotal'] = $productTotal;
            $data['occasionTotal'] = $occasionTotal;
            $data['orderTotal'] = $orderTotal;
            $data['fileTotal'] = $fileTotal;
            $data['payments'] = $payments;

            return view('dashboard/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function logout()
    {
        if (session()->has('familyId')) {
            session()->remove('familyId');
        }
        session()->destroy();
        return redirect()->route('/')->with('fail', 'You are logged out!');
    }


}
