<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\ImplModel\SettingImplModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];
    protected $metaTitle = ' | Adesam';
    protected $metaAuthor = 'Adesam';
    protected $information = [
        'name' => 'Adesam',
        'website' => 'https://www.adesam.com',
        'founded' => 2024,
    ];
    protected $settingImplModel;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        // Settings Instantiate
        $this->settingImplModel = new SettingImplModel();

        // Set default timezone
        $timezone = $this->settingImplModel->getTimezone();
        date_default_timezone_set($timezone);

        // Set developer
        $developer = $this->settingImplModel->list('DEVELOPER');
        $developerArray = [
            'developer-href' => $developer->href->value,
            'developer-name' => $developer->name->value
        ];
        $this->information = array_merge($this->information, $developerArray);


        // Get socialMedia from settings
        $socialMedia = $this->settingImplModel->listSocialMedia();
        $this->information = array_merge($this->information, $socialMedia);

    }
}
