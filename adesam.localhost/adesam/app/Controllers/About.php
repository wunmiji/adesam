<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use Melbahja\Seo\MetaTags;


class About extends BaseController
{

    public function index()
    {
        try {
            $metatags = new MetaTags();

            $metatags->title('About' . $this->metaTitle)
                ->description('Adesam family.')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;

            return view('about/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
