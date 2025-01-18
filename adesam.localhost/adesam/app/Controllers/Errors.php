<?php

namespace App\Controllers;


use Melbahja\Seo\MetaTags;

class Errors extends BaseController
{

    public function show404()
    {
        try {
            // Set 404 status code
            $this->response->setStatusCode(404);

            $metatags = new MetaTags();

            $metatags->title('Page not found' . $this->metaTitle)
                ->description('Page cannot be found')
                ->meta('author', $this->metaAuthor);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;


            return view('error_404', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
        }
    }




}
