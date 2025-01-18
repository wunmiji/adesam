<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;
use App\ImplModel\UserImplModel;
use App\ImplModel\ShopImplModel;
use App\ImplModel\FileManagerImplModel;
use App\Libraries\SecurityLibrary;
use App\Libraries\FileLibrary;


class User extends BaseController
{

    protected $fieldFirstName = [
        'first_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'First name is required',
                'max_length' => 'Max length for first name is 15'
            ]
        ]
    ];

    protected $fieldLastName = [
        'last_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Last name is required',
                'max_length' => 'Max length for last name is 15'
            ]
        ],
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

    protected $fieldMobile = [
        'mobile' => [
            'rules' => 'permit_empty|max_length[15]',
            'errors' => [
                'max_length' => 'Max length for mobile is 15'
            ]
        ]
    ];

    protected $fieldAddressOne = [
        'address_1' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'Address is required',
                'max_length' => 'Max length for address is 250'
            ]
        ]
    ];

    protected $fieldCity = [
        'city' => [
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => 'City is required',
                'max_length' => 'Max length for city is 250'
            ]
        ]
    ];

    protected $fieldPostalCode = [
        'postal_code' => [
            'rules' => 'required|max_length[10]|alpha_numeric_space',
            'errors' => [
                'required' => 'Postal code is required',
                'max_length' => 'Max length for postal code is 10'
            ]
        ]
    ];

    protected $fieldCountry = [
        'countries' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Country is required'
            ]
        ]
    ];

    protected $fieldState = [
        'states' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'State is required'
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

    protected $fieldCurrentPassword = [
        'current_password' => [
            'rules' => 'required|min_length[5]|max_length[20]',
            'errors' => [
                'required' => 'Your current password is required',
                'min_length' => 'Password must be 5 characters long',
                'max_length' => 'Password cannot be longer than 20 characters'
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


    public function index($validator = null)
    {
        try {
            $userImplModel = new UserImplModel();
            $metatags = new MetaTags();

            $metatags->title('User' . $this->metaTitle)
                ->description('Your Profile')
                ->meta('author', $this->metaAuthor);

            // Get userId
            $userId = session()->get('userId');

            // Get User from db
            $user = $userImplModel->retrieve($userId);
            $userImage = $user->image;

            $data['metatags'] = $metatags;
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['title'] = 'User';
            $data['description'] = 'Our terms';
            $data['keywords'] = 'User';
            $data['information'] = $this->information;
            $data['validation'] = $validator;
            $data['data'] = $user;
            $data['dataImage'] = $userImage;

            $tabQuery = $this->request->getVar('tab');
            $viewQuery = $this->request->getVar('view');
            $typeQuery = $this->request->getVar('type');

            if (is_null($tabQuery) || $tabQuery == 'account') {
                $data['js_custom'] = '<script src="/assets/js/custom/image_upload.js"></script>';

                return view('user/account', $data);
            } elseif ($tabQuery == 'password') {
                return view('user/password', $data);
            } elseif ($tabQuery == 'orders' && empty($viewQuery)) {
                $shopImplModel = new ShopImplModel();

                // Get currency from settings
                $currency = $this->settingImplModel->getCurrency();
                $shopImplModel->setCurrency($currency);

                $orders = $shopImplModel->listOrder($userId);

                $data['datas'] = $orders;

                return view('user/orders', $data);
            } elseif ($tabQuery == 'orders' && !empty($viewQuery)) {
                $shopImplModel = new ShopImplModel();

                // Get currency from settings
                $currency = $this->settingImplModel->getCurrency();
                $shopImplModel->setCurrency($currency);

                $order = $shopImplModel->retrieveOrder($userId, $viewQuery);

                if (is_null($order))
                    return view('user/user_null_error', $data);
                else {
                    $data['data'] = $order;
                    return view('user/order_view', $data);
                }
            } elseif ($tabQuery == 'address' && is_null($typeQuery)) {
                // Get All Countries
                $countries = FileLibrary::loadJson(APPPATH . 'Resources/countries_states.json');

                $data['js_custom'] = '<script src="/assets/js/custom/address.js"></script>';
                $data['countries'] = $countries;
                $data['dataBillingAddresses'] = $user->billingAddress;
                $data['dataShippingAddresses'] = $user->shippingAddress;

                return view('user/address', $data);
            } elseif ($tabQuery === 'address' && $typeQuery === 'billing') {
                $cipherQuery = $this->request->getVar('cipher');

                $num = SecurityLibrary::decryptUrlId($cipherQuery);
                $userImplModel = new UserImplModel();

                if ($userImplModel->deleteBillingAddress($num)) {
                    return redirect()->back()->with('success', 'Billing address deleted successfully!');
                } else {
                    return redirect()->back()->with('fail', 'Ooops user billing address was not deleted!');
                }
            } elseif ($tabQuery === 'address' && $typeQuery === 'shipping') {
                $cipherQuery = $this->request->getVar('cipher');

                $num = SecurityLibrary::decryptUrlId($cipherQuery);
                $userImplModel = new UserImplModel();

                if ($userImplModel->deleteShippingAddress($num)) {
                    return redirect()->back()->with('success', 'Shipping address deleted successfully!');
                } else {
                    return redirect()->back()->with('fail', 'Ooops user shipping address was not deleted!');
                }
            } else {
                throw PageNotFoundException::forPageNotFound();
            }




        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function saveUpdate()
    {
        try {
            if ($this->request->getVar('tab') === 'account') {
                $fieldValidation = array_merge(
                    $this->fieldFirstName,
                    $this->fieldLastName,
                    $this->fieldEmail,
                    $this->fieldMobile,
                    $this->fieldDescription
                );
                $validated = $this->validate($fieldValidation);

                if ($validated) {
                    $userImplModel = new UserImplModel();
                    $fileManagerImplModel = new FileManagerImplModel();

                    $firstName = $this->request->getPost('first_name');
                    $lastName = $this->request->getPost('last_name');
                    $email = $this->request->getPost('email');
                    $mobile = $this->request->getPost('mobile');
                    $file = $this->request->getFile('file');
                    $description = $this->request->getPost('description');
                    $userId = session()->get('userId');

                    // Update into user
                    $data = [
                        'UserFirstName' => $firstName,
                        'UserLastName' => $lastName,
                        'UserEmail' => $email,
                        'UserNumber' => $mobile,
                        'UserDescription' => $description
                    ];


                    // Insert into fileManager
                    $dataImage = [];
                    if ($file->isValid()) {
                        $publicId = $fileManagerImplModel->getFileManagerPrivateId();
                        $userFile = $fileManagerImplModel->retrieveUser($publicId);

                        $path = $userFile->path;
                        $privateId = $userFile->privateId;

                        $fileName = $file->getClientName();
                        $fileMimeType = $file->getMimeType();
                        $fileSize = $file->getSize();
                        $fileExtension = $file->guessExtension();
                        $lastModified = $file->getMTime();
                        $fileArray = [
                            'FilePublicId' => $privateId,
                            'FileIsDirectory' => false,
                            'FilePath' => $path . DIRECTORY_SEPARATOR . $fileName,
                            'FileUrlPath' => base_url($path . DIRECTORY_SEPARATOR . $fileName),
                            'FileParentPath' => $path,
                            'FileName' => $fileName,
                            'FileSize' => $fileSize,
                            'FileIsFavourite' => false,
                            'FileIsTrash' => false,
                            'FileIsShow' => true,
                            'FileMimeType' => $fileMimeType,
                            'FileExtension' => $fileExtension,
                            'FileLastModified' => $lastModified,
                        ];
                        $userImageFileId = $userImplModel->getUserImageFileFk($userId);
                        $fileId = $fileManagerImplModel->saveUpdateFile($userImageFileId, $fileArray);

                        $dataImage = [
                            'UserId' => $userId,
                            'UserImageFileFk' => $fileId,
                        ];
                    }

                    if ($userImplModel->update($userId, $data, $dataImage)) {
                        if (!empty($dataImage))
                            FileLibrary::moveFile($file, $path);
                        return redirect()->back()->with('success', 'Changes saved successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when saving changes!');
                    }
                } else {
                    return $this->index($this->validator);
                }
            } elseif ($this->request->getVar('tab') === 'address') {
                $fieldValidation = array_merge(
                    $this->fieldFirstName,
                    $this->fieldLastName,
                    $this->fieldEmail,
                    $this->fieldAddressOne,
                    $this->fieldMobile,
                    $this->fieldCity,
                    $this->fieldCountry,
                    $this->fieldPostalCode,
                    $this->fieldState,
                );
                $validated = $this->validate($fieldValidation);

                if ($validated) {
                    $userImplModel = new UserImplModel();

                    $firstName = $this->request->getPost('first_name');
                    $lastName = $this->request->getPost('last_name');
                    $email = $this->request->getPost('email');
                    $mobile = $this->request->getPost('mobile');
                    $city = $this->request->getPost('city');
                    $countryValue = $this->request->getPost('countries');
                    $stateValue = $this->request->getPost('states');
                    $postalCode = $this->request->getPost('postal_code');
                    $addressOne = $this->request->getPost('address_1');
                    $addressTwo = $this->request->getPost('address_2');
                    $userId = session()->get('userId');

                    // Get country name and code
                    $country = json_decode($countryValue);

                    // Get state name and code
                    $state = json_decode($stateValue);

                    $typeQuery = $this->request->getVar('type');
                    $methodQuery = $this->request->getVar('method');
                    $cipherQuery = $this->request->getVar('cipher');


                    if ($typeQuery === 'billing' && $methodQuery === 'create') {
                        // Insert into userBillingAddress
                        $data = [
                            'UserFirstName' => $firstName,
                            'UserLastName' => $lastName,
                            'UserEmail' => $email,
                            'UserNumber' => $mobile,
                            'UserAddressAddressOne' => $addressOne,
                            'UserAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                            'UserAddressPostalCode' => $postalCode,
                            'UserAddressCity' => $city,
                            'UserAddressStateName' => $state->name,
                            'UserAddressStateCode' => $state->code,
                            'UserAddressCountryName' => $country->name,
                            'UserAddressCountryCode' => $country->code,
                            'UserBillingAddressUserFk' => $userId,
                        ];

                        if ($userImplModel->storeBillingAddress($data)) {
                            return redirect()->back()->with('success', 'Billing address added successfully!');
                        } else {
                            return redirect()->back()->with('fail', 'An error occur when adding billing address!');
                        }
                    } elseif ($typeQuery === 'billing' && $methodQuery === 'update') {
                        $num = SecurityLibrary::decryptUrlId($cipherQuery);

                        // Update into userBillingAddress
                        $data = [
                            'UserFirstName' => $firstName,
                            'UserLastName' => $lastName,
                            'UserEmail' => $email,
                            'UserNumber' => $mobile,
                            'UserAddressAddressOne' => $addressOne,
                            'UserAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                            'UserAddressPostalCode' => $postalCode,
                            'UserAddressCity' => $city,
                            'UserAddressStateName' => $state->name,
                            'UserAddressStateCode' => $state->code,
                            'UserAddressCountryName' => $country->name,
                            'UserAddressCountryCode' => $country->code,
                            'UserBillingAddressUserFk' => $userId,
                        ];

                        if ($userImplModel->updateBillingAddress($num, $data)) {
                            return redirect()->back()->with('success', 'Billing address updated successfully!');
                        } else {
                            return redirect()->back()->with('fail', 'An error occur when updating billing address!');
                        }
                    } elseif ($typeQuery === 'shipping' && $methodQuery === 'create') {
                        // Insert into userShippingAddress
                        $data = [
                            'UserFirstName' => $firstName,
                            'UserLastName' => $lastName,
                            'UserEmail' => $email,
                            'UserNumber' => $mobile,
                            'UserAddressAddressOne' => $addressOne,
                            'UserAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                            'UserAddressPostalCode' => $postalCode,
                            'UserAddressCity' => $city,
                            'UserAddressStateName' => $state->name,
                            'UserAddressStateCode' => $state->code,
                            'UserAddressCountryName' => $country->name,
                            'UserAddressCountryCode' => $country->code,
                            'UserShippingAddressUserFk' => $userId,
                        ];

                        if ($userImplModel->storeShippingAddress($data)) {
                            return redirect()->back()->with('success', 'Shipping address added successfully!');
                        } else {
                            return redirect()->back()->with('fail', 'An error occur when adding shipping address!');
                        }
                    } elseif ($typeQuery === 'shipping' && $methodQuery === 'update') {
                        $num = SecurityLibrary::decryptUrlId($cipherQuery);

                        // Update into userShippingAddress
                        $data = [
                            'UserFirstName' => $firstName,
                            'UserLastName' => $lastName,
                            'UserEmail' => $email,
                            'UserNumber' => $mobile,
                            'UserAddressAddressOne' => $addressOne,
                            'UserAddressAddressTwo' => (empty($addressTwo)) ? null : $addressTwo,
                            'UserAddressPostalCode' => $postalCode,
                            'UserAddressCity' => $city,
                            'UserAddressStateName' => $state->name,
                            'UserAddressStateCode' => $state->code,
                            'UserAddressCountryName' => $country->name,
                            'UserAddressCountryCode' => $country->code,
                            'UserShippingAddressUserFk' => $userId,
                        ];

                        if ($userImplModel->updateShippingAddress($num, $data)) {
                            return redirect()->back()->with('success', 'Shipping address added successfully!');
                        } else {
                            return redirect()->back()->with('fail', 'An error occur when adding shipping address!');
                        }
                    }


                } else {
                    return redirect()->back()->with('fails', $this->validator->getErrors());
                }
            } elseif ($this->request->getVar('tab') === 'password') {
                $fieldValidation = array_merge(
                    $this->fieldNewPassword,
                    $this->fieldConfrimNewPassword,
                );
                $validated = $this->validate($fieldValidation);

                if ($validated) {
                    $userImplModel = new UserImplModel();
                    $securityLibrary = new SecurityLibrary();

                    $currentPassword = $this->request->getPost('current_password');
                    $confirmNewPassword = $this->request->getPost('confrim_new_password');
                    $userId = session()->get('userId');

                    // Get user
                    $user = $userImplModel->retrieve($userId);

                    // Get user_secret
                    $userSecret = $user->secret;

                    // Check password with hashed password
                    $dbPassword = $userSecret->password;
                    $dbSalt = $userSecret->salt;
                    $combinedCurrentPassword = $currentPassword . $dbSalt;
                    $checkPassword = $securityLibrary->check($combinedCurrentPassword, $dbPassword);

                    if ($checkPassword == false)
                        return redirect()->back()->with('fail', 'Current password is incorrect!');

                    // Salt new password
                    $salt = $securityLibrary->salt16();
                    $combinedPassword = $confirmNewPassword . $salt;

                    // Get hashed new password
                    $hashedPassword = $securityLibrary->encrypt($combinedPassword);

                    // Update into user_secret
                    $dataSecret = [
                        'UserSecretPassword' => $hashedPassword,
                        'UserSecretSalt' => $salt
                    ];

                    if ($userImplModel->updateSecret($userId, $dataSecret, false)) {
                        return redirect()->back()->with('success', 'Password updated successfully!');
                    } else {
                        return redirect()->back()->with('fail', 'An error occur when updating password!');
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
