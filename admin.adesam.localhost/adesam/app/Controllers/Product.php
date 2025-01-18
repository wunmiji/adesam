<?php


namespace App\Controllers;



use App\Libraries\MoneyLibrary;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\ProductImplModel;
use App\ImplModel\CategoryImplModel;
use App\ImplModel\OrderImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\TagImplModel;
use App\ImplModel\DiscountImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\DateLibrary;
use App\Enums\TagType;
use App\Enums\DiscountType;
use App\Enums\SettingType;
use App\Enums\ProductStatus;
use App\Enums\ProductStockStatus;
use App\Enums\ProductVisibilityStatus;

use Cocur\Slugify\Slugify;



class Product extends BaseController
{

    protected $fieldTagName = [
        'name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for tag is 15'
            ]
        ]
    ];

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 250'
            ]
        ]
    ];

    protected $fieldSku = [
        'sku' => [
            'rules' => 'required|min_length[4]|max_length[25]',
            'errors' => [
                'required' => 'SKU is required',
                'min_length' => 'Min length for sku is 4',
                'max_length' => 'Max length for sku is 25'
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

    protected $fieldDescription = [
        'description' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Max length for description is 250'
            ]
        ]
    ];

    protected $fieldVisibilityStatus = [
        'visibility-status' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Visibility status is required'
            ]
        ]
    ];

    protected $fieldCategory = [
        'category' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Category is required'
            ]
        ]
    ];

    protected $fieldDiscount = [
        'discount' => [
            'rules' => 'permit_empty',
            'errors' => [
            ]
        ]
    ];

    protected $fieldQuantity = [
        'quantity' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Quantity is required'
            ]
        ]
    ];

    protected $fieldCostPrice = [
        'cost_price' => [
            'rules' => 'required|regex_match[/^\d{1,6}(?:\.\d{0,2})?$/]',
            'errors' => [
                'required' => 'Cost Price is required',
                'regex_match' => 'Cost Price is not valid',
            ]
        ]
    ];

    protected $fieldSellingPrice = [
        'selling_price' => [
            'rules' => 'required|regex_match[/^\d{1,6}(?:\.\d{0,2})?$/]',
            'errors' => [
                'required' => 'Selling Price is required',
                'regex_match' => 'Selling Price is not valid',
            ]
        ]
    ];

    protected $productImplModel;


    public function __construct()
    {
        $this->productImplModel = new ProductImplModel();
    }

    public function index()
    {
        try {
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->productImplModel->setCurrency($shop->currency->value);

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? reset($this->paginationLimitArray);
            $pagination = $this->productImplModel->pagination($queryPage, $queryLimit);

            $data['title'] = 'Product';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'products?';
            $data['paginationLimitArray'] = $this->paginationLimitArray;
            $data['discountEnum'] = DiscountType::getAll();

            return view('product/index', $data);
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
            $discountImplModel = new DiscountImplModel();
            $categoryImplModel = new CategoryImplModel();
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $currencySymbol = MoneyLibrary::getSymbol($shop->currency->value);

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            // Get All tags
            $tagProducts = $tagImplModel->listProduct();

            // Get All discounts
            $discounts = $discountImplModel->list();

            // Get All categories
            $categoryCount = $categoryImplModel->count();
            $categories = $categoryImplModel->list(0, $categoryCount);

            $data['title'] = 'New Product';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>' .
                '<script src="/assets/js/custom/product.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['validation'] = $validator;
            $data['tags'] = $tagProducts;
            $data['discounts'] = $discounts;
            $data['categories'] = $categories;
            $data['visibilityStatusEnum'] = ProductVisibilityStatus::getAll();
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['currencySymbol'] = $currencySymbol;

            return view('product/create', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function edit(string $cipher, $validator = null)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'Update Product';

            $fileManagerImplModel = new FileManagerImplModel();
            $tagImplModel = new TagImplModel();
            $discountImplModel = new DiscountImplModel();
            $categoryImplModel = new CategoryImplModel();
            $settingImplModel = new SettingImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->productImplModel->setCurrency(currency: $shop->currency->value);
            $currencySymbol = MoneyLibrary::getSymbol($shop->currency->value);

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $product = $this->productImplModel->retrieve($num);
            if (is_null($product))
                return view('null_error', $data);


            $productText = $product->text;
            $productDiscount = $product->discount;
            $productCategory = $product->category;
            $tagProducts = $product->tags;
            $productImages = json_encode($product->images);
            $productAdditionalInformations = $product->additionalInformations;

            // Get All product_tags_ids
            $productTagIds = array();
            foreach ($tagProducts as $value) {
                $productTagIds[$value->id] = $value->tagId;
            }

            // Get All Tags
            $tags = $tagImplModel->listProduct();

            // Get All discounts
            $discounts = $discountImplModel->list();

            // Get All categories
            $categoryCount = $categoryImplModel->count();
            $categories = $categoryImplModel->list(0, $categoryCount);

            $data['validation'] = $validator;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/quill.snow.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/quill.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/quill.js"></script>' .
                '<script src="/assets/js/custom/product.js"></script>' .
                '<script src="/assets/js/custom/additional_information.js"></script>';
            $data['data'] = $product;
            $data['dataDiscount'] = $productDiscount;
            $data['dataCategory'] = $productCategory;
            $data['dataText'] = $productText;
            $data['dataTags'] = $productTagIds;
            $data['dataImages'] = $productImages;
            $data['dataAdditionalInformations'] = json_encode($productAdditionalInformations);
            $data['tags'] = $tags;
            $data['discounts'] = $discounts;
            $data['categories'] = $categories;
            $data['visibilityStatusEnum'] = ProductVisibilityStatus::getAll();
            $data['dataFileManagerPrivateId'] = $fileManagerImplModel->getFileManagerPrivateId();
            $data['currencySymbol'] = $currencySymbol;


            return view('product/update', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);
            $data['title'] = 'View Product';

            $settingImplModel = new SettingImplModel();
            $orderImplModel = new OrderImplModel();

            // Get currency from settings
            $shop = $settingImplModel->list(SettingType::SHOP->name);
            $this->productImplModel->setCurrency(currency: $shop->currency->value);
            $orderImplModel->setCurrency(currency: $shop->currency->value);
            

            $product = $this->productImplModel->retrieve($num);
            if (is_null($product))
                return view('null_error', $data);

            $productText = $product->text;
            $productImage = $product->image;
            $productDiscount = $product->discount;
            $productTags = $product->tags;
            $productImages = $product->images;
            $productAdditionalInformations = $product->additionalInformations;

            // Get orders of product
            $orderItems = $orderImplModel->orderItemsProduct($num);

            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>';
            $data['data'] = $product;
            $data['dataImage'] = $productImage;
            $data['dataText'] = $productText;
            $data['dataDiscount'] = $productDiscount;
            $data['dataTags'] = $productTags;
            $data['dataImages'] = $productImages;
            $data['dataAdditionalInformations'] = $productAdditionalInformations;
            $data['orderItems'] = $orderItems;

            return view('product/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            if ($this->productImplModel->delete($num)) {
                return redirect()->route('products')->with('success', 'Product deleted successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops product was not deleted!');
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
                $this->fieldVisibilityStatus,
                $this->fieldSku,
                $this->fieldCategory,
                $this->fieldText,
                $this->fieldDescription,
                $this->fieldDiscount,
                $this->fieldQuantity,
                $this->fieldCostPrice,
                $this->fieldSellingPrice,

            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $discountImplModel = new DiscountImplModel();

                $name = $this->request->getPost('name');
                $sku = $this->request->getPost('sku');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $quantity = $this->request->getPost('quantity');
                $tagValues = $this->request->getPost('tags') ?? array();
                $file = $this->request->getPost('file');
                $visibilityStatus = $this->request->getPost('visibility-status');
                $discountCipher = $this->request->getPost('discount');
                $categoryCipher = $this->request->getPost('category');
                $costPrice = $this->request->getPost('cost_price');
                $sellingPrice = $this->request->getPost('selling_price');
                $filesValues = $this->request->getPost('files') ?? array();
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $familyId = session()->get('familyId');


                // Genearte Product Unique
                $productUnique = $this->productImplModel->generateUnique();

                // Set publichedDate
                $publishedDate = ($visibilityStatus == ProductVisibilityStatus::PUBLISHED->name) ? DateLibrary::getCurrentDate() : null;

                // Set stockStatus
                $stockStatus = ($quantity == 0) ? ProductStockStatus::OUT_OF_STOCK->name : ProductStockStatus::IN_STOCK->name;

                // Insert into productDiscount and Set actualSellingPrice
                $dataDiscount = [];
                $actualSellingPrice = null;
                if (!is_null($discountCipher)) {
                    $discountId = SecurityLibrary::decryptUrlId($discountCipher);
                    $dataDiscount = [
                        'ProductDiscountDiscountFk' => $discountId,
                    ];

                    $actualSellingPrice = $this->setActualSellingPrice($discountImplModel, $sellingPrice, $discountId);
                }

                // Insert into product
                $data = [
                    'ProductName' => $name,
                    'ProductUnique' => $productUnique,
                    'ProductDescription' => $description,
                    'ProductSku' => $sku,
                    'ProductQuantity' => $quantity,
                    'ProductCostPrice' => $costPrice,
                    'ProductSellingPrice' => $sellingPrice,
                    'ProductActualSellingPrice' => $actualSellingPrice ?? $sellingPrice,
                    'ProductStockStatus' => $stockStatus,
                    'ProductVisibilityStatus' => $visibilityStatus,
                    'ProductPublishedDate' => $publishedDate,
                    'CreatedId' => $familyId,
                ];

                // Insert into productCategory
                $dataCategory = [];
                if (!is_null($categoryCipher)) {
                    $categoryId = SecurityLibrary::decryptUrlId($categoryCipher);
                    $dataCategory = [
                        'ProductCategoryCategoryFk' => $categoryId,
                    ];
                }

                // Insert into productImage
                $dataImage = array();

                // Insert into productText
                $dataText = [
                    'ProductText' => $text,
                ];

                // Insert into productTag
                $dataTags = array();
                foreach ($tagValues as $tagValue) {
                    $tagsArray = [
                        'ProductTagTagFk' => SecurityLibrary::decryptUrlId($tagValue),
                    ];
                    array_push($dataTags, $tagsArray);
                }

                // Insert into productImage
                $dataImages = array();
                foreach ($filesValues as $filesValue) {
                    $file = json_decode($filesValue);
                    if (is_null($fileManagerImplModel->getFileId($file->fileId)))
                        return redirect()->back()->with('fail', 'Image not valid!');
                    $imageArray = [
                        'ProductImagesFileFk' => $file->fileId
                    ];
                    array_push($dataImages, $imageArray);
                }

                // Insert into productAddtionalInformation
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'ProductAddtionalInformationsField' => $each->field,
                        'ProductAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                $result = $this->productImplModel->save(
                    $data,
                    $dataImage,
                    $dataText,
                    $dataCategory,
                    $dataDiscount,
                    $dataTags,
                    $dataImages,
                    $dataAddtionalInformations
                );
                if ($result === true)
                    return redirect()->back()->with('success', 'Product added successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'SKU already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding product!');

            } else
                return $this->create($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeDiscount()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldTagName
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $discountImplModel = new DiscountImplModel();

                $name = $this->request->getPost('name');
                $type = $this->request->getPost('type');
                $value = $this->request->getPost('value');
                $familyId = session()->get('familyId');


                // Insert into discount
                $data = [
                    'DiscountName' => $name,
                    'DiscountType' => $type,
                    'DiscountValue' => $value,
                    'CreatedId' => $familyId,
                ];

                if ($discountImplModel->store($data)) {
                    return redirect()->back()->with('success', 'Discount added successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when adding discount!');
                }

            } else
                return redirect()->back()->with('fail', $this->validator->getError('name'));

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeTag()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldTagName
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
                    'TagType' => TagType::PRODUCT->name,
                    'CreatedId' => $familyId,
                ];

                $result = $tagImplModel->store($data);
                if ($result === true)
                    return redirect()->back()->with('success', 'Tag added successfully!');
                else if ($result === 1644)
                    return redirect()->back()->with('fail', 'Name already exist with product!');
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
                $this->fieldName,
                $this->fieldVisibilityStatus,
                $this->fieldSku,
                $this->fieldCategory,
                $this->fieldText,
                $this->fieldDescription,
                $this->fieldDiscount,
                $this->fieldQuantity,
                $this->fieldCostPrice,
                $this->fieldSellingPrice,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $fileManagerImplModel = new FileManagerImplModel();
                $discountImplModel = new DiscountImplModel();

                $name = $this->request->getPost('name');
                $sku = $this->request->getPost('sku');
                $description = $this->request->getPost('description');
                $text = $this->request->getPost('text');
                $quantity = $this->request->getPost('quantity');
                $tagValues = $this->request->getPost('tags') ?? array();
                $file = $this->request->getPost('file');
                $visibilityStatus = $this->request->getPost('visibility-status');
                $discountCipher = $this->request->getPost('discount');
                $categoryCipher = $this->request->getPost('category');
                $costPrice = $this->request->getPost('cost_price');
                $sellingPrice = $this->request->getPost('selling_price');
                $filesValues = $this->request->getPost('files') ?? array();
                $additionalInformationsHidden = $this->request->getPost('additionalInformationsHidden');
                $familyId = session()->get('familyId');


                // Set publichedDate
                $publishedDate = ($visibilityStatus == ProductVisibilityStatus::PUBLISHED->name) ? DateLibrary::getCurrentDate() : null;

                // Set stockStatus
                $stockStatus = ($quantity == 0) ? ProductStockStatus::OUT_OF_STOCK->name : ProductStockStatus::IN_STOCK->name;

                // Update into productDiscount and Set actualSellingPrice
                $dataDiscount = [];
                $actualSellingPrice = null;
                if (!is_null($discountCipher)) {
                    $discountId = SecurityLibrary::decryptUrlId($discountCipher);
                    $dataDiscount = [
                        'ProductId' => $num,
                        'ProductDiscountDiscountFk' => $discountId,
                    ];

                    $actualSellingPrice = $this->setActualSellingPrice($discountImplModel, $sellingPrice, $discountId);
                }

                // Update into product
                $data = [
                    'ProductName' => $name,
                    'ProductDescription' => $description,
                    'ProductSku' => $sku,
                    'ProductQuantity' => $quantity,
                    'ProductCostPrice' => $costPrice,
                    'ProductSellingPrice' => $sellingPrice,
                    'ProductActualSellingPrice' => $actualSellingPrice ?? $sellingPrice,
                    'ProductStockStatus' => $stockStatus,
                    'ProductVisibilityStatus' => $visibilityStatus,
                    'ProductPublishedDate' => $publishedDate,
                    'CreatedId' => $familyId,
                ];

                // Insert into productImage
                $dataImage = [
                    'ProductId' => $num,
                ];

                // Insert into productCategory
                $dataCategory = [];
                if (!is_null($categoryCipher)) {
                    $categoryId = SecurityLibrary::decryptUrlId($categoryCipher);
                    $dataCategory = [
                        'ProductId' => $num,
                        'ProductCategoryCategoryFk' => $categoryId,
                    ];
                }

                // Update into productText
                $dataText = [
                    'ProductId' => $num,
                    'ProductText' => $text,
                ];

                // Update into productTag
                $dataTags = array();
                foreach ($tagValues as $tagValue) {
                    $tag = json_decode($tagValue);
                    $tagsArray = [
                        'ProductTagId' => SecurityLibrary::decryptUrlId($tag->id),
                        'ProductTagTagFk' => SecurityLibrary::decryptUrlId($tag->tagId),
                        'ProductTagProductFk' => $num
                    ];
                    array_push($dataTags, $tagsArray);
                }

                // Update into productImages
                $dataImages = array();
                foreach ($filesValues as $filesValue) {
                    $file = json_decode($filesValue);
                    if (is_null($fileManagerImplModel->getFileId($file->fileId)))
                        return redirect()->back()->with('fail', 'Image not valid!');
                    $imageArray = [
                        'ProductImagesId' => $file->id ?? null,
                        'ProductImagesProductFk' => $num,
                        'ProductImagesFileFk' => $file->fileId
                    ];
                    array_push($dataImages, $imageArray);
                }

                // Update into productAddtionalInformation
                $dataAddtionalInformations = array();
                $addtionalInformationsArray = json_decode($additionalInformationsHidden);
                foreach ($addtionalInformationsArray as $each) {
                    $addtionalInformation = [
                        'ProductAddtionalInformationsId' => $each->id,
                        'ProductAddtionalInformationsProductFk' => $num,
                        'ProductAddtionalInformationsField' => $each->field,
                        'ProductAddtionalInformationsLabel' => $each->label,
                    ];
                    array_push($dataAddtionalInformations, $addtionalInformation);
                }

                $result = $this->productImplModel->update(
                    $num,
                    $data,
                    $dataImage,
                    $dataText,
                    $dataCategory,
                    $dataDiscount,
                    $dataTags,
                    $dataImages,
                    $dataAddtionalInformations
                );
                if ($result === true)
                    return redirect()->back()->with('success', 'Product updated successfully!');
                else if ($result === 1062)
                    return redirect()->back()->with('fail', 'SKU already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating product!');

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

            $tags = $tagImplModel->tableProduct();

            $data['title'] = 'Product Tags';
            $data['js_custom'] = '<script src="/assets/js/custom/tag_info_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['datas'] = $tags;

            return view('product/tags', $data);
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
                return redirect()->to('products/tags')->with('success', 'Tag deleted successfully!');
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

    public function discounts()
    {
        try {
            $discountImplModel = new DiscountImplModel();

            $discounts = $discountImplModel->tableProduct();

            $data['title'] = 'Product Discounts';
            $data['js_custom'] = '<script src="/assets/js/custom/discount_info_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>';
            $data['datas'] = $discounts;
            $data['discountEnum'] = DiscountType::getAll();

            return view('product/discounts', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function discountDelete(string $cipher)
    {
        try {
            $num = SecurityLibrary::decryptUrlId($cipher);

            $discountImplModel = new DiscountImplModel();

            $result = $discountImplModel->delete($num);
            if ($result === true) {
                return redirect()->to('products/discounts')->with('success', 'Discount deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Discount is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting discount!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    private function setActualSellingPrice($model, $sellingPrice, $discountId)
    {
        $discount = $model->retrieve($discountId);
        if (is_null($discount)) {
            return null;
        } elseif ($discount->type == DiscountType::AMOUNT->name) {
            return $sellingPrice - $discount->value;
        } elseif ($discount->type == DiscountType::PERCENTAGE->name) {
            $discountAmount = $sellingPrice * ($discount->value / 100);
            return $sellingPrice - $discountAmount;
        }

    }



}