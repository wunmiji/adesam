<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;


class Terms extends BaseController
{

    public function index() 
    {
        try {
            $metatags = new MetaTags();

            $getInTouch = $this->settingImplModel->listGetInTouch();
            $this->information = array_merge($this->information, $getInTouch);

            $metatags->title('Terms' . $this->metaTitle)
                ->description('Our terms')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['title'] = 'Terms';
            $data['description'] = 'Our terms';
            $data['keywords'] = 'Terms';
            $data['information'] = $this->information;

            return view('terms/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
