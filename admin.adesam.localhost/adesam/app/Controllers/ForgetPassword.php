<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;


use App\ImplModel\FamilyImplModel;
use App\Libraries\EmailLibrary;


class ForgetPassword extends BaseController
{
    public function __construct()
    {
    }

    public function index($validator = null)
    {
        try {
            $data['title'] = 'Forget Password';
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
                $familyImplModel = new FamilyImplModel();
                $emailLibrary = new EmailLibrary();

                $email = $this->request->getVar('email');

                $familyId = $familyImplModel->getIdByEmail($email);

                if (!is_null($familyId)) {
                    $family = $familyImplModel->retrieve($familyId);

                    $token = bin2hex(random_bytes(16));
                    $tokenHash = hash("sha256", $token);
                    $minutes = 5;
                    $expiry = date("Y-m-d  H:i:s", time() + 60 * $minutes);

                    $dataSecretReset = [
                        'FamilyId' => $familyId,
                        'FamilySecretResetToken' => $tokenHash,
                        'FamilySecretExpiresAt' => $expiry,
                    ];

                    $familyImplModel->saveSecretReset($familyId, $dataSecretReset);


                    $dataCell = [
                        'name' => $family->firstName . ' ' . $family->lastName,
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
                    } else return redirect()->back()->with('fail', 'Password Reset not sent');
                }

            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

}
