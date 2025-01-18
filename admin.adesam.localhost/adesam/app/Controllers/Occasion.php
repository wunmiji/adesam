<?php


namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\OccasionImplModel;
use App\ImplModel\CalendarImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\SettingImplModel;
use App\ImplModel\TagImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\DateLibrary;
use App\Enums\TagType;
use App\Enums\OccasionStatus;
use App\Enums\SettingType;
use App\Enums\CalendarType;
use App\Enums\CalendarRecurringType;

use Cocur\Slugify\Slugify;



class Occasion extends BaseController
{

    protected $fieldTag = [
        'name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for tag is 15'
            ]
        ]
    ];

    protected $fieldTitle = [
        'title' => [
            'rules' => 'required|max_length[120]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for title is 120'
            ]
        ]
    ];

    protected $fieldSummary = [
        'summary' => [
            'rules' => 'permit_empty|max_length[250]',
            'errors' => [
                'max_length' => 'Max length for summary is 250'
            ]
        ]
    ];

    protected $fieldText = [
        'text' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Text is required'
            ]
        ]
    ];

    protected $fieldStatus = [
        'status' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Status is required'
            ]
        ]
    ];


    protected $occasionImplModel;


    public function __construct()
    {
        $this->occasionImplModel = new OccasionImplModel();
    }

    public function index()
    {
        try {
            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->occasionImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Occasion';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'occasions?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('occasion/index', $data);
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
            $settingImplModel = new SettingImplModel();

            // Get All tags
            $tagOccasions = $tagImplModel->listOccasion();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $data['title'] = 'New Occasion';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">' .
                '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>' .
                '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/occasion.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['validation'] = $validator;
            $data['tags'] = $tagOccasions;
            $data['occasionEnum'] = OccasionStatus::getAll();
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();

            return view('occasion/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Occasion';

            $tagImplModel = new TagImplModel();
            $calendarImplModel = new CalendarImplModel();
            $fileManagerImplModel = new FileManagerImplModel();
            $settingImplModel = new SettingImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);


            $occasion = $this->occasionImplModel->retrieve($num);
            if (is_null($occasion))
                return view('null_error', $data);

            $image = $occasion->image;
            $text = $occasion->text;
            $tags = $occasion->tags;
            $medias = $occasion->medias;

            // Get calendar_contact
            $calendarId = $calendarImplModel->getIdOccasion($num);

            // Get All occasion_service_ids
            $occasionTagIds = array();
            foreach ($tags as $value) {
                $occasionTagIds[$value->id] = $value->tagId;
            }

            // Get All Tags
            $tagOccasions = $tagImplModel->listOccasion();

            // Get All Medias
            $occasionMedias = json_encode($medias);

            $data['validation'] = $validator;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">' .
                '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>' .
                '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/occasion.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['data'] = $occasion;
            $data['dataImage'] = $image;
            $data['dataText'] = $text;
            $data['dataTags'] = $occasionTagIds;
            $data['dataMedias'] = $occasionMedias;
            $data['tags'] = $tagOccasions;
            $data['occasionEnum'] = OccasionStatus::getAll();
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['calendarCipherId'] = SecurityLibrary::encryptUrlId($calendarId);

            return view('occasion/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Occasion';

            $occasion = $this->occasionImplModel->retrieve($num);
            if (is_null($occasion))
                return view('null_error', $data);


            $calendarImplModel = new CalendarImplModel();
            $calendar = $calendarImplModel->occasionCalendar($num);

            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/flatpickr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/flatpickr.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/flatpickr.js"></script>';
            $data['data'] = $occasion;
            $data['dataText'] = $occasion->text;
            $data['dataImage'] = $occasion->image;
            $data['dataAuthor'] = $occasion->author;
            $data['dataTags'] = $occasion->tags;
            $data['dataMedias'] = $occasion->medias;
            $data['calendar'] = $calendar;
            $data['calendarEnum'] = CalendarType::getAll();
            $data['calendarRecurringEnum'] = CalendarRecurringType::getAll();

            return view('occasion/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $calendarImplModel = new CalendarImplModel();

            // Get calendar_contact
            $calendarId = $calendarImplModel->getIdOccasion($num);

            if ($this->occasionImplModel->delete($num, $calendarId)) {
                return redirect()->route('occasions')->with('success', 'Occasion deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops occasion was not deleted!');
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
                $this->fieldTitle,
                $this->fieldStatus,
                $this->fieldSummary,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $calendarImplModel = new CalendarImplModel();
                $slugify = new Slugify();

                $title = $this->request->getPost('title');
                $summary = $this->request->getPost('summary');
                $text = $this->request->getPost('text');
                $tagValues = $this->request->getPost('tags') ?? array();
                $file = $this->request->getPost('file');
                $publishedDate = $this->request->getPost('publishedDate');
                $status = $this->request->getPost('status');
                $filesValues = $this->request->getPost('files') ?? array();
                $familyId = session()->get('familyId');

                $publishedDate = '';
                if ($status == OccasionStatus::PUBLISHED->name) {
                    $publishedDate = DateLibrary::getZoneDateTime();
                }

                // Insert into occasion
                $data = [
                    'OccasionTitle' => $title,
                    'OccasionSlug' => $slugify->slugify($title),
                    'OccasionSummary' => (empty($summary)) ? null : $summary,
                    'OccasionStatus' => $status,
                    'OccasionPublishedDate' => (empty($publishedDate)) ? null : $publishedDate,
                    'CreatedId' => $familyId,
                ];

                // Insert into occasionImage
                $file = json_decode($file);
                if (is_null($file) || is_null($fileManagerImplModel->getFileId($file->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'OccasionImageFileFk' => $file->fileId,
                ];

                // Insert into occasionText
                $dataText = [
                    'OccasionText' => $text,
                ];

                // Insert into occasionAuthor
                $dataAuthor = [
                    'OccasionAuthorFamilyFk' => $familyId,
                ];

                // Insert into occasionTag
                $dataTags = array();
                foreach ($tagValues as $tagValue) {
                    $tagsArray = [
                        'OccasionTagTagFk' => $tagValue
                    ];
                    array_push($dataTags, $tagsArray);
                }

                // Insert into occasionMedia
                $dataMedias = array();
                foreach ($filesValues as $filesValue) {
                    $file = json_decode($filesValue);
                    if (is_null($fileManagerImplModel->getFileId($file->fileId)))
                        return redirect()->back()->with('fail', 'Media not valid!');
                    $mediaArray = [
                        'OccasionMediaFileFk' => $file->fileId
                    ];
                    array_push($dataMedias, $mediaArray);
                }

                // Insert into calendar
                $calendarData = [];
                if (!empty($publishedDate)) {
                    $calendarData = [
                        'CalendarTitle' => $title,
                        'CalendarDescription' => $title,
                        'CalendarType' => CalendarType::EVENT->name,
                        'CalendarStartYear' => DateLibrary::getYear($publishedDate),
                        'CalendarStartMonth' => DateLibrary::getMonthNumber($publishedDate),
                        'CalendarStartDay' => DateLibrary::getDayNumber($publishedDate),
                        'CalendarStartTime' => DateLibrary::getMysqlTime($publishedDate),
                        'CalendarEndYear' => null,
                        'CalendarEndMonth' => null,
                        'CalendarEndDay' => null,
                        'CalendarEndTime' => null,
                        'CalendarIsRecurring' => false,
                        'CalendarRecurringType' => null,
                        'CreatedId' => $familyId,
                    ];
                }

                $result = $this->occasionImplModel->save(
                    $data,
                    $dataImage,
                    $dataText,
                    $dataAuthor,
                    $dataTags,
                    $dataMedias,
                    $calendarData
                );
                if ($result === true) {
                    return redirect()->back()->with('success', 'Occasion added successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Title already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding occasion!');

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
                    'TagType' => TagType::OCCASION->name,
                    'CreatedId' => $familyId,
                ];


                $result = $tagImplModel->store($data);
                if ($result === true)
                    return redirect()->back()->with('success', 'Tag added successfully!');
                else if ($result === 1644)
                    return redirect()->back()->with('fail', 'Name already exist with occasion!');
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
                $this->fieldTitle,
                $this->fieldStatus,
                $this->fieldSummary,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $calendarImplModel = new CalendarImplModel();
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $title = $this->request->getPost('title');
                $summary = $this->request->getPost('summary');
                $text = $this->request->getPost('text');
                $tagValues = $this->request->getPost('tags') ?? array();
                $file = $this->request->getPost('file');
                $status = $this->request->getPost('status');
                $filesValues = $this->request->getPost('files') ?? array();
                $publishedDate = $this->request->getPost('publishedDate');
                $calendarCipherId = $this->request->getPost('calendarId');
                $familyId = session()->get('familyId');

                $publishedDate = '';
                if ($status == OccasionStatus::PUBLISHED->name) {
                    $publishedDate = DateLibrary::getZoneDateTime();
                }

                // Update into occasion
                $data = [
                    'OccasionTitle' => $title,
                    'OccasionSlug' => $slugify->slugify($title),
                    'OccasionStatus' => $status,
                    'OccasionSummary' => $summary,
                    'OccasionPublishedDate' => (empty($publishedDate)) ? null : $publishedDate,
                    'ModifiedId' => $familyId,
                ];

                // Update into occasionImage
                $file = json_decode($file);
                if (is_null($file) || is_null($fileManagerImplModel->getFileId($file->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'OccasionId' => $num,
                    'OccasionImageFileFk' => $file->fileId,
                ];

                // Update into occasionText
                $dataText = [
                    'OccasionId' => $num,
                    'OccasionText' => $text,
                ];

                // Update into occasionAuthor
                $dataAuthor = [
                    'OccasionId' => $num,
                    'OccasionAuthorFamilyFk' => $familyId,
                ];

                // Update into occasionTag
                $dataTags = array();
                foreach ($tagValues as $tagValue) {
                    $tag = json_decode($tagValue);
                    $tagsArray = [
                        'OccasionTagId' => $tag->id,
                        'OccasionTagTagFk' => $tag->tagId,
                        'OccasionTagOccasionFk' => $num
                    ];
                    array_push($dataTags, $tagsArray);
                }

                // Update into occasionMedia
                $dataMedias = array();
                foreach ($filesValues as $filesValue) {
                    $file = json_decode($filesValue);
                    if (is_null($fileManagerImplModel->getFileId($file->fileId)))
                        return redirect()->back()->with('fail', 'Media not valid!');
                    $mediaArray = [
                        'OccasionMediaId' => $file->id ?? null,
                        'OccasionMediaOccasionFk' => $num,
                        'OccasionMediaFileFk' => $file->fileId
                    ];
                    array_push($dataMedias, $mediaArray);
                }

                 // Set calendarNum
                 $calendarNum = SecurityLibrary::decryptUrlId($calendarCipherId);

                // Insert into calendar
                $calendarData = [];
                if (!empty($publishedDate)) {
                    $calendarData = [
                        'CalendarTitle' => $title,
                        'CalendarDescription' => $title,
                        'CalendarType' => CalendarType::EVENT->name,
                        'CalendarStartYear' => DateLibrary::getYear($publishedDate),
                        'CalendarStartMonth' => DateLibrary::getMonthNumber($publishedDate),
                        'CalendarStartDay' => DateLibrary::getDayNumber($publishedDate),
                        'CalendarStartTime' => DateLibrary::getMysqlTime($publishedDate),
                        'CalendarIsRecurring' => false,
                        'CalendarRecurringType' => null,
                        'CreatedId' => $familyId,
                    ];
                }

                $result = $this->occasionImplModel->update(
                    $num,
                    $data,
                    $dataImage,
                    $dataText,
                    $dataAuthor,
                    $dataTags,
                    $dataMedias,
                    $calendarNum,
                    $calendarData
                );
                if ($result === true) {
                    return redirect()->back()->with('success', 'Occasion updated successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Title already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating occasion!');

            } else
                return $this->edit(SecurityLibrary::encryptUrlId($num), $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function jobs()
    {
        try {
            d('working working working!');
            service('queue')->push('emails', 'email', ['message' => 'Email message goes here']);
            d('djd djdjdjd');
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function tags()
    {
        try {
            $tagImplModel = new TagImplModel();

            $tags = $tagImplModel->tableOccasion();

            $data['title'] = 'Occasion Tags';
            $data['js_custom'] = '<script src="/assets/js/custom/tag_info_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['datas'] = $tags;

            return view('occasion/tags', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function tagDelete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $tagImplModel = new TagImplModel();

            $result = $tagImplModel->delete($num);
            if ($result === true) {
                return redirect()->to('occasions/tags')->with('success', 'Tag deleted successfully!');
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