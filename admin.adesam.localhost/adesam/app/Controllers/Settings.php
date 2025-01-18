<?php


namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\SettingImplModel;
use App\Libraries\MoneyLibrary;
use App\Libraries\TimezoneLibrary;
use App\Enums\SettingType;

class Settings extends BaseController
{

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Your email is required',
                'valid_email' => 'Email is not valid'
            ]
        ]
    ];

    protected $fieldMobile = [
        'mobile' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your mobile is required',
                'max_length' => 'Max length for mobile is 15'
            ]
        ]
    ];

    protected $fieldFacebook = [
        'facebook' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldInstagram = [
        'instagram' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldLinkedIn = [
        'linkedIn' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldTwitter = [
        'twitter' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldYoutube = [
        'youtube' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldShippingPrice = [
        'shipping-price' => [
            'rules' => 'required|regex_match[/^\d{1,6}(?:\.\d{0,2})?$/]',
            'errors' => [
                'required' => 'Shipping Price is required',
                'regex_match' => 'Shipping Price is not valid',
            ]
        ]
    ];

    protected $fieldCurrency = [
        'currency' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Currency is required',
            ]
        ]
    ];

    protected $fieldTimezone = [
        'timezone' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Timezone is required',
            ]
        ]
    ];

    protected $fieldDay = [
        'day' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Day is required',
            ]
        ]
    ];


    public function __construct()
    {
    }


    public function index($validator = null)
    {
        try {
            $settingImplModel = new SettingImplModel();


            $data['validation'] = $validator;
            // tab
            $tabQuery = $this->request->getVar('tab');
            
            if (is_null($tabQuery) || $tabQuery == 'general') {
                $general = $settingImplModel->list(SettingType::GENERAL->name);
                $timezones = TimezoneLibrary::$timezones;

                $data['title'] = 'General';
                $data['data'] = $general;
                $data['timezones'] = $timezones;

                return view('settings/general', $data);
            } elseif ($tabQuery == 'shop') {
                $shop = $settingImplModel->list(SettingType::SHOP->name);
                $currencies = MoneyLibrary::$currencies;

                $data['title'] = 'Shop';
                $data['data'] = $shop;
                $data['currencies'] = $currencies;

                return view('settings/shop', $data);
            } elseif ($tabQuery == 'contact') {
                $contact = $settingImplModel->list(SettingType::CONTACT->name);

                $data['title'] = 'Contact';
                $data['data'] = $contact;

                return view('settings/contact', $data);

            } elseif ($tabQuery == 'calendar') {
                $calendar = $settingImplModel->list(SettingType::CALENDAR->name);

                $days = [
                    0 => 'Sunday',
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                ];

                $data['title'] = 'Calendar';
                $data['data'] = $calendar;
                $data['days'] = $days;

                return view('settings/calendar', $data);
            } else {
                throw PageNotFoundException::forPageNotFound();
            }



        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function update()
    {

        try {
            $tabQuery = $this->request->getVar('tab');

            if ($tabQuery === 'general') {
                $fieldValidation = array_merge(
                    $this->fieldTimezone,
                );
                $validated = $this->validate($fieldValidation);


                if ($validated) {
                    $settingImplModel = new SettingImplModel();

                    $timezone = $this->request->getPost('timezone');


                    // Update into setting
                    $datas = [
                        [
                            'SettingCategory' => SettingType::GENERAL->name,
                            'SettingKey' => 'timezone',
                            'SettingValue' => $timezone,
                        ],
                    ];

                    if ($settingImplModel->update($datas)) {
                        return redirect()->back()->with('success', 'Settings updated successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when updating settings!');
                    }

                } else
                    return $this->index($this->validator);
            } elseif ($tabQuery === 'contact') {
                $fieldValidation = array_merge(
                    $this->fieldFacebook,
                    $this->fieldInstagram,
                    $this->fieldLinkedIn,
                    $this->fieldTwitter,
                    $this->fieldYoutube,
                );
                $validated = $this->validate($fieldValidation);


                if ($validated) {
                    $settingImplModel = new SettingImplModel();

                    $email = $this->request->getPost('email');
                    $mobile = $this->request->getPost('mobile');
                    $facebook = $this->request->getPost('facebook');
                    $instagram = $this->request->getPost('instagram');
                    $linkedIn = $this->request->getPost('linkedIn');
                    $twitter = $this->request->getPost('twitter');
                    $youtube = $this->request->getPost('youtube');


                    // Insert/Update into setting
                    $datas = [
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'email',
                            'SettingValue' => (empty($email)) ? null : $email,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'mobile',
                            'SettingValue' => (empty($mobile)) ? null : $mobile,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'facebook',
                            'SettingValue' => (empty($facebook)) ? null : $facebook,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'instagram',
                            'SettingValue' => (empty($instagram)) ? null : $instagram,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'linkedIn',
                            'SettingValue' => (empty($linkedIn)) ? null : $linkedIn,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'twitter',
                            'SettingValue' => (empty($twitter)) ? null : $twitter,
                        ],
                        [
                            'SettingCategory' => SettingType::CONTACT->name,
                            'SettingKey' => 'youtube',
                            'SettingValue' => (empty($youtube)) ? null : $youtube,
                        ],
                    ];

                    if ($settingImplModel->update($datas)) {
                        return redirect()->back()->with('success', 'Settings updated successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when updating settings!');
                    }

                } else
                    return $this->index($this->validator);
            } elseif ($tabQuery === 'shop') {
                $fieldValidation = array_merge(
                    $this->fieldShippingPrice,
                    $this->fieldCurrency,
                );
                $validated = $this->validate($fieldValidation);
    
    
                if ($validated) {
                    $settingImplModel = new SettingImplModel();
    
                    $shippingPrice = $this->request->getPost('shipping-price');
                    $currency = $this->request->getPost('currency');
    
    
                    // Insert/Update into setting
                    $datas = [
                        [
                            'SettingCategory' => SettingType::SHOP->name,
                            'SettingKey' => 'shipping-price',
                            'SettingValue' => $shippingPrice,
                        ],
                        [
                            'SettingCategory' => SettingType::SHOP->name,
                            'SettingKey' => 'currency',
                            'SettingValue' => $currency,
                        ],
                    ];
    
                    if ($settingImplModel->update($datas)) {
                        return redirect()->back()->with('success', 'Settings updated successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when updating settings!');
                    }
    
                } else
                    return $this->index($this->validator);
            } elseif ($tabQuery === 'calendar') {
                $fieldValidation = array_merge(
                    $this->fieldDay
                );
                $validated = $this->validate($fieldValidation);
    
    
                if ($validated) {
                    $settingImplModel = new SettingImplModel();
    
                    $day = $this->request->getPost('day');
    
                    // Update into setting
                    $datas = [
                        [
                            'SettingCategory' => SettingType::CALENDAR->name,
                            'SettingKey' => 'first-day',
                            'SettingValue' => (empty($day) || null) ? '0' : $day,
                        ],
                    ];
    
                    if ($settingImplModel->update($datas)) {
                        return redirect()->back()->with('success', 'Settings updated successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when updating settings!');
                    }
    
                } else
                    return $this->index($this->validator);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

}
