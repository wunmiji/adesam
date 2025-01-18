<?php

namespace App\Jobs;


use Exception;
use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;

class Email extends BaseJob implements JobInterface
{
    public function process()
    {
        $email  = service('email', null, false);
        $result = $email
            ->setTo('wunmiji@gmail.com')
            ->setSubject('My test email')
            ->setMessage($this->data['message'])
            ->send(false);

        if (! $result) {
            throw new Exception($email->printDebugger('headers'));
        }

        return $result;
    }
}
