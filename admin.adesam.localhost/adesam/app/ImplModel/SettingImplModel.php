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

    public function insert($data)
    {
        try {
            $settingModel = new SettingModel();

            $settingModel->transException(true)->transStart();

            // Insert into settings
            $settingModel->insert($data);

            $settingModel->transComplete();

            if ($settingModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e->getCode());
            d($e);
            die;
        }
    }

    public function update($datas)
    {
        try {
            $settingModel = new SettingModel();

            $settingModel->transException(true)->transStart();

            // Update into settings
            foreach ($datas as $data) {
                $id = $this->getIdContact($data['SettingCategory'], $data['SettingKey']);
                $settingModel->update($id, $data);
            }

            $settingModel->transComplete();

            if ($settingModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e->getCode());
            d($e);
            die;
        }
    }

    public function delete(int $num)
    {
        try {
            $settingModel = new SettingModel();

            $settingModel->transException(true)->transStart();

            $query = $settingModel->query($settingModel->sqlDelete, [
                'settingId' => $num,
            ]);

            $affected_rows = $settingModel->affectedRows();

            $settingModel->transComplete();
            if ($affected_rows >= 1 && $settingModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function defaultSettings () {
        $this->defaultSetting(SettingType::GENERAL->name, 'timezone', 'Africa/Lagos');
        $this->defaultSetting(SettingType::CONTACT->name, 'email', 'adesam@gmail.com');
        $this->defaultSetting(SettingType::CONTACT->name, 'mobile', '09060112757');
        $this->defaultSetting(SettingType::CONTACT->name, 'facebook', null);
        $this->defaultSetting(SettingType::CONTACT->name, 'instagram', 'https://www.instagram.com/wunmiji/');
        $this->defaultSetting(SettingType::CONTACT->name, 'linkedIn', 'https://www.linkedin.com/in/omobolaji-adewunmi-521a56257/');
        $this->defaultSetting(SettingType::CONTACT->name, 'twitter', null);
        $this->defaultSetting(SettingType::CONTACT->name, 'youtube', null);
        $this->defaultSetting(SettingType::SHOP->name, 'shipping-price', '500');
        $this->defaultSetting(SettingType::SHOP->name, 'currency', 'NGN');
        $this->defaultSetting(SettingType::FILE->name, 'namespace', '9597c04a-10cb-11ef-b01a-a0d3c198cfa0');
        $this->defaultSetting(SettingType::FILE->name, 'first_public_id', '4c0c7bf3-686f-5b42-8098-7554aa90f346');
        $this->defaultSetting(SettingType::DEVELOPER->name, 'name', 'Adewunmi Omobolaji Micheal');
        $this->defaultSetting(SettingType::DEVELOPER->name, 'href', 'https://twitter.com/OmobolajiA74010');
        $this->defaultSetting(SettingType::CALENDAR->name, 'first-day', 0);
    }





    // Other
    public function getIdContact(string $category, string $key)
    {
        $settingModel = new SettingModel();
        $query = $settingModel->query($settingModel->sqlIdContact, [
            'category' => $category,
            'key' => $key
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

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

    private function defaultSetting(string $category, string $key, ?string $value)
    {

        if (is_null($this->getIdContact($category, $key))) {
            $data = [
                'SettingCategory' => $category,
                'SettingKey' => $key,
                'SettingValue' => $value,
            ];

            $this->insert($data);
        }
    }
}