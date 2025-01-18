<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\UserImplModel;
use App\Libraries\EmailLibrary;

use Melbahja\Seo\MetaTags;


class ForgetPassword extends BaseController
{
    public function __construct()
    {
    }


    public function index($validator = null)
    {
        try {
            $metatags = new MetaTags(); 


            $metatags->title('Forget Password' . $this->metaTitle)
                ->description('Adesam forget password')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['title'] = 'Forget Password';
            $data['css_custom'] = '<link href="/assets/css/custom/form.css" rel="stylesheet" />';
            $data['information'] = $this->information;
            $data['validation'] = $validator;

            return view('forget_password/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function send()
    {
        try {
            $validated = $this->validate([
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is not valid'
                    ]
                ]
            ]);

            if (!$validated) {
                return $this->index($this->validator);
            } else {
                $userImplModel = new UserImplModel();
                $emailLibrary = new EmailLibrary();

                $email = $this->request->getVar('email');

                $userId = $userImplModel->getIdByEmail($email);

                if (!is_null($userId)) {
                    $user = $userImplModel->retrieve($userId);

                    $token = bin2hex(random_bytes(16));
                    $tokenHash = hash("sha256", $token);
                    $minutes = 15;
                    $expiry = date("Y-m-d  H:i:s", time() + 60 * $minutes);

                    $dataSecretReset = [
                        'UserId' => $userId,
                        'UserSecretResetToken' => $tokenHash,
                        'UserSecretExpiresAt' => $expiry,
                    ];

                    $userImplModel->saveSecretReset($userId, $dataSecretReset);

                    $dataCell = [
                        'name' => $user->firstName . ' ' . $user->lastName,
                        'token' => $token,
                        'minutes' => $minutes
                    ];
                    $html = view_cell('\App\Cells\EmailCell::passwordReset', $dataCell);

                    $emailLibrary->setFrom('madewunmi31@outlook.com');
                    $emailLibrary->setTo($email);
                    $emailLibrary->setSubject('Password Reset');
                    $emailLibrary->setMessage($html);

                    if ($emailLibrary->send()) {
                        return redirect()->back()->with('success', 'Password reset link sent successfully!');
                    } else
                        return redirect()->back()->with('fail', 'Password Reset not sent');
                }

            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

}
