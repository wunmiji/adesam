<?php


namespace App\Controllers;



use App\Enums\ContactType;
use App\Enums\TagType;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\ContactImplModel;
use App\ImplModel\CalendarImplModel;
use App\ImplModel\TagImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\FileLibrary;
use App\Libraries\DateLibrary;
use App\Enums\Gender;
use App\Enums\SettingType;
use App\Enums\CalendarType;
use App\Enums\CalendarRecurringType;

use Cocur\Slugify\Slugify;


class Contact extends BaseController
{

    protected $fieldTag = [
        'name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for first name is 15'
            ]
        ]
    ];

    protected $fieldFirstName = [
        'first_name' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for first name is 15'
            ]
        ]
    ];

    protected $fieldLastName = [
        'last_name' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for last name is 15'
            ]
        ],
    ];

    protected $fieldNickName = [
        'nickname' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Nickname is required',
                'max_length' => 'Max length for first name is 30'
            ]
        ]
    ];

    protected $fieldDob = [
        'dob' => [
            'rules' => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'Birthday is not valid'
            ]
        ]
    ];

    protected $fieldEmail = [
        'email' => [
            'rules' => 'permit_empty|valid_email',
            'errors' => [
                'valid_email' => 'Email is not valid'
            ]
        ]
    ];

    protected $fieldAddress = [
        'address' => [
            'rules' => 'permit_empty|min_length[10]|max_length[150]',
            'errors' => [
                'min_length' => 'Min length for address is 10',
                'max_length' => 'Max length for address is 150'
            ]
        ]
    ];

    protected $fieldPostalCode = [
        'postal_code' => [
            'rules' => 'permit_empty|min_length[4]|max_length[10]',
            'errors' => [
                'min_length' => 'Min length for postal code is 4',
                'max_length' => 'Max length for postal code is 10'
            ]
        ]
    ];

    protected $fieldCountry = [
        'countries' => [
            'rules' => 'permit_empty',
            'errors' => [
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

    protected $fieldDescription = [
        'description' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for description is 250'
            ]
        ]
    ];

    protected $contactImplModel;


    public function __construct()
    {
        $this->contactImplModel = new ContactImplModel();
    }

    public function index()
    {
        try {
            // set createdId
            $this->contactImplModel->setCreatedId(session()->get('familyId'));

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->contactImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Contacts';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'contacts?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;


            return view('contacts/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function create($validator = null)
    {
        try {
            $fileManagerImplModel = new FileManagerImplModel();
            $tagImplModel = new TagImplModel();

            // Get All Countries
            $countries = FileLibrary::loadJson(APPPATH . 'Resources/countries.json');

            // Get All Tags
            $tagContacts = $tagImplModel->listContact();

            $data['title'] = 'New Contact';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['validation'] = $validator;
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['genderEnum'] = Gender::getAll();
            $data['contactEnum'] = ContactType::getAll();
            $data['countries'] = $countries;
            $data['tags'] = $tagContacts;

            return view('contacts/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Contact';

            // set createdId
            $this->contactImplModel->setCreatedId(session()->get('familyId'));

            $contact = $this->contactImplModel->retrieve($num);
            if (is_null($contact))
                return view('null_error', $data);


            $contactImage = $contact->image;
            $contactAddress = $contact->address;
            $contactTags = $contact->tags;
            $contactAdditionalInformations = $contact->additionalInformations;

            // Get calendars
            $calendarImplModel = new CalendarImplModel();
            $calendars = $calendarImplModel->contactCalendars($num);

            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['data'] = $contact;
            $data['dataAddress'] = $contactAddress;
            $data['dataImage'] = $contactImage;
            $data['dataTags'] = $contactTags;
            $data['dataAdditionalInformations'] = $contactAdditionalInformations;
            $data['calendars'] = $calendars;
            $data['calendarEnum'] = CalendarType::getAll();
            $data['calendarRecurringEnum'] = CalendarRecurringType::getAll();

            return view('contacts/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Contact';

            $fileManagerImplModel = new FileManagerImplModel();
            $calendarImplModel = new CalendarImplModel();
            $tagImplModel = new TagImplModel();
            $settingImplModel = new SettingImplModel();

            // set createdId
            $this->contactImplModel->setCreatedId(session()->get('familyId'));

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $contact = $this->contactImplModel->retrieve($num);
            if (is_null($contact))
                return view('null_error', $data);

                
            $image = $contact->image;
            $address = $contact->address;
            $tags = $contact->tags;
            $contactAdditionalInformations = $contact->additionalInformations;

            // Get calendar_contact
            $calendarId = $calendarImplModel->getIdBirthdayContact($num);

            // Get All Countries
            $countries = FileLibrary::loadJson(APPPATH . 'Resources/countries.json');

            // Get All Tags
            $tagContacts = $tagImplModel->listContact();

            // Get All project_service_ids
            $contactTagIds = array();
            foreach ($tags as $value) {
                $contactTagIds[$value->id] = $value->tagId;
            }

            $data['data'] = $contact;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['dataImage'] = $image;
            $data['dataAddress'] = $address;
            $data['dataTags'] = $contactTagIds;
            $data['dataAdditionalInformations'] = json_encode($contactAdditionalInformations);
            $data['validation'] = $validator;
            $data['genderEnum'] = Gender::getAll();
            $data['contactEnum'] = ContactType::getAll();
            $data['countries'] = $countries;
            $data['tags'] = $tagContacts;
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['calendarCipherId'] = SecurityLibrary::encryptUrlId($calendarId);

            return view('contacts/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $calendarImplModel = new CalendarImplModel();

            // Get calendar_contact
            $calendarId = $calendarImplModel->getIdBirthdayContact($num);

            $result = $this->contactImplModel->delete($num, $calendarId);
            if ($result === true) {
                return redirect()->route('contacts')->with('success', 'Contact deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Contact is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting contact!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function store()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldNickName,
                $this->fieldFirstName,
                $this->fieldLastName,
                $this->fieldDob,
                $this->fieldEmail,
                $this->fieldMobile,
                $this->fieldDescription,
                $this->fieldAddress,
                $this->fieldPostalCode,
                $this->fieldCountry,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();


                $type = $this->request->getPost('type');
                $nickname = $this->request->getPost('nickname');
                $firstName = $this->request->getPost('first_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $gender = $this->request->getPost('gender');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');
                $countryValue = $this->request->getPost('countries') ?? '';
                $postal_code = $this->request->getPost('postal_code');
                $address = $this->request->getPost('address');
                $mobile = $this->request->getPost('mobile');
                $dob = $this->request->getPost('dob');
                $tags = $this->request->getPost('tags') ?? array();
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $familyId = session()->get('familyId');


                // Insert into contact
                $data = [
                    'ContactType' => $type,
                    'ContactNickName' => $nickname,
                    'ContactFirstName' => (empty($firstName)) ? null : $firstName,
                    'ContactLastName' => (empty($lastName)) ? null : $lastName,
                    'ContactGender' => $gender,
                    'ContactNumber' => (empty($mobile)) ? null : $mobile,
                    'ContactEmail' => (empty($email)) ? null : $email,
                    'ContactDob' => (empty($dob)) ? null : $dob,
                    'ContactDescription' => (empty($description)) ? null : $description,
                    'CreatedId' => $familyId,
                ];

                // Insert into contactImage
                $dataImage = [];
                if (!is_null($file)) {
                    $jsonFile = json_decode($file);
                    if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                        return redirect()->back()->with('fail', 'Contact Image not valid!');
                    $dataImage = [
                        'ContactImageFileFk' => $jsonFile->fileId,
                    ];
                }

                // Insert into contactAddress
                $country = json_decode($countryValue);
                $dataAddress = [
                    'ContactAddressAddress' => (empty($address)) ? null : $address,
                    'ContactAddressPostalCode' => (empty($postal_code)) ? null : $postal_code,
                    'ContactAddressCountryName' => (is_null($country)) ? null : $country->name,
                    'ContactAddressCountryCode' => (is_null($country)) ? null : $country->code
                ];

                // Insert into contactTag
                $dataTags = array();
                foreach ($tags as $tag) {
                    $tagArray = [
                        'ContactTagTagFk' => $tag
                    ];
                    array_push($dataTags, $tagArray);
                }

                // Insert into contactAddtionalInformation
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'ContactAddtionalInformationsField' => $each->field,
                        'ContactAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                // Insert into calendar
                $calendarData = [];
                if (!empty($dob)) {
                    $calendarData = [
                        'CalendarTitle' => $nickname . ' birthday',
                        'CalendarDescription' => $nickname . ' birthday',
                        'CalendarLocked' => true,
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
                        'CreatedId' => $familyId,
                    ];
                }


                $result = $this->contactImplModel->store(
                    $data,
                    $dataImage,
                    array_filter($dataAddress),
                    $dataTags,
                    $dataAddtionalInformations,
                    $calendarData
                );

                if ($result === true) {
                    return redirect()->back()->with('success', 'Contact added successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when adding contact!');
                }

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeTag()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldTag
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $tagImplModel = new TagImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $familyId = session()->get('familyId');


                // Insert into tag
                $data = [
                    'TagName' => $name,
                    'TagSlug' => $slugify->slugify($name),
                    'TagType' => TagType::CONTACT->name,
                    'CreatedId' => $familyId,
                ];


                $result = $tagImplModel->store($data);
                if ($result === true)
                    return redirect()->back()->with('success', 'Tag added successfully!');
                else if ($result === 1644)
                    return redirect()->back()->with('fail', 'Name already exist with contact!');
                else {
                    return redirect()->back()->with('fail', 'An error occur when adding tag!');
                }

            } else
                return redirect()->back()->with('fail', $this->validator->getError('name'));

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
                $this->fieldNickName,
                $this->fieldFirstName,
                $this->fieldLastName,
                $this->fieldDob,
                $this->fieldEmail,
                $this->fieldMobile,
                $this->fieldDescription,
                $this->fieldAddress,
                $this->fieldPostalCode,
                $this->fieldCountry,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $calendarImplModel = new CalendarImplModel();

                $type = $this->request->getPost('type');
                $nickname = $this->request->getPost('nickname');
                $firstName = $this->request->getPost('first_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $gender = $this->request->getPost('gender');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');
                $countryValue = $this->request->getPost('countries') ?? '';
                $postal_code = $this->request->getPost('postal_code');
                $address = $this->request->getPost('address');
                $mobile = $this->request->getPost('mobile');
                $dob = $this->request->getPost('dob');
                $tagValues = $this->request->getPost('tags') ?? array();
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $calendarCipherId = $this->request->getPost('calendarId');
                $familyId = session()->get('familyId');


                // Update into contact
                $data = [
                    'ContactId' => $num,
                    'ContactType' => $type,
                    'ContactNickName' => $nickname,
                    'ContactFirstName' => (empty($firstName)) ? null : $firstName,
                    'ContactLastName' => (empty($lastName)) ? null : $lastName,
                    'ContactGender' => $gender,
                    'ContactDob' => (empty($dob)) ? null : $dob,
                    'ContactEmail' => (empty($email)) ? null : $email,
                    'ContactNumber' => (empty($mobile)) ? null : $mobile,
                    'ContactDescription' => (empty($description)) ? null : $description,
                    'ModifiedId' => $familyId,
                ];

                // Update into contactImage
                $dataImage = [];
                if (!is_null($file)) {
                    $jsonFile = json_decode($file);
                    if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                        return redirect()->back()->with('fail', 'Contact Image not valid!');
                    $dataImage = [
                        'ContactId' => $num,
                        'ContactImageFileFk' => $jsonFile->fileId,
                    ];
                }

                // Update into contactAddress
                $country = json_decode($countryValue);
                $dataAddress = [
                    'ContactId' => $num,
                    'ContactAddressAddress' => (empty($address)) ? null : $address,
                    'ContactAddressPostalCode' => (empty($postal_code)) ? null : $postal_code,
                    'ContactAddressCountryName' => (is_null($country)) ? null : $country->name,
                    'ContactAddressCountryCode' => (is_null($country)) ? null : $country->code
                ];

                // Update into contactTag
                $dataTags = array();
                foreach ($tagValues as $tagValue) {
                    $tag = json_decode($tagValue);
                    $tagArray = [
                        'ContactTagId' => $tag->id,
                        'ContactTagContactFk' => $num,
                        'ContactTagTagFk' => $tag->tagId,
                    ];
                    array_push($dataTags, $tagArray);
                }

                // Update into contactAddtionalInformation
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'ContactAddtionalInformationsId' => $each->id,
                        'ContactAddtionalInformationsContactFk' => $num,
                        'ContactAddtionalInformationsField' => $each->field,
                        'ContactAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                // Set calendarNum
                $calendarNum = SecurityLibrary::decryptUrlId($calendarCipherId);

                // Update into calendar
                $calendarData = [];
                if (!empty($dob)) {
                    $calendarData = [
                        'CalendarTitle' => $nickname . ' birthday',
                        'CalendarDescription' => $nickname . ' birthday',
                        'CalendarType' => CalendarType::BIRTHDAY->name,
                        'CalendarStartYear' => DateLibrary::getYear($dob),
                        'CalendarStartMonth' => DateLibrary::getMonthNumber($dob),
                        'CalendarStartDay' => DateLibrary::getDayNumber($dob),
                        'CalendarStartTime' => DateLibrary::getMysqlTime($dob),
                        'CalendarIsRecurring' => true,
                        'CalendarRecurringType' => CalendarRecurringType::YEARLY->name,
                    ];
                }

                $result = $this->contactImplModel->update(
                    $num,
                    $data,
                    $dataImage,
                    $dataAddress,
                    $dataTags,
                    $dataAddtionalInformations,
                    $calendarNum,
                    $calendarData
                );

                if ($result === true) {
                    return redirect()->back()->with('success', 'Contact updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating contact!');
                }

            } else
                return $this->edit(SecurityLibrary::encryptUrlId($num), $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function tags()
    {
        try {
            $tagImplModel = new TagImplModel();

            $tags = $tagImplModel->tableContact();

            $data['title'] = 'Contact Tags';
            $data['js_custom'] = '<script src="/assets/js/custom/tag_info_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['datas'] = $tags;

            return view('contacts/tags', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function tagDelete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $tagImplModel = new TagImplModel();

            $result = $tagImplModel->delete($num);
            if ($result === true) {
                return redirect()->to('contacts/tags')->with('success', 'Tag deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Tag is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting tag!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


}