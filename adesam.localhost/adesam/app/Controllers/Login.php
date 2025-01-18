<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\UserImplModel;
use App\ImplModel\ShopImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\DateLibrary;

use Melbahja\Seo\MetaTags;
use Josantonius\Cookie\Facades\Cookie;


class Login extends BaseController
{
    public function __construct()
    {
        helper('cookie');

        Cookie::options(
            httpOnly: true,
        );
    }

    public function index($validator = null)
    {
        try {
            $userImplModel = new UserImplModel();
            $metatags = new MetaTags();



            if ($this->isUserLoggedIn($userImplModel) === true) {
                return redirect()->route('/');
            } else {
                $metatags->title('Login' . $this->metaTitle)
                    ->description('Adesam login')
                    ->meta('author', $this->metaAuthor);

                $data['metatags'] = $metatags;

                $data['title'] = 'Login';
                $data['css_custom'] = '<link href="/assets/css/custom/form.css" rel="stylesheet" />';
                $data['js_custom'] = '<script src="/assets/js/custom/login.js"></script>';
                $data['information'] = $this->information;
                $data['validation'] = $validator;

                return view('login/index', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function login()
    {
        try {
            $validated = $this->validate([
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is alredy used'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[20]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters'
                    ]
                ]
            ]);

            if (!$validated) {
                return $this->index($this->validator);
            } else {
                $userImplModel = new UserImplModel();
                $securityLibrary = new SecurityLibrary();
                $shopImplModel = new ShopImplModel();

                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $rememberMe = $this->request->getPost('remember_me');
                $itemsJson = $this->request->getPost('items');
                $shippingType = $this->request->getPost('shipping-type');
                $paymentMethod = $this->request->getPost('payment-method');

                $userId = $userImplModel->getIdByEmail($email);

                if (!is_null($userId)) {
                    $user = $userImplModel->retrieve($userId);

                    // Set all of user
                    $userSecret = $user->secret;

                    // Check password with hashed password
                    $dbPassword = $userSecret->password;
                    $dbSalt = $userSecret->salt;
                    $combinedPassword = $password . $dbSalt;
                    $checkPassword = $securityLibrary->check($combinedPassword, $dbPassword);

                    if ($checkPassword) {
                        $this->setSession($user);

                        if (boolval($rememberMe) === true) {
                            [$selector, $validator, $cookies] = SecurityLibrary::generateCookies();

                            // set expiration date
                            $expired_seconds = time() + 60 * 60 * 24 * 1;

                            // insert a token to the database
                            $hashValidator = SecurityLibrary::hash($validator);
                            $expiry = date('Y-m-d H:i:s', $expired_seconds);

                            $dataCookie = [
                                'UserCookieUserFk' => $userId,
                                'UserCookieSelector' => $selector,
                                'UserCookieHashedValidator' => $hashValidator,
                                'UserCookieExpires' => $expiry
                            ];

                            if ($userImplModel->saveCookie($userId, $dataCookie) === true) {
                                Cookie::set('remember_me', $cookies, DateLibrary::toTimestamp($expiry));
                            }

                        }

                        $items = json_decode($itemsJson) ?? array();
                        $this->saveCart($shopImplModel, $user->id, $items, $shippingType, $paymentMethod);

                        return redirect()->route('/');
                    } else {
                        return redirect()->back()->with('fail', 'Incorrect email or password provided!');
                    }
                } else {
                    return redirect()->back()->with('fail', 'Incorrect email or password provided!');
                }

            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    private function isUserLoggedIn(UserImplModel $userImplModel): bool
    {
        if (Cookie::has('remember_me')) {
            // check the remember_me in cookie
            $cookie = Cookie::get('remember_me');
            $cookies = $this->parseCookie($cookie);
            $selector = $cookies[0];
            $validator = $cookies[1];

            $userCookie = $userImplModel->userCookie($selector);
            $result = SecurityLibrary::check($validator, $userCookie->hashedValidator);

            if ($result === true) {
                $user = $userImplModel->retrieve($userCookie->userId);
                $this->setSession($user);

                return $result;
            }

        } else {
            return false;
        }

        return false;

    }

    private function saveCart(ShopImplModel $shopImplModel, int $userId, $items, $shippingType, $paymentMethod): bool
    {
        // Insert into cart
        $data = [
            'CartUserUserFk' => $userId,
            'CartPaymentMethod' => $paymentMethod,
            'CartShippingType' => $shippingType
        ];

        // Insert into cartItems
        $dataItems = array();
        foreach ($items as $key => $item) {
            // Get productId
            $productId = $shopImplModel->getProductId($item->productUnique);

            $dataItem = [
                'CartItemsQuantity' => $item->quantity,
                'CartItemsProductFk' => $productId
            ];
            array_push($dataItems, $dataItem);
        }

        return $shopImplModel->saveCart($userId, $data, $dataItems);

    }

    private function parseCookie(string $cookie): ?array
    {
        $parts = explode(':', $cookie);

        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }
        return null;
    }

    private function setSession($user)
    {
        // Get user_image
        $userImage = $user->image;

        session()->set('userId', $user->id);
        session()->set('userName', $user->firstName . ' ' . $user->lastName);
        session()->set('userEmail', $user->email);
        if (is_null($userImage)) {
            session()->set('userImage', '/assets/images/avatar_user.png');
            session()->set('userImageAlt', 'Image not set avatar used');
        } else {
            session()->set('userImage', $userImage->fileSrc);
            session()->set('userImageAlt', $userImage->fileName);
        }
        session()->set('userKey', bin2hex(random_bytes(16)));
    }



}
