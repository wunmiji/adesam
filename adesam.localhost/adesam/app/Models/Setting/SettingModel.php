<?php

namespace App\Models\Setting;

use CodeIgniter\Model;

class SettingModel extends Model
{

    protected $table = 'settings';
    protected $primaryKey = 'SettingId';
    protected $allowedFields = [
        'SettingId',
        'SettingCategory',
        'SettingKey',
        'SettingValue'
    ];

    // SQL
    protected $sqlIdContact = 'SELECT SettingId AS Id FROM settings WHERE SettingCategory = :category: AND SettingKey = :key:';
    protected $sqlCurrency = 'SELECT SettingValue AS Currency FROM settings WHERE SettingCategory = "SHOP" AND SettingKey = "currency"';
    protected $sqlTimezone = 'SELECT SettingValue AS Timezone FROM settings WHERE SettingCategory = "GENERAL" AND SettingKey = "timezone"';
    protected $sqlShippingPrice = 'SELECT SettingValue AS ShippingPrice FROM settings WHERE SettingCategory = "SHOP" AND SettingKey = "shipping-price"';
    protected $sqlSetting = 'SELECT
                                SettingId,
                                SettingCategory,
                                SettingKey,
                                SettingValue
                            FROM
                                settings
                            WHERE 
                                SettingCategory = :category:';
    protected $sqlSocialMedia = 'SELECT
                                    SettingKey,
                                    SettingValue
                                FROM
                                    settings
                                WHERE 
                                    SettingCategory = "CONTACT"
                                    AND
                                    SettingKey IN ("facebook", "instagram", "linkedIn", "twitter", "youtube")';

    protected $sqlGetInTouch = 'SELECT
                                    SettingKey,
                                    SettingValue
                                FROM
                                    settings
                                WHERE 
                                    SettingCategory = "CONTACT"
                                    AND
                                    SettingKey IN ("email", "mobile")';


}
