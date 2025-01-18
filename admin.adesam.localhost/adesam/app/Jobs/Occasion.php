<?php

namespace App\Jobs;

use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;
use App\ImplModel\OccasionImplModel;


class Occasion extends BaseJob implements JobInterface
{
    public function process()
    {
        $occasionImplModel = new OccasionImplModel();

        $result = $occasionImplModel->updatePublishedDate($this->data['id'], $this->data['published_date']);
        
        return $result;
    }
}
