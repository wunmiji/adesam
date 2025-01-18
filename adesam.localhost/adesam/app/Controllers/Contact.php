<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Libraries\EmailLibrary;
use Melbahja\Seo\MetaTags;


class Contact extends BaseController
{
    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 30'
            ]
        ]
    ];

    protected $fieldEmail = [
        'email' => [
            'rules' => 'required|valid_email|max_length[70]',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Valid Email is  required',
                'max_length' => 'Max length for name is 70'
            ]
        ],
    ];

    protected $fieldMessage = [
        'message' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Message is required'
            ]
        ]
    ];

    protected $fieldSubject = [
        'subject' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required' => 'Subject is required',
                'max_length' => 'Max length for subject is 100'
            ]
        ]
    ];




    public function index($validator = null)
    {
        try {
            $metatags = new MetaTags();

            $getInTouch = $this->settingImplModel->listGetInTouch();
            $this->information = array_merge($this->information, $getInTouch);

            $metatags->title('Contact Us' . $this->metaTitle)
                ->description('Get in touch. ' . $this->information['mobile'])
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Contact us, Get in touch,' . $this->information['mobile']);

            $data['metatags'] = $metatags;
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/form.css">';
            $data['validation'] = $validator;
            $data['information'] = $this->information;

            return view('contact/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }


    public function send()
    {
        try {
            $fieldValidation = array_merge(
                $this->fieldName,
                $this->fieldSubject,
                $this->fieldMessage,
                $this->fieldEmail
            );
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $emailLibrary = new EmailLibrary();

                $name = $this->request->getVar('name');
                $email = $this->request->getVar('email');
                $subject = $this->request->getVar('subject');
                $message = $this->request->getVar('message');

                $html = view_cell('\App\Cells\EmailCell::contactForm', ['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);

                $emailLibrary->setFrom($email, 'Adesam Contact Page');
                $emailLibrary->setTo('wunmiji@gmail.com');
                $emailLibrary->setSubject($subject);
                $emailLibrary->setMessage($html);
                $emailLibrary->send();


                if ($emailLibrary->send())
                    return redirect()->back()->with('success', 'Message has been sent successfully!');
                else
                    return redirect()->back()->with('fail', 'Message not sent');
            } else {
                return $this->index($this->validator);
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
