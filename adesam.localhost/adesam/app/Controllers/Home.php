<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\ImplModel\UserImplModel;
use \App\ImplModel\OccasionImplModel;
use \App\ImplModel\FileManagerImplModel;
use \App\Libraries\FileLibrary;

use Josantonius\Cookie\Facades\Cookie;
use Melbahja\Seo\MetaTags;
use Melbahja\Seo\Schema;
use Melbahja\Seo\Schema\Thing;

class Home extends BaseController
{
    public function index()
    {
        try {
            $occasionImplModel = new OccasionImplModel();
            $metatags = new MetaTags();

            //$fileManagerImplModel->createUserFolder();
            $this->createPlace('Users', 'Users', false);
            $occasions = $occasionImplModel->list(0, 5);

            $metatags->title('Home' . $this->metaTitle)
                ->description('View recent occasions')
                ->meta('author', $this->metaAuthor)
                ->meta('keywords', 'Celestial, Celestial Family, Obanowah, Obanowah Family, Adesam')
                ->image(base_url('assets/images/background-image-1.jpg'));
            $sameAsArray = [
                $this->information['facebook'] ?? null,
                $this->information['instagram'] ?? null,
                $this->information['linkedIn'] ?? null,
                $this->information['twitter'] ?? null,
                $this->information['youtube'] ?? null,
            ];
            $schema = new Schema(
                new Thing('Organization', [
                    'url' => base_url(),
                    'name' => $this->information['name'],
                    'foundingDate' => $this->information['founded'],
                    'logo' => base_url('assets/brand/logo.svg'),
                    'description' => 'Adesam Family',
                    'sameAs' => array_filter($sameAsArray), // remove null from array
                ])
            );

            $data['metatags'] = $metatags;
            $data['schema'] = $schema;
            $data['information'] = $this->information;
            $data['css_library'] = '<link rel="stylesheet" href="/assets/css/library/swiper-bundle.min.css">';
            $data['js_library'] = '<script src="/assets/js/library/swiper-bundle.min.js"></script>';
            $data['js_custom'] = '<script src="/assets/js/custom/swiper.js"></script>';
            $data['datas'] = $occasions;

            return view('home/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }

    }

    public function logout()
    {
        $userImplModel = new UserImplModel();

        if (session()->has('userId')) {
            // delete the user cookie
            $userImplModel->deleteCookie(session()->get('userId'));

            session()->remove('userId');
        }

        if (Cookie::has('remember_me')) {
            Cookie::remove('remember_me');
        }

        // remove all session data
        session()->destroy();
        return redirect()->route('/');
    }

    private function createPlace(string $name, string $description, bool $isShow)
    {
        try {
            $fileManagerImplModel = new FileManagerImplModel();

            $publicId = $fileManagerImplModel->getFileManagerPrivateId();

            if (is_null($fileManagerImplModel->getFileIdUsingPublicIdName($publicId, $name))) {
                $folder = FileLibrary::$dir . $name;
                $data = [
                    'FilePublicId' => $publicId,
                    'FileName' => $name,
                    'FileIsShow' => $isShow,
                    'FileIsDirectory' => true,
                    'FileParentPath' => FileLibrary::$dir,
                    'FileDescription' => $description,
                    'FileIsTrash' => false,
                    'FilePath' => $folder,
                ];

                if ($fileManagerImplModel->saveFolder($data)) {
                    FileLibrary::createFolder($folder);
                } else
                    return redirect()->back()->with('fail', 'An error occur when adding' . $name . 'folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }


}
