<?php

namespace App\ImplModel;


use App\Enums\SettingType;
use App\Models\Setting\SettingModel;
use App\Entities\Setting\SettingEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class SettingImplModel
{


    public function list(string $type)
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlSetting, [
            'category' => $type
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new SettingEntity(
                $value['SettingId'] ?? null,
                $value['SettingCategory'],
                $value['SettingKey'],
                $value['SettingValue'],
            );
            $output[$value['SettingKey']] = $entity;
        }

        return json_decode(json_encode($output));
    }

    public function listSocialMedia()
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlSocialMedia);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $value) {
            $output[$value['SettingKey']] = $value['SettingValue'];
        }

        return $output;
    }

    public function listGetInTouch()
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlGetInTouch);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $value) {
            $output[$value['SettingKey']] = $value['SettingValue'];
        }

        return $output;
    }



    // Other
    public function getTimezone()
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlTimezone);

        return $query->getRow()->{'Timezone'};
    }
    
    public function getCurrency()
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlCurrency);

        $row = $query->getRow();
        return (is_null($row)) ? 'NGN' : $row->{'Currency'};
    }

    public function getShippingPrice()
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlShippingPrice);

        $row = $query->getRow();
        return (is_null($row)) ? 'NGN' : $row->{'ShippingPrice'};
    }
}