<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if user is logged in
        if (session()->get('userId')) {
            // then redirct to dashboard page
            return redirect()->route('/');
        } 

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}