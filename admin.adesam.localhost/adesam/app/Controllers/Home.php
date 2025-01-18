<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\FamilyImplModel;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\PasswordLibrary;
use App\Enums\SettingType;


class Home extends BaseController
{
    public function __construct()
    {
    }

    public function index($validator = null)
    {
        try {
            $fileManagerImplModel = new FileManagerImplModel();
            $settingImplModel = new SettingImplModel();

            $data['title'] = 'Login';
            $data['validation'] = $validator;

            // Set default settings
            $settingImplModel->defaultSettings();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            // Set Places for file
            $fileManagerImplModel->createPlaces();

            return view('home/index', $data);
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
                        'valid_email' => 'Email is not valid'
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
                //return view('index', ['validation' => $this->validator]);
                return $this->index($this->validator);
            } else {
                $familyImplModel = new FamilyImplModel();
                $settingImplModel = new SettingImplModel();

                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');

                $familyId = $familyImplModel->getIdByEmail($email);

                if (!is_null($familyId)) {
                    $family = $familyImplModel->retrieve($familyId);

                    // Get family_image
                    $familyImage = $family->image;

                    // Set all of family
                    $familySecret = $family->secret;

                    // Check password with hashed password
                    $passwordLibrary = new PasswordLibrary();


                    $dbPassword = $familySecret->password;
                    $dbSalt = $familySecret->salt;
                    $combinedPassword = $password . $dbSalt;
                    $checkPassword = $passwordLibrary->check($combinedPassword, $dbPassword);

                    if ($checkPassword) {
                        session()->set('familyId', $familyId);
                        session()->set('familyName', $family->firstName . ' ' . $family->lastName);
                        session()->set('familyRole', $family->role);
                        if (is_null($familyImage)) {
                            session()->set('familyImage', '/assets/images/avatar-family.png');
                            session()->set('familyImageAlt', 'Image not set avatar used');
                        } else {
                            session()->set('familyImage', $familyImage->fileSrc);
                            session()->set('familyImageAlt', $familyImage->fileName);
                        }
                        session()->set('familyKey', bin2hex(random_bytes(16)));

                        // Set developer from settings
                        $developer = $settingImplModel->list('DEVELOPER');
                        session()->set('developerHref', $developer->href->value);
                        session()->set('developerName', $developer->name->value);

                        return redirect()->route('dashboard');
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


}
