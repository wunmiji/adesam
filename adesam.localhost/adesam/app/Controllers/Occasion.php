<?php

namespace App\Controllers;


use \CodeIgniter\Exceptions\PageNotFoundException;

use \App\ImplModel\OccasionImplModel;
use \App\ImplModel\TagImplModel;
use App\Libraries\UuidLibrary;
use App\Enums\TagType;

use Melbahja\Seo\MetaTags;


class Occasion extends BaseController
{

    public function index()
    {
        try {
            $occasionImplModel = new OccasionImplModel();
            $metatags = new MetaTags();

            $metatags->title('Occasions' . $this->metaTitle)
                ->description('View all our occasion')
                ->meta('author', $this->metaAuthor);


            $queryPage = $this->request->getVar('page');
            $queryLimit = 3;
            if (is_null($queryPage)) {
                $pagination = $occasionImplModel->pagination(1, $queryLimit);

                $data['metatags'] = $metatags;
                $data['datas'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];
                $data['baseUrl'] = 'occasions?page=';
                $data['information'] = $this->information;

                return view('occasion/index', $data);
            } else {
                $pagination = $occasionImplModel->pagination($queryPage, $queryLimit);

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

    public function tags()
    {
        try {
            $tagImplModel = new TagImplModel();
            $metatags = new MetaTags();

            $metatags->title('Tags' . $this->metaTitle)
                ->description('Shop Tags')
                ->meta('author', $this->metaAuthor);


            // Get all tags
            $tags = $tagImplModel->listOccasion();

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['datas'] = $tags;

            return view('occasion/tags', $data);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function tagList(string $slug)
    {
        try {
            $occasionImplModel = new OccasionImplModel();
            $tagImplModel = new TagImplModel();
            $metatags = new MetaTags();

            // Get tag
            $tag = $tagImplModel->retrieve($slug, TagType::OCCASION->name);

            $queryPage = $this->request->getVar('page');
            $queryLimit = 3;
            if (is_null($queryPage)) {
                $pagination = $occasionImplModel->paginationTags(1, $queryLimit, $slug);

                $data['metatags'] = $metatags;
                $data['datas'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];
                $data['baseUrl'] = 'occasions/tags?page=';
                $data['information'] = $this->information;
                $data['tag'] = $tag;

                return view('occasion/tag_list', $data);
            } else {
                $pagination = $occasionImplModel->paginationTags($queryPage, $queryLimit, $slug);

                $data['datas'] = $pagination['list'];
                $data['arrayPageCount'] = $pagination['arrayPageCount'];
                $data['index'] = $pagination['next'];

                return view('include/load_occasions', $data);
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function details($slug)
    {
        try {
            $occasionImplModel = new OccasionImplModel();
            $metatags = new MetaTags();

            if ($this->request->isAJAX()) {
                $uuid = $this->request->getVar('uuid');
                $comments = $occasionImplModel->occasionCommets($slug, $uuid);
                return json_encode($comments);
            }

            $occasion = $occasionImplModel->retrieve($slug);
            $image = $occasion->image;
            $text = $occasion->text;
            $author = $occasion->author;
            $tags = $occasion->tags;
            $medias = $occasion->medias;

            $metatags->title('Occasion' . $this->metaTitle)
                ->description($occasion->summary)
                ->meta('author', $this->metaAuthor)
                ->image($occasion->image->fileSrc);

            $data['metatags'] = $metatags;
            $data['information'] = $this->information;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/toastr.min.css">';
            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/content-text.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/form.css">' .
                '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_library'] = '<script src="/assets/js/library/toastr.min.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/comment.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>';
            $data['data'] = $occasion;
            $data['dataImage'] = $image;
            $data['dataText'] = $text;
            $data['dataAuthor'] = $author;
            $data['dataTags'] = $tags;
            $data['dataMedias'] = $medias;
            $data['uuid'] = UuidLibrary::versionFive($slug);


            return view('occasion/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function comments($slug)
    {
        try {
            if ($this->request->isAJAX()) {
                $occasionImplModel = new OccasionImplModel();

                $comments = $this->request->getPost('comments');
                $parentId = $this->request->getPost('parentId');
                $userId = session()->get('userId');

                // Get occasionId
                $occasionId = $occasionImplModel->getId($slug);

                // Insert into occasionComments
                $data = [
                    'OccasionCommentsOccasionFk' => $occasionId,
                    'OccasionCommentsUserFk' => $userId,
                    'OccasionCommentsParentId' => $parentId,
                    'OccasionCommentsComment' => $comments,
                    'OccasionCommentsIsDeleted' => false,
                ];

                if ($occasionImplModel->saveComments($data))
                    return json_encode(true);
                else
                    return json_encode(false);
                ;
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            //die;
        }
    }

    public function removeComment(string $slug, string $uuid)
    {
        try {
            $occasionImplModel = new OccasionImplModel();


            if ($this->request->isAJAX()) {
                // Get commentId
                $commentId = $occasionImplModel->getCommentId($uuid);

                $result = $occasionImplModel->removeComment($commentId);
                if ($result === true) {
                    return json_encode(true);
                } else {
                    return json_encode(false);
                }
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }



}
