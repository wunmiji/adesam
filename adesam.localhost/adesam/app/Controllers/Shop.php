<?php


namespace App\Controllers;




use App\Enums\DeliveryStatus;
use App\Enums\ShippingType;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\ShopImplModel;
use App\ImplModel\UserImplModel;
use App\ImplModel\CategoryImplModel;
use App\ImplModel\TagImplModel;
use App\Libraries\FileLibrary;
use App\Libraries\EmailLibrary;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\TagType;

use Melbahja\Seo\MetaTags;



class Shop extends BaseController
{


    public function __construct()
    {
    }

    public function index()
    {
        try {
            $shopImplModel = new ShopImplModel();
            $categoryImplModel = new CategoryImplModel();
            $tagImplModel = new TagImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            $metatags->title('Shops' . $this->metaTitle)
                ->description('View all our products')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/featured-area.jpg'));

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? 5;
            $sortQuery = $this->request->getVar('sort') ?? '';
            $minPriceQuery = $this->request->getVar('min-price') ?? '';
            $maxPriceQuery = $this->request->getVar('max-price') ?? '';
            $categoryQuery = $this->request->getVar('category') ?? '';
            $tagQuery = $this->request->getVar('tag') ?? '';
            $pagination = $shopImplModel->pagination($tagQuery, $categoryQuery, $minPriceQuery, $maxPriceQuery, $sortQuery, $queryPage, $queryLimit);

            // Get all categories
            $categories = $categoryImplModel->listFilter();

            // Get all tags
            $tags = $tagImplModel->list(TagType::PRODUCT->name);

            // Set sortQueryString
            $sortQueryString = '';
            if (!empty($sortQuery))
                $sortQueryString = 'sort=' . $sortQuery;

            // Set limitQueryString
            $limitQueryString = '';
            if (!is_null($queryLimit))
                $limitQueryString = 'limit=' . $queryLimit;

            // Set minQueryString
            $minQueryString = '';
            if (!empty($minPriceQuery))
                $minQueryString = 'min-price=' . $minPriceQuery;

            // Set maxQueryString
            $maxQueryString = '';
            if (!empty($maxPriceQuery))
                $maxQueryString = 'max-price=' . $maxPriceQuery;

            // Set categoryQueryString
            $categoryQueryString = '';
            if (!empty($categoryQuery))
                $categoryQueryString = 'category=' . $categoryQuery;

            // Set tagQueryString
            $tagQueryString = '';
            if (!empty($tagQuery))
                $tagQueryString = 'tag=' . $tagQuery;

            // Set queryString
            $queryStringArray = array_filter([$tagQueryString, $categoryQueryString, $minQueryString, $maxQueryString, $sortQueryString, $limitQueryString]);
            array_push($queryStringArray, '');
            $queryString = join('&', $queryStringArray);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/shop_index.js"></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'shop?' . $queryString;
            $data['queryString'] = $queryString;
            $data['categories'] = $categories;
            $data['tags'] = $tags;

            return view('shop/index', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function categories()
    {
        try {
            $categoryImplModel = new CategoryImplModel();
            $metatags = new MetaTags();

            $metatags->title('Categories' . $this->metaTitle)
                ->description('Shop Categories')
                ->meta('author', $this->metaAuthor);


            // Get all categories
            $categories = $categoryImplModel->list();

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['datas'] = $categories;

            return view('shop/categories', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function categoryList(string $slug)
    {
        try {
            $shopImplModel = new ShopImplModel();
            $categoryImplModel = new CategoryImplModel();
            $tagImplModel = new TagImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            // Get all category
            $category = $categoryImplModel->retrieve($slug);

            $metatags->title('Category Products' . $this->metaTitle)
                ->description($category->description)
                ->meta('author', $this->metaAuthor)
                ->image($category->image->fileSrc);

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? 5;
            $sortQuery = $this->request->getVar('sort') ?? '';
            $minPriceQuery = $this->request->getVar('min-price') ?? '';
            $maxPriceQuery = $this->request->getVar('max-price') ?? '';
            $tagQuery = $this->request->getVar('tag') ?? '';
            $pagination = $shopImplModel->categoryPagination($slug, $tagQuery, $minPriceQuery, $maxPriceQuery, $sortQuery, $queryPage, $queryLimit);

            // Get all tags
            $tags = $tagImplModel->list(TagType::PRODUCT->name);

            // Set sortQueryString
            $sortQueryString = '';
            if (!empty($sortQuery))
                $sortQueryString = 'sort=' . $sortQuery;

            // Set limitQueryString
            $limitQueryString = '';
            if (!is_null($queryLimit))
                $limitQueryString = 'limit=' . $queryLimit;

            // Set minQueryString
            $minQueryString = '';
            if (!empty($minPriceQuery))
                $minQueryString = 'min-price=' . $minPriceQuery;

            // Set maxQueryString
            $maxQueryString = '';
            if (!empty($maxPriceQuery))
                $maxQueryString = 'max-price=' . $maxPriceQuery;

            // Set tagQueryString
            $tagQueryString = '';
            if (!empty($tagQuery))
                $tagQueryString = 'tag=' . $tagQuery;

            // Set queryString
            $queryStringArray = array_filter([$tagQueryString, $minQueryString, $maxQueryString, $sortQueryString, $limitQueryString]);
            array_push($queryStringArray, '');
            $queryString = join('&', $queryStringArray);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/shop_index.js"></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'shop/categories/' . $slug . '?' . $queryString;
            $data['queryString'] = $queryString;
            $data['tags'] = $tags;
            $data['category'] = $category;

            return view('shop/category_list', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function tags()
    {
        try {
            $tagImplModel = new TagImplModel();
            $metatags = new MetaTags();

            $metatags->title('Tags' . $this->metaTitle)
                ->description('Shop Tags')
                ->meta('author', $this->metaAuthor);


            // Get all tags
            $tags = $tagImplModel->list(TagType::PRODUCT->name);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['datas'] = $tags;

            return view('shop/tags', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function tagList(string $slug)
    {
        try {
            $shopImplModel = new ShopImplModel();
            $tagImplModel = new TagImplModel();
            $categoryImplModel = new CategoryImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            // Get tag
            $tag = $tagImplModel->retrieve($slug, TagType::PRODUCT->name);

            $metatags->title('Tag Products' . $this->metaTitle)
                ->description('Tag Products')
                ->meta('author', $this->metaAuthor)
                ->image(base_url('assets/images/featured-area.jpg'));

            $queryPage = $this->request->getVar('page') ?? 1;
            $queryLimit = $this->request->getVar('limit') ?? 5;
            $sortQuery = $this->request->getVar('sort') ?? '';
            $minPriceQuery = $this->request->getVar('min-price') ?? '';
            $maxPriceQuery = $this->request->getVar('max-price') ?? '';
            $categoryQuery = $this->request->getVar('category') ?? '';
            $pagination = $shopImplModel->tagPagination($slug, $categoryQuery, $minPriceQuery, $maxPriceQuery, $sortQuery, $queryPage, $queryLimit);

            // Get all categories
            $categories = $categoryImplModel->listFilter();

            // Set sortQueryString
            $sortQueryString = '';
            if (!empty($sortQuery))
                $sortQueryString = 'sort=' . $sortQuery;

            // Set limitQueryString
            $limitQueryString = '';
            if (!is_null($queryLimit))
                $limitQueryString = 'limit=' . $queryLimit;

            // Set minQueryString
            $minQueryString = '';
            if (!empty($minPriceQuery))
                $minQueryString = 'min-price=' . $minPriceQuery;

            // Set maxQueryString
            $maxQueryString = '';
            if (!empty($maxPriceQuery))
                $maxQueryString = 'max-price=' . $maxPriceQuery;

            // Set categoryQueryString
            $categoryQueryString = '';
            if (!empty($categoryQuery))
                $categoryQueryString = 'category=' . $categoryQuery;


            // Set queryString
            $queryStringArray = array_filter([$categoryQueryString, $minQueryString, $maxQueryString, $sortQueryString, $limitQueryString]);
            array_push($queryStringArray, '');
            $queryString = join('&', $queryStringArray);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['js_custom'] = '<script src="/assets/js/custom/shop_index.js"></script>';
            $data['datas'] = $pagination['list'];
            $data['queryLimit'] = $pagination['queryLimit'];
            $data['queryPage'] = $pagination['queryPage'];
            $data['arrayPageCount'] = $pagination['arrayPageCount'];
            $data['query_url'] = 'shop/tags/' . $slug . '?' . $queryString;
            $data['queryString'] = $queryString;
            $data['categories'] = $categories;
            $data['tag'] = $tag;

            return view('shop/tag_list', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function details($num)
    {
        try {
            $shopImplModel = new ShopImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            $product = $shopImplModel->retrieve($num);
            $productText = $product->text;
            $productImage = $product->image;
            $productTags = $product->tags;
            $productImages = $product->images;
            $productAdditionalInformations = $product->additionalInformations;

            $productTagTagFks = array_column($productTags, 'tagId');
            $relatedProducts = $shopImplModel->related($productTagTagFks);

            $metatags->title('Shops' . $this->metaTitle)
                ->description($product->description)
                ->meta('author', $this->metaAuthor)
                ->image($productImage->fileSrc);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/swiper-bundle.min.css">' .
                '<link rel="stylesheet" href="/assets/css/library/toastr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/form.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/swiper-bundle.min.js"></script>' .
                '<script src="/assets/js/library/toastr.min.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/product_details.js"></script>';
            $data['data'] = $product;
            $data['dataImage'] = $productImage;
            $data['dataText'] = $productText;
            $data['dataTags'] = $productTags;
            $data['dataImages'] = $productImages;
            $data['dataAdditionalInformations'] = $productAdditionalInformations;
            $data['dataRelated'] = $relatedProducts;
            $data['currency'] = $currency;

            return view('shop/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function cart()
    {
        try {
            $shopImplModel = new ShopImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            // Get shipping-price from settings
            $shippingPrice = $this->settingImplModel->getShippingPrice();

            if ($this->request->isAJAX()) {
                $cart = $shopImplModel->retrieveCart(session()->get('userId'));
                return json_encode($cart);
            }

            $metatags->title('Cart' . $this->metaTitle)
                ->description('You have the ability to include multiple items in your shopping cart, 
                    choose your preferred shipping method, 
                    select a payment option, 
                    and review your total cost prior to completing the checkout process.')
                ->meta('author', $this->metaAuthor);

            $cart = null;
            if (session()->has('userId'))
                $cart = $shopImplModel->retrieveCart(session()->get('userId'));

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['js_library'] = '<script src="/assets/js/library/toastr.min.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/cart.js"></script>';
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/toastr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['data'] = $cart;
            $data['currency'] = $currency;
            $data['shippingPrice'] = $shippingPrice;
            $data['stringShippingPrice'] = $shopImplModel->stringCurrency($shippingPrice);
            $data['paymentMethods'] = PaymentMethod::getAll();

            return view('shop/cart', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function checkout()
    {
        try {
            $shopImplModel = new ShopImplModel();
            $userImplModel = new UserImplModel();
            $metatags = new MetaTags();

            // Get currency from settings
            $currency = $this->settingImplModel->getCurrency();
            $shopImplModel->setCurrency($currency);

            $metatags->title('Checkout' . $this->metaTitle)
                ->description('During the checkout process, 
                    you have the opportunity to complete your payment for the item, 
                    specify both your billing and shipping addresses if asked, 
                    and review the details of your order prior to finalizing the payment.')
                ->meta('author', $this->metaAuthor);

            // Get All Countries
            $countries = FileLibrary::loadJson(APPPATH . 'Resources/countries_states.json');

            // Get userId
            $userId = session()->get('userId');

            // Get User from db
            $user = $userImplModel->retrieve($userId);

            $cart = $shopImplModel->retrieveCart(session()->get('userId'));

            // Set Shipping Price
            $shippingPrice = '';
            if ($cart->shippingType == ShippingType::LOCAL_PICKUP->name) {
                $shippingPrice = 0;
            } elseif ($cart->shippingType == ShippingType::FLAT_RATE->name) {
                // Get shipping-price from settings
                $shippingPrice = $this->settingImplModel->getShippingPrice();
            }

            //if (empty($cart->items))
            //  return redirect()->route('Shop::cart');

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['js_custom'] = '';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/credit-card-form.css">';
            $data['data'] = $cart;
            $data['countries'] = $countries;
            $data['shippingPrice'] = $shippingPrice;
            $data['js_custom'] = '<script src="/assets/js/custom/address.js"></script>' .
                '<script src="/assets/js/custom/checkout.js"></script>';
            $data['dataBillingAddresses'] = $user->billingAddress;
            $data['dataShippingAddresses'] = $user->shippingAddress;
            $data['currency'] = $currency;

            return view('shop/checkout', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function removeCart(string $unique)
    {
        try {
            $shopImplModel = new ShopImplModel();


            if ($this->request->isAJAX()) {
                // Get productId
                $productId = $shopImplModel->getProductId($unique);

                $result = $shopImplModel->removeCart($productId);
                if ($result === true) {
                    return json_encode(true);
                } else {
                    return json_encode(false);
                }
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function emptyCart()
    {
        try {
            $shopImplModel = new ShopImplModel();

            $userId = session()->get('userId');

            if (session()->has('userId')) {
                $result = $shopImplModel->emptyCart($userId);
                if ($result === true) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->with('fail', 'An error occur when removig products from cart!');
                }
            } else
                return redirect()->back();


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function saveCart()
    {
        try {
            if ($this->request->isAJAX()) {
                $shopImplModel = new ShopImplModel();
                $userId = session()->get('userId');

                $quantity = $this->request->getPost('quantity');
                $productUnique = $this->request->getPost('productUnique');

                // Get productId
                $productId = $shopImplModel->getProductId($productUnique);

                // Insert into cart
                $data = [
                    'CartUserUserFk' => $userId,
                ];

                // Insert into cartItems
                $dataItems = array();
                $dataItem = [
                    'CartItemsQuantity' => $quantity,
                    'CartItemsProductFk' => $productId
                ];
                array_push($dataItems, $dataItem);

                $result = $shopImplModel->saveCart($userId, $data, $dataItems);
                if ($result == true)
                    return json_encode(true);
                else if ($result == false)
                    return json_encode(false);
                else
                    return json_encode($result);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updateCart()
    {
        try {
            $shopImplModel = new ShopImplModel();
            $userId = session()->get('userId');
            if ($this->request->isAJAX()) {

                $items = $this->request->getPost('items');
                $shippingType = $this->request->getPost('shipping-type');
                $paymentMethod = $this->request->getPost('payment-method');

                // Update into cart
                $data = [
                    'CartUserUserFk' => $userId,
                    'CartShippingType' => $shippingType,
                    'CartPaymentMethod' => $paymentMethod
                ];

                // Update into cartItems
                $dataItems = array();
                $dataItemArray = json_decode($items);
                foreach ($dataItemArray as $each) {
                    $dataItem = [
                        'CartItemsId' => $each->id,
                        'CartItemsProductFk' => $each->productId,
                        'CartItemsQuantity' => $each->quantity
                    ];
                    array_push($dataItems, $dataItem);
                }


                $result = $shopImplModel->updateCart($userId, $data, $dataItems);
                if ($result == true)
                    return json_encode(true);
                else if ($result == false)
                    return json_encode(false);

            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function saveCheckout()
    {
        try {
            $shopImplModel = new ShopImplModel();

            $itemsJson = $this->request->getPost('items');
            $instruction = $this->request->getPost('instruction');
            $subTotal = $this->request->getPost('subtotal');
            $total = $this->request->getPost('total');
            $shippingType = $this->request->getPost('shipping-type');
            $shippingPrice = $this->request->getPost('shipping-price');
            $billingAddressJson = $this->request->getPost('billing-address');
            $shippingAddressJson = $this->request->getPost('shipping-address');
            $paymentMethod = $this->request->getPost('payment-method');
            $userId = session()->get('userId');

            if ($shippingType == ShippingType::FLAT_RATE->name && empty($shippingAddressJson))
                return redirect()->back()->with('fail', 'Shipping address not selected');
            if ($paymentMethod == PaymentMethod::CREDIT_CARD->name && empty($billingAddressJson))
                return redirect()->back()->with('fail', 'Billing address not selected');

            // Get order number
            $orderNumber = $shopImplModel->generateOrderNumber();

            // Set OrderStatus and OrderPaymentStatus
            $orderStatus = null;
            $orderPaymentStatus = null;
            if ($paymentMethod == PaymentMethod::CREDIT_CARD->name || $paymentMethod == PaymentMethod::PAYPAL->name) {
                $orderStatus = OrderStatus::PAID->name;
                $orderPaymentStatus = PaymentStatus::COMPLETED->name;
            } else {
                $orderStatus = OrderStatus::NEW ->name;
                $orderPaymentStatus = PaymentStatus::PENDING->name;
            }


            // Insert into orderItems
            $dataItems = array();
            $itemsArray = json_decode($itemsJson);
            foreach ($itemsArray as $each) {
                $item = [
                    'OrderItemsProductFk' => $each->productId,
                    'OrderItemsQuantity' => $each->quantity,
                    'OrderItemsPrice' => $each->productPrice,
                    'OrderItemsTotal' => $each->total,
                ];
                array_push($dataItems, $item);
            }

            // Insert into order
            $data = [
                'OrderNumber' => $orderNumber,
                'OrderStatus' => $orderStatus,
                'OrderPaymentStatus' => $orderPaymentStatus,
                'OrderDeliveryStatus' => DeliveryStatus::PENDING->name,
                'OrderSubtotal' => $subTotal,
                'OrderInstruction' => (empty($instruction)) ? null : $instruction,
                'OrderTotal' => $total,
                'OrderUserFk' => $userId,
            ];

            // Insert into order_shipping
            $dataShipping = [
                'OrderShippingType' => $shippingType,
                'OrderShippingPrice' => $shippingPrice,
            ];

            // Insert into orderBillingAddress
            $dataBillingAddress = [];
            if (!empty($billingAddressJson)) {
                $billingAddress = json_decode($billingAddressJson);
                $dataBillingAddress = [
                    'OrderBillingAddressFirstName' => $billingAddress->firstName,
                    $billingAddress->lastName,
                    'OrderBillingAddressLastName' => $billingAddress->lastName,
                    'OrderBillingAddressEmail' => $billingAddress->email,
                    'OrderBillingAddressNumber' => $billingAddress->number,
                    'OrderBillingAddressAddressOne' => $billingAddress->addressOne,
                    'OrderBillingAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                    'OrderBillingAddressPostalCode' => $billingAddress->postalCode,
                    'OrderBillingAddressCity' => $billingAddress->city,
                    'OrderBillingAddressStateName' => $billingAddress->stateName,
                    'OrderBillingAddressStateCode' => $billingAddress->stateCode,
                    'OrderBillingAddressCountryName' => $billingAddress->countryName,
                    'OrderBillingAddressCountryCode' => $billingAddress->countryCode
                ];
            }

            // Insert into orderShippigAddress
            $dataShippigAddress = [];
            if (!empty($shippingAddressJson)) {
                $shippingAddress = json_decode($shippingAddressJson);
                $dataShippigAddress = [
                    'OrderShippingAddressFirstName' => $shippingAddress->firstName,
                    'OrderShippingAddressLastName' => $shippingAddress->lastName,
                    'OrderShippingAddressEmail' => $shippingAddress->email,
                    'OrderShippingAddressNumber' => $shippingAddress->number,
                    'OrderShippingAddressAddressOne' => $shippingAddress->addressOne,
                    'OrderShippingAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                    'OrderShippingAddressPostalCode' => $shippingAddress->postalCode,
                    'OrderShippingAddressCity' => $shippingAddress->city,
                    'OrderShippingAddressStateName' => $shippingAddress->stateName,
                    'OrderShippingAddressStateCode' => $shippingAddress->stateCode,
                    'OrderShippingAddressCountryName' => $shippingAddress->countryName,
                    'OrderShippingAddressCountryCode' => $shippingAddress->countryCode
                ];
            }

            // Insert into order_payments
            $dataPayment = [];
            if ($paymentMethod == PaymentMethod::CREDIT_CARD->name) {
                $dataPayment = [
                    'OrderPaymentsName' => $dataBillingAddress['OrderBillingAddressFirstName'] . ' ' . $dataBillingAddress['OrderBillingAddressLastName'],
                    'OrderPaymentsAmount' => $total,
                    'OrderPaymentsMethod' => $paymentMethod,
                    'OrderPaymentsStatus' => PaymentStatus::COMPLETED->name,
                ];
            }


            $result = $shopImplModel->saveOrder($data, $dataItems, $dataShipping, $dataBillingAddress, $dataShippigAddress, $dataPayment);
            if ($result === true) {
                return redirect()->back()->with('success', 'Order placed successfully!');
            } else {
                return redirect()->back()->with('fail', 'An error occur when placing order!');
            }


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function enquiry()
    {
        try {
            $userImplModel = new UserImplModel();
            $emailLibrary = new EmailLibrary();

            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $message = $this->request->getPost('message');
            $unique = $this->request->getPost('unique');
            $userId = session()->get('userId');

            $result = false;
            if (session()->has('userId')) {
                $user = $userImplModel->retrieve($userId);
                $name = $user->name;
                $email = $user->email;

                $data = [
                    'name' => $name,
                    'unique' => $unique,
                    'email' => $email,
                    'message' => $message
                ];
                $html = view_cell('\App\Cells\EmailCell::productInquiry', $data);

                $emailLibrary->setFrom('madewunmi31@outlook.com', $name);
                $emailLibrary->setTo('wunmiji@gmail.com');
                $emailLibrary->setSubject('Product Enquiry for ' . $unique);
                $emailLibrary->setMessage($html);

                $result = $emailLibrary->send();
            } else {
                $data = [
                    'name' => $name,
                    'unique' => $unique,
                    'email' => $email,
                    'message' => $message
                ];
                $html = view_cell('\App\Cells\EmailCell::productInquiry', $data);

                $emailLibrary->setFrom($email, $name);
                $emailLibrary->setTo('wunmiji@gmail.com');
                $emailLibrary->setSubject('Product Enquiry for ' . $unique);
                $emailLibrary->setMessage($html);

                $result = $emailLibrary->send();
            }

            return json_encode($result);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}