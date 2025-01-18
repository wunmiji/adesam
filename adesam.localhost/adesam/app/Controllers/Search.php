<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use \App\ImplModel\OccasionImplModel;

use Melbahja\Seo\MetaTags;


class Search extends BaseController
{

    public function index()
    {
        try {
            $occasionImplModel = new OccasionImplModel();
            $metatags = new MetaTags();

            $metatags->title('Search' . $this->metaTitle)
                ->description('Adesam occasion search')
                ->meta('author', $this->metaAuthor);

            $querySearch = $this->request->getVar('q');
            $queryPage = $this->request->getVar('page');
            $queryLimit = 3;

            if (is_null($queryPage)) {
                $pagination = $occasionImplModel->paginationSearch(1, $queryLimit, $querySearch);

                $data['metatags'] = $metatags;
                $data['datas'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];
                $data['search'] = $pagination['search'];
                $data['baseUrl'] = 'search?q=' . $querySearch . '&page=';
                $data['searchText'] = $querySearch;
                $data['information'] = $this->information;

                return view('search/index', $data);
            } else {
                $pagination = $occasionImplModel->paginationSearch($queryPage, $queryLimit, $querySearch);

                $data['datas'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];

                return view('include/load_occasions', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }




}
