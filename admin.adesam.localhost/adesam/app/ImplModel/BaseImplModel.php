<?php

namespace App\ImplModel;


use App\Libraries\MoneyLibrary;


/**
 * 
 */

class BaseImplModel
{

    private $createdId;
    private $currency;
    private $fileManagerPrivateId;


    public function setCreatedId($createdId) {
        $this->createdId = $createdId;
    }

    public function getCreatedId() {
        return $this->createdId;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setFileManagerPrivateId($fileManagerPrivateId) {
        $this->fileManagerPrivateId = $fileManagerPrivateId;
    }

    public function getFileManagerPrivateId() {
        return $this->fileManagerPrivateId;
    }



    // Other
    public function stringCurrency(float $amount)
    {
        return MoneyLibrary::format($amount, $this->getCurrency());
    }



}