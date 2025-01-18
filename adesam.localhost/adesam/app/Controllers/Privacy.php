<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;


class Privacy extends BaseController
{

    public function index()
    {
        try {
            $metatags = new MetaTags();

            $getInTouch = $this->settingImplModel->listGetInTouch();
            $this->information = array_merge($this->information, $getInTouch);

            $metatags->title('Privacy' . $this->metaTitle)
                ->description('Our policy')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;

            return view('privacy/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
