<?php


namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\FamilyImplModel;
use App\ImplModel\SettingImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\CalendarImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\DateLibrary;
use App\Enums\Gender;
use App\Enums\SettingType;
use App\Enums\CalendarType;
use App\Enums\CalendarRecurringType;


class Family extends BaseController
{

    protected $fieldFirstName = [
        'first_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your first name is required',
                'max_length' => 'Max length for first name is 15'
            ]
        ]
    ];

    protected $fieldMiddleName = [
        'middle_name' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for middle name is 15'
            ]
        ]
    ];

    protected $fieldLastName = [
        'last_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your last name is required',
                'max_length' => 'Max length for last name is 15'
            ]
        ],
    ];

    protected $fieldDob = [
        'dob' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'Date of birth is required',
                'valid_date' => 'Date of birth is not valid'
            ]
        ]
    ];

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Email is not valid'
            ]
        ]
    ];

    protected $fieldRole = [
        'role' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Role is required',
                'max_length' => 'Max length for role is 30'
            ]
        ]
    ];

    protected $fieldTelephone = [
        'telephone' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for telephone is 15'
            ]
        ]
    ];

    protected $fieldMobile = [
        'mobile' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for mobile is 15'
            ]
        ]
    ];

    protected $fieldNewPassword = [
        'new_password' => [
            'rules' => 'required|min_length[5]|max_length[20]',
            'errors' => [
                'required' => 'Your new password is required',
                'min_length' => 'Password must be 5 characters long',
                'max_length' => 'Password cannot be longer than 20 characters'
            ]
        ]
    ];

    protected $fieldConfrimNewPassword = [
        'confrim_new_password' => [
            'rules' => 'required|min_length[5]|max_length[20]|matches[new_password]',
            'errors' => [
                'required' => 'Your confirm new password is required',
                'min_length' => 'Password must be 5 characters long',
                'max_length' => 'Password cannot be longer than 20 characters',
                'matches' => 'Your new passwords do not match'
            ]
        ]
    ];

    protected $fieldDescription = [
        'description' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Max length for description is 250'
            ]
        ]
    ];

    protected $fieldFacebook = [
        'facebook' => [
            'rules' => 'permit_empty|valid_url_strict|max_length[250]',
            'errors' => [
                'valid_url_strict' => 'Url is not valid',
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldInstagram = [
        'instagram' => [
            'rules' => 'permit_empty|valid_url_strict|max_length[250]',
            'errors' => [
                'valid_url_strict' => 'Url is not valid',
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldLinkedIn = [
        'linkedIn' => [
            'rules' => 'permit_empty|valid_url_strict|max_length[250]',
            'errors' => [
                'valid_url_strict' => 'Url is not valid',
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldTwitter = [
        'twitter' => [
            'rules' => 'permit_empty|valid_url_strict|max_length[250]',
            'errors' => [
                'valid_url_strict' => 'Url is not valid',
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];

    protected $fieldYoutube = [
        'youtube' => [
            'rules' => 'permit_empty|valid_url_strict|max_length[250]',
            'errors' => [
                'valid_url_strict' => 'Url is not valid',
                'max_length' => 'Max length for url is 250'
            ]
        ]
    ];


    public function __construct()
    {
    }


    public function index()
    {
        try {
            $familyImplModel = new FamilyImplModel();


            $data['title'] = 'Family';
            $data['datas'] = $familyImplModel->list();

            return view('family/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function create($validator = null)
    {
        try {
            $data['title'] = 'New Member';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['validation'] = $validator;
            $data['genderEnum'] = Gender::getAll();

            return view('family/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $familyImplModel = new FamilyImplModel();

            $family = $familyImplModel->retrieve($num);

            // Get calendars
            $calendarImplModel = new CalendarImplModel();
            $calendars = $calendarImplModel->familyCalendar($num);

            $data['title'] = 'Family';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['data'] = $family;
            $data['dataImage'] = $family->image;
            $data['dataSocialMedia'] = $family->socialMedia;
            $data['calendars'] = $calendars;
            $data['calendarEnum'] = CalendarType::getAll();
            $data['calendarRecurringEnum'] = CalendarRecurringType::getAll();


            return view('family/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Family';

            $familyImplModel = new FamilyImplModel();
            $calendarImplModel = new CalendarImplModel();
            $fileManagerImplModel = new FileManagerImplModel();
            $settingImplModel = new SettingImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);


            $family = $familyImplModel->retrieve($num);
            if (is_null($family))
                return view('null_error', $data);

            // Get calendar_family
            $calendarId = $calendarImplModel->getIdBirthdayFamily($num);

            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['validation'] = $validator;
            $data['data'] = $family;
            $data['dataImage'] = $family->image;
            $data['dataSocialMedia'] = $family->socialMedia;
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['genderEnum'] = Gender::getAll();
            $data['genderValue'] = $family->gender;
            $data['calendarCipherId'] = SecurityLibrary::encryptUrlId($calendarId);


            return view('family/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function editPassword(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $familyImplModel = new FamilyImplModel();

            $family = $familyImplModel->retrieve($num);

            $data['title'] = 'Update Family';
            $data['id'] = $num;
            $data['validation'] = $validator;
            $data['cipherId'] = $family->cipherId;

            return view('family/update_password', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function store()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldFirstName,
                $this->fieldMiddleName,
                $this->fieldLastName,
                $this->fieldDob,
                $this->fieldEmail,
                $this->fieldRole,
                $this->fieldTelephone,
                $this->fieldMobile,
                $this->fieldDescription
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $familyImplModel = new FamilyImplModel();
                $securityLibrary = new SecurityLibrary();

                $firstName = $this->request->getPost('first_name');
                $middleName = $this->request->getPost('middle_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $mobile = $this->request->getPost('mobile');
                $gender = $this->request->getPost('gender');
                $dob = $this->request->getPost('dob');
                $telephone = $this->request->getPost('telephone');
                $role = $this->request->getPost('role');
                $description = $this->request->getPost('description');

                // Insert into family
                $data = [
                    'FamilyFirstName' => $firstName,
                    'FamilyMiddleName' => (empty($middleName)) ? null : $middleName,
                    'FamilyLastName' => $lastName,
                    'FamilyEmail' => $email,
                    'FamilyMobile' => (empty($mobile)) ? null : $mobile,
                    'FamilyTelephone' => (empty($telephone)) ? null : $telephone,
                    'FamilyGender' => $gender,
                    'FamilyDob' => $dob,
                    'FamilyRole' => $role,
                    'FamilyDescription' => $description,
                ];

                // Insert into family_secret
                $salt = $securityLibrary->salt16();
                $combinedPassword = '123456' . $salt;
                // Get hashed password
                $hashedPassword = $securityLibrary->encrypt($combinedPassword);
                $dataSecret = [
                    'FamilySecretPassword' => $hashedPassword,
                    'FamilySecretSalt' => $salt
                ];


                // Insert into calendar
                $calendarData = [
                    'CalendarTitle' => $firstName . ' birthday',
                    'CalendarLocked' => true,
                    'CalendarDescription' => $firstName . ' birthday',
                    'CalendarType' => CalendarType::BIRTHDAY->name,
                    'CalendarStartYear' => DateLibrary::getYear($dob),
                    'CalendarStartMonth' => DateLibrary::getMonthNumber($dob),
                    'CalendarStartDay' => DateLibrary::getDayNumber($dob),
                    'CalendarStartTime' => DateLibrary::getMysqlTime($dob),
                    'CalendarEndYear' => null,
                    'CalendarEndMonth' => null,
                    'CalendarEndDay' => null,
                    'CalendarEndTime' => null,
                    'CalendarIsRecurring' => true,
                    'CalendarRecurringType' => CalendarRecurringType::YEARLY->name,
                ];

                $result = $familyImplModel->store($data, $dataSecret, $calendarData);
                if ($result === true) {
                    return redirect()->back()->with('success', 'Family member added successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when adding family member!');
                }

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function update(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldFirstName,
                $this->fieldMiddleName,
                $this->fieldLastName,
                $this->fieldRole,
                $this->fieldDob,
                $this->fieldEmail,
                $this->fieldTelephone,
                $this->fieldMobile,
                $this->fieldDescription,
                $this->fieldFacebook,
                $this->fieldInstagram,
                $this->fieldLinkedIn,
                $this->fieldTwitter,
                $this->fieldYoutube,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $familyImplModel = new FamilyImplModel();
                $fileManagerImplModel = new FileManagerImplModel();

                $firstName = $this->request->getPost('first_name');
                $middleName = $this->request->getPost('middle_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $mobile = $this->request->getPost('mobile');
                $telephone = $this->request->getPost('telephone');
                $gender = $this->request->getPost('gender');
                $dob = $this->request->getPost('dob');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');
                $role = $this->request->getPost('role');
                $facebook = $this->request->getPost('facebook');
                $instagram = $this->request->getPost('instagram');
                $linkedIn = $this->request->getPost('linkedIn');
                $twitter = $this->request->getPost('twitter');
                $youtube = $this->request->getPost('youtube');
                $calendarCipherId = $this->request->getPost('calendarId');


                // Update into family
                $data = [
                    'FamilyFirstName' => $firstName,
                    'FamilyMiddleName' => (empty($middleName)) ? null : $middleName,
                    'FamilyLastName' => $lastName,
                    'FamilyEmail' => $email,
                    'FamilyMobile' => (empty($mobile)) ? null : $mobile,
                    'FamilyTelephone' => (empty($telephone)) ? null : $telephone,
                    'FamilyGender' => $gender,
                    'FamilyDob' => $dob,
                    'FamilyRole' => $role,
                    'FamilyDescription' => $description,
                ];

                // Update into familyFile
                $jsonFile = json_decode($file);
                if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'FamilyId' => $num,
                    'FamilyImageFileFk' => $jsonFile->fileId,
                ];

                // Update into family_social_media
                $dataSocial = [
                    'FamilyId' => $num,
                    'FamilySocialFacebook' => (empty($facebook)) ? null : $facebook,
                    'FamilySocialInstagram' => (empty($instagram)) ? null : $instagram,
                    'FamilySocialLinkedIn' => (empty($linkedIn)) ? null : $linkedIn,
                    'FamilySocialTwitter' => (empty($twitter)) ? null : $twitter,
                    'FamilySocialYoutube' => (empty($youtube)) ? null : $youtube,
                ];

                // Set calendarNum
                $calendarNum = SecurityLibrary::decryptUrlId($calendarCipherId);

                // Update into calendar
                $calendarData = [
                    'CalendarTitle' => $firstName . ' birthday',
                    'CalendarDescription' => $firstName . ' birthday',
                    'CalendarStartYear' => DateLibrary::getYear($dob),
                    'CalendarStartMonth' => DateLibrary::getMonthNumber($dob),
                    'CalendarStartDay' => DateLibrary::getDayNumber($dob),
                    'CalendarStartTime' => DateLibrary::getMysqlTime($dob),
                    'ModifiedId' => $num
                ];


                $result = $familyImplModel->update(
                    $num,
                    $data,
                    $dataImage,
                    $dataSocial,
                    $calendarNum,
                    $calendarData
                );
                if ($result === true) {
                    if (session()->get('familyId') == $num) {
                        $familyFile = $familyImplModel->familyImage($num);
                        session()->set('familyName', $firstName . ' ' . $lastName);
                        session()->set('familyRole', $role);
                        session()->set('familyImage', $familyFile->fileSrc);
                        session()->set('familyImageAlt', $familyFile->fileName);
                    }

                    return redirect()->back()->with('success', 'Family updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating family!');
                }

            } else
                return $this->edit(SecurityLibrary::encryptUrlId($num), $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updatePassword(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldNewPassword,
                $this->fieldConfrimNewPassword,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $familyImplModel = new FamilyImplModel();
                $securityLibrary = new SecurityLibrary();

                $confirmNewPassword = $this->request->getPost('confrim_new_password');

                $salt = $securityLibrary->salt16();
                $combinedPassword = $confirmNewPassword . $salt;

                // Get hashed password
                $hashedPassword = $securityLibrary->encrypt($combinedPassword);

                // Update into family_secret
                $dataSecret = [
                    'FamilySecretPassword' => $hashedPassword,
                    'FamilySecretSalt' => $salt
                ];

                if ($familyImplModel->updateSecret($num, $dataSecret, false)) {
                    return redirect()->back()->with('success', 'Family password updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating family password!');
                }
            } else
                return $this->editPassword(SecurityLibrary::encryptUrlId($num), $this->validator);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}