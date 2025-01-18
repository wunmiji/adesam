<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\CalendarImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\DateLibrary;
use App\Enums\CalendarType;
use App\Enums\CalendarRecurringType;
use App\Enums\SettingType;




class Calendar extends BaseController
{

    protected $fieldTitle = [
        'title' => [
            'rules' => 'required|max_length[120]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for title is 120'
            ]
        ]
    ];

    protected $fieldStartDateTime = [
        'startDateTime' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Date is required',
            ]
        ]
    ];

    protected $fieldEndDateTime = [
        'endDateTime' => [
            'rules' => 'permit_empty',
            'errors' => [

            ]
        ]
    ];

    protected $fieldType = [
        'type' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Type is required'
            ]
        ]
    ];

    protected $fieldRecurringType = [
        'recurringType' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Recurring Type is required'
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


    protected $calendarImplModel;


    public function __construct()
    {
        $this->calendarImplModel = new CalendarImplModel();
    }

    public function index()
    {
        try {
            if ($this->request->isAJAX()) {
                $date = $this->request->getVar('date');
                $year = DateLibrary::getYear($date);
                $month = DateLibrary::getMonthNumber($date);
                $day = DateLibrary::getDayNumber($date);
                return json_encode($this->calendarImplModel->list($year, $month, $day));
            }

            $settingImplModel = new SettingImplModel();

            // Get calendar from settings
            $calendar = $settingImplModel->list(SettingType::CALENDAR->name);


            $data['title'] = 'Calendar';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">' .
                '<link href="/assets/css/library/bootstrap-icons.css" rel="stylesheet">' .
                '<script src="/assets/js/library/index.global.min.js"></script>' .
                '<script src="/assets/js/custom/calendar.js"></script>';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>' .
                '<script src="/assets/js/library/moment.min.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['timezone'] = date_default_timezone_get();
            $data['firstDay'] = $calendar->{'first-day'}->value;
            $data['date'] = DateLibrary::getCurrentDateYjd();

            return view('calendar/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function create($validator = null)
    {
        try {
            $settingImplModel = new SettingImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $date = $this->request->getVar('date') ?? null;

            $data['title'] = 'New Calendar';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['validation'] = $validator;
            $data['calendarEnum'] = CalendarType::getAll();
            $data['CalendarRecurringEnum'] = CalendarRecurringType::getAll();
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['dataDate'] = $date;

            return view('calendar/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $date, string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Calendar';

            $fileManagerImplModel = new FileManagerImplModel();
            $settingImplModel = new SettingImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $calendar = $this->calendarImplModel->retrieve($num);
            if (is_null($calendar))
                return view('null_error', $data);
            elseif ($calendar->isLocked) {
                $data['type'] = 'Update';
                return view('calendar/locked', $data);
            }


            $calendarImage = $calendar->image;
            $calendarAdditionalInformations = $calendar->extendedProps;

            $data['validation'] = $validator;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['validation'] = $validator;
            $data['calendarEnum'] = CalendarType::getAll();
            $data['CalendarRecurringEnum'] = CalendarRecurringType::getAll();
            $data['data'] = $calendar;
            $data['dataImage'] = $calendarImage;
            $data['dataAdditionalInformations'] = json_encode($calendarAdditionalInformations);
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['dataDate'] = $date;

            return view('calendar/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function date(string $date)
    {
        try {
            $year = DateLibrary::getYear($date);
            $month = DateLibrary::getMonthNumber($date);
            $day = DateLibrary::getDayNumber($date);

            $calendar = $this->calendarImplModel->date($year, $month, $day);

            $data['title'] = 'Calendar';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $calendar;
            $data['dataDate'] = $date;
            $data['dataDateString'] = DateLibrary::getDate($date);

            return view('calendar/date', $data);


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $date, string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Calendar';

            $calendar = $this->calendarImplModel->retrieve($num);
            if (is_null($calendar))
                return view('null_error', $data);

            $calendarImage = $calendar->image;
            $calendarAdditionalInformations = $calendar->extendedProps;

            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src=/assets/js/custom/search_table.js></script>';
            $data['data'] = $calendar;
            $data['dataImage'] = $calendarImage;
            $data['dataAdditionalInformations'] = $calendarAdditionalInformations;
            $data['dataDate'] = $date;

            return view('calendar/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $date, string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $calendar = $this->calendarImplModel->retrieve($num);
            if ($calendar->isLocked) {
                $data['type'] = 'Delete';
                return view('calendar/locked', $data);
            }

            if ($this->calendarImplModel->delete($num)) {
                return redirect()->to('calendar/' . $date)->with('success', 'Calendar deleted successfully!');
            } else {
                return redirect()->to('calendar/' . $date)->with('fail', 'Ooops calendar was not deleted!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function store()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldTitle,
                $this->fieldType,
                $this->fieldRecurringType,
                $this->fieldStartDateTime,
                $this->fieldEndDateTime,
                $this->fieldDescription
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();

                $title = $this->request->getPost('title');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');
                $startDateTime = $this->request->getPost('startDateTime');
                $endDateTime = $this->request->getPost('endDateTime');
                $type = $this->request->getPost('type');
                $recurringType = $this->request->getPost('recurringType');
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $contactCipherId = $this->request->getPost('contactId');
                $occasionCipherId = $this->request->getPost('occasionId');
                $familyCipherId = $this->request->getPost('familyId');
                $familyId = session()->get('familyId');

                // Insert into calendar
                $data = [
                    'CalendarTitle' => $title,
                    'CalendarDescription' => $description,
                    'CalendarType' => $type,
                    'CalendarLocked' => false,
                    'CalendarStartYear' => DateLibrary::getYear($startDateTime),
                    'CalendarStartMonth' => DateLibrary::getMonthNumber($startDateTime),
                    'CalendarStartDay' => DateLibrary::getDayNumber($startDateTime),
                    'CalendarStartTime' => DateLibrary::getMysqlTime($startDateTime),
                    'CalendarEndYear' => (empty($endDateTime)) ? null : DateLibrary::getYear($endDateTime),
                    'CalendarEndMonth' => (empty($endDateTime)) ? null : DateLibrary::getMonthNumber($endDateTime),
                    'CalendarEndDay' => (empty($endDateTime)) ? null : DateLibrary::getDayNumber($endDateTime),
                    'CalendarEndTime' => (empty($endDateTime)) ? null : DateLibrary::getMysqlTime($endDateTime),
                    'CalendarIsRecurring' => ($recurringType == 'null') ? false : true,
                    'CalendarRecurringType' => ($recurringType == 'null') ? null : $recurringType,
                    'CreatedId' => $familyId,
                ];

                // Insert into calendarImage
                $dataImage = [];
                if (!is_null($file)) {
                    $file = json_decode($file);
                    if (is_null($file) || is_null($fileManagerImplModel->getFileId($file->fileId)))
                        return redirect()->back()->with('fail', 'Featured Image not valid!');
                    $dataImage = [
                        'CalendarImageFileFk' => $file->fileId,
                    ];
                }

                // Insert into calendarAddtionalInformation
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'CalendarAddtionalInformationsField' => $each->field,
                        'CalendarAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                // Insert into calendarContact
                $dataContact = [];
                if (!is_null($contactCipherId)) {
                    $contactId = SecurityLibrary::decryptUrlId($contactCipherId);
                    $dataContact = [
                        'CalendarContactContactFk' => $contactId,
                        'CalendarContactDob' => false,
                    ];
                }

                // Insert into calendarFamily
                $dataFamily = [];
                if (!is_null($familyCipherId)) {
                    $familyId = SecurityLibrary::decryptUrlId($familyCipherId);
                    $dataFamily = [
                        'CalendarFamilyFamilyFk' => $familyId,
                        'CalendarFamilyDob' => false,
                    ];
                }

                $result = $this->calendarImplModel->store(
                    $data,
                    $dataImage,
                    $dataAddtionalInformations,
                    $dataContact,
                    $dataFamily
                );
                if ($result === true)
                    return redirect()->back()->with('success', 'Calendar added successfully!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding calendar!');

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function update(string $date, string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $fieldValidation = array_merge(
                $this->fieldTitle,
                $this->fieldType,
                $this->fieldStartDateTime,
                $this->fieldEndDateTime,
                $this->fieldDescription
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();

                $title = $this->request->getPost('title');
                $description = $this->request->getPost('description');
                $file = $this->request->getPost('file');
                $startDateTime = $this->request->getPost('startDateTime');
                $endDateTime = $this->request->getPost('endDateTime');
                $type = $this->request->getPost('type');
                $recurringType = $this->request->getPost('recurringType');
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $familyId = session()->get('familyId');

                // Update into calendar
                $data = [
                    'CalendarTitle' => $title,
                    'CalendarDescription' => $description,
                    'CalendarType' => $type,
                    'CalendarLocked' => false,
                    'CalendarStartYear' => DateLibrary::getYear($startDateTime),
                    'CalendarStartMonth' => DateLibrary::getMonthNumber($startDateTime),
                    'CalendarStartDay' => DateLibrary::getDayNumber($startDateTime),
                    'CalendarStartTime' => DateLibrary::getMysqlTime($startDateTime),
                    'CalendarEndYear' => (empty($endDateTime)) ? null : DateLibrary::getYear($startDateTime),
                    'CalendarEndMonth' => (empty($endDateTime)) ? null : DateLibrary::getMonthNumber($startDateTime),
                    'CalendarEndDay' => (empty($endDateTime)) ? null : DateLibrary::getDayNumber($startDateTime),
                    'CalendarEndTime' => (empty($endDateTime)) ? null : DateLibrary::getMysqlTime($endDateTime),
                    'CalendarIsRecurring' => ($recurringType == 'null') ? false : true,
                    'CalendarRecurringType' => ($recurringType == 'null') ? null : $recurringType,
                    'CreatedId' => $familyId,
                ];

                // Update into calendarImage
                $dataImage = [];
                if (!is_null($file)) {
                    $jsonFile = json_decode($file);
                    if (is_null($jsonFile) || is_null($fileManagerImplModel->getFileId($jsonFile->fileId)))
                        return redirect()->back()->with('fail', 'Calendar Image not valid!');
                    $dataImage = [
                        'CalendarId' => $num,
                        'CalendarImageFileFk' => $jsonFile->fileId,
                    ];
                }

                // Update into calendarAddtionalInformation 
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'CalendarAddtionalInformationsId' => $each->id,
                        'CalendarAddtionalInformationsCalendarFk' => $num,
                        'CalendarAddtionalInformationsField' => $each->field,
                        'CalendarAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                $result = $this->calendarImplModel->update($num, $data, $dataImage, $dataAddtionalInformations);
                if ($result === true)
                    return redirect()->back()->with('success', 'Calendar updated successfully!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating calendar!');

            } else
                return $this->edit($date, SecurityLibrary::encryptUrlId($num), $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}