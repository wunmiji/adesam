<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\CategoryImplModel;
use App\ImplModel\ProductImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Enums\SettingType;

use Cocur\Slugify\Slugify;



class Category extends BaseController
{

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[25]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 25'
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

    protected $fieldText = [
        'text' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Text is required'
            ]
        ]
    ];

    protected $categoryImplModel;


    public function __construct()
    {
        $this->categoryImplModel = new CategoryImplModel();
    }

    public function index()
    {
        try {
            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->categoryImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Category';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'category?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;

            return view('category/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
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

            $data['title'] = 'New Category';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['validation'] = $validator;
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();

            return view('category/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Category';

            $settingImplModel = new SettingImplModel();
            $fileManagerImplModel = new FileManagerImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $category = $this->categoryImplModel->retrieve($num);
            if (is_null($category))
                return view('null_error', $data);


            $image = $category->image;
            $text = $category->text;

            $data['validation'] = $validator;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>';
            $data['data'] = $category;
            $data['dataImage'] = $image;
            $data['dataText'] = $text;
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();

            return view('category/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Category';

            $productImplModel = new ProductImplModel();
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->categoryImplModel->setCurrency(currency: $shop->currency->value);
            $productImplModel->setCurrency(currency: $shop->currency->value);

            $category = $this->categoryImplModel->retrieve($num);
            if (is_null($category))
                return view('null_error', $data);

            $sumProductQuantity = $this->categoryImplModel->sumProductQuantity($num);
            $sumProductPrice = $this->categoryImplModel->sumProductPrice($num);
            $products = $productImplModel->listCategoryProducts($num);

            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>';
            $data['data'] = $category;
            $data['dataText'] = $category->text;
            $data['dataImage'] = $category->image;
            $data['products'] = $products;
            $data['sumProductQuantity'] = $sumProductQuantity;
            $data['sumProductPrice'] = $sumProductPrice;

            return view('category/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            if ($this->categoryImplModel->delete($num)) {
                return redirect()->route('category')->with('success', 'Category deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops category was not deleted!');
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
                $this->fieldName,
                $this->fieldDescription,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $file = $this->request->getPost('file');
                $familyId = session()->get('familyId');

                // Insert into category
                $data = [
                    'CategoryName' => $name,
                    'CategorySlug' => $slugify->slugify($name),
                    'CategoryDescription' => $description,
                    'CreatedId' => $familyId,
                ];

                // Insert into categoryImage
                $file = json_decode($file);
                if (is_null($file) || is_null($fileManagerImplModel->getFileId($file->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'CategoryImageFileFk' => $file->fileId,
                ];

                // Insert into categoryText
                $dataText = [
                    'CategoryText' => $text,
                ];

                $result = $this->categoryImplModel->save($data, $dataImage, $dataText);
                if ($result === true)
                    return redirect()->back()->with('success', 'Category added successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding category!');

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
                $this->fieldName,
                $this->fieldDescription,
                $this->fieldText
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $file = $this->request->getPost('file');
                $familyId = session()->get('familyId');

                // Update into category
                $data = [
                    'CategoryName' => $name,
                    'CategorySlug' => $slugify->slugify($name),
                    'CategoryDescription' => $description,
                    'ModifiedId' => $familyId,
                ];

                // Update into categoryImage
                $file = json_decode($file);
                if (is_null($file) || is_null($fileManagerImplModel->getFileId($file->fileId)))
                    return redirect()->back()->with('fail', 'Featured Image not valid!');
                $dataImage = [
                    'CategoryId' => $num,
                    'CategoryImageFileFk' => $file->fileId,
                ];

                // Update into categoryText
                $dataText = [
                    'CategoryId' => $num,
                    'CategoryText' => $text,
                ];


                $result = $this->categoryImplModel->update($num, $data, $dataImage, $dataText);
                if ($result === true)
                    return redirect()->back()->with('success', 'Category updated successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating category!');

            } else
                return $this->edit($num, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}