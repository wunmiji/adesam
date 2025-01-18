<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\FamilyImplModel;
use App\Libraries\SecurityLibrary;

class ResetPassword extends BaseController
{
    public function __construct()
    {
    }


    public function index($validator = null)
    {
        try {
            $data['title'] = 'Reset Password';
            $data['validation'] = $validator;
            $data['token'] = $this->request->getGet('token');

            return view('reset_password/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function send()
    {
        try {
            $validated = $this->validate([
                'new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]',
                    'errors' => [
                        'required' => 'Your new password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters'
                    ]
                ],
                'confrim_new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]|matches[new_password]',
                    'errors' => [
                        'required' => 'Your confirm new password is required',
                        'min_length' => 'Password must be 5 characters long',
                        'max_length' => 'Password cannot be longer than 20 characters',
                        'matches' => 'Your new passwords do not match'
                    ]
                ]
            ]);

            if (!$validated) {
                return $this->index($this->validator);
            } else {
                $familyImplModel = new FamilyImplModel();
                $securityLibrary = new SecurityLibrary();

                $confirmNewPassword = $this->request->getPost('confrim_new_password');
                $token = $this->request->getPost('tokenHidden');

                $tokenHash = hash("sha256", $token);
                $familySecretReset = $familyImplModel->familySecretReset($tokenHash);

                if (is_null($familySecretReset))
                    return redirect()->back()->with('fail', 'Token not found!');
                if (strtotime($familySecretReset->expiresAt) <= time())
                    return redirect()->back()->with('fail', 'Token has expired!');

                $salt = $securityLibrary->salt16();
                $combinedPassword = $confirmNewPassword . $salt;

                // Get hashed password
                $hashedPassword = $securityLibrary->encrypt($combinedPassword);

                // Update into family_secret
                $dataSecret = [
                    'FamilySecretPassword' => $hashedPassword,
                    'FamilySecretSalt' => $salt
                ];

                $result = $familyImplModel->updateSecret($familySecretReset->id, $dataSecret, true);
                if ($result === true) {
                    return redirect()->back()->with('success', 'Your password updated successfully!');
                } else {
                    return redirect()->back()->with('fail', 'An error occur when updating your password!');
                }
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
