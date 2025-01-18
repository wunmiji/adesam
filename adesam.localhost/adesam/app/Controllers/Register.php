<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\UserImplModel;
use App\Libraries\SecurityLibrary;

use Melbahja\Seo\MetaTags;


class Register extends BaseController
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

    protected $fieldLastName = [
        'last_name' => [
            'rules' => 'required|max_length[15]',
            'errors' => [
                'required' => 'Your last name is required',
                'max_length' => 'Max length for last name is 15'
            ]
        ],
    ];

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Your email is required',
                'valid_email' => 'Email is not valid'
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


    public function __construct()
    {
    }

    public function index($validator = null)
    {
        try {
            $metatags = new MetaTags();


            $metatags->title('Register' . $this->metaTitle)
                ->description('Adesam register')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['title'] = 'Register';
            $data['css_custom'] = '<link href="/assets/css/custom/form.css" rel="stylesheet" />';
            $data['information'] = $this->information;
            $data['validation'] = $validator;

            return view('register/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function register()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldFirstName,
                $this->fieldLastName,
                $this->fieldEmail,
                $this->fieldNewPassword,
                $this->fieldConfrimNewPassword,
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $userImplModel = new UserImplModel();
                $securityLibrary = new SecurityLibrary();

                $firstName = $this->request->getPost('first_name');
                $lastName = $this->request->getPost('last_name');
                $email = $this->request->getPost('email');
                $confirmNewPassword = $this->request->getPost('confrim_new_password');

                // Insert into family
                $data = [
                    'UserFirstName' => $firstName,
                    'UserLastName' => $lastName,
                    'UserEmail' => $email,
                ];

                // Insert into family_secret
                $salt = $securityLibrary->salt16();
                $combinedPassword = $confirmNewPassword . $salt;
                // Get hashed password
                $hashedPassword = $securityLibrary->encrypt($combinedPassword);
                $dataSecret = [
                    'UserSecretPassword' => $hashedPassword,
                    'UserSecretSalt' => $salt
                ];

                if ($userImplModel->store($data, $dataSecret)) {
                    return redirect()->back()->with('success', 'Account created successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when creating account!');
                }

            } else
                return $this->index($this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


}
