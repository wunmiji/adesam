<?php

namespace App\ImplModel;


use App\Enums\Gender;
use App\Models\User\UserModel;
use App\Models\User\UserImageModel;
use App\Models\User\UserSecretModel;
use App\Models\User\UserSecretResetModel;
use App\Models\User\UserCookieModel;
use App\Models\User\UserBillingAddressModel;
use App\Models\User\UserShippingAddressModel;
use App\Libraries\DateLibrary;
use App\Entities\User\UserEntity;
use App\Entities\User\UserImageEntity;
use App\Entities\User\UserAddressEntity;
use App\Entities\User\UserSecretEntity;
use App\Entities\User\UserCookieEntity;
use App\Entities\User\UserSecretResetEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class UserImplModel
{

    public function retrieve(int $num)
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlUser, [
            'userId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->user($row);
        }
    }

    public function user($value)
    {
        return new UserEntity(
            $value['UserId'] ?? null,
            $value['UserFirstName'] . ' ' . $value['UserLastName'],
            $value['UserFirstName'] ?? null,
            $value['UserLastName'] ?? null,
            $value['UserEmail'] ?? null,
            $value['UserNumber'] ?? null,
            $value['UserDescription'] ?? null,

            DateLibrary::getFormat($value['CreatedDateTime '] ?? null),
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->userImage($value['UserId']) ?? null,
            $this->userSecret($value['UserId'] ?? null),
            $this->userBillingAddresses($value['UserId']),
            $this->userShippingAddresses($value['UserId']),
        );

    }

    public function userImage(int $num)
    {
        $userImageModel = new UserImageModel();
        $query = $userImageModel->query($userImageModel->sqlFile, [
            'userId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            $entity = new UserImageEntity(
                $num,
                $row['FileId'] ?? null,
                $row['FileUrlPath'],
                $row['FileName'] ?? null,
            );

            return $entity;
        }

    }

    public function userCookie(string $selector)
    {
        $userCookieModel = new UserCookieModel();
        $query = $userCookieModel->query($userCookieModel->sqlCookie, [
            'userCookieSelector' => $selector
        ]);

        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return new UserCookieEntity(
                $row['Id'] ?? null,
                $row['UserCookieUserFk'] ?? null,
                $row['UserCookieSelector'] ?? null,
                $row['UserCookieHashedValidator'] ?? null,
                $row['UserCookieExpires'] ?? null,

            );
        }

    }

    public function userBillingAddresses(int $num)
    {
        $userBillingAddressModel = new UserBillingAddressModel();
        $query = $userBillingAddressModel->query($userBillingAddressModel->sqlAddress, [
            'userId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new UserAddressEntity(
                $row['Id'] ?? null,
                $row['UserId'] ?? null,
                $row['UserFirstName'] ?? null,
                $row['UserLastName'] ?? null,
                $row['UserName'] ?? null,
                $row['UserEmail'] ?? null,
                $row['UserNumber'] ?? null,
                $row['UserAddressAddressOne'] ?? null,
                $row['UserAddressAddressTwo'] ?? null,
                $row['UserAddressCity'] ?? null,
                $row['UserAddressPostalCode'] ?? null,
                $row['UserAddressStateName'] ?? null,
                $row['UserAddressStateCode'] ?? null,
                $row['UserAddressCountryName'] ?? null,
                $row['UserAddressCountryCode'] ?? null,

                DateLibrary::getFormat($row['CreatedDateTime '] ?? null),
            );

            $arr[$row['Id']] = $entity;
        }

        return $arr;
    }

    public function userShippingAddresses(int $num)
    {
        $userShippingAddressModel = new UserShippingAddressModel();
        $query = $userShippingAddressModel->query($userShippingAddressModel->sqlAddress, [
            'userId' => $num
        ]);

        $rows = $query->getResultArray();

        $arr = array();
        foreach ($rows as $key => $row) {
            $entity = new UserAddressEntity(
                $row['Id'] ?? null,
                $row['UserId'] ?? null,
                $row['UserFirstName'] ?? null,
                $row['UserLastName'] ?? null,
                $row['UserName'] ?? null,
                $row['UserEmail'] ?? null,
                $row['UserNumber'] ?? null,
                $row['UserAddressAddressOne'] ?? null,
                $row['UserAddressAddressTwo'] ?? null,
                $row['UserAddressCity'] ?? null,
                $row['UserAddressPostalCode'] ?? null,
                $row['UserAddressStateName'] ?? null,
                $row['UserAddressStateCode'] ?? null,
                $row['UserAddressCountryName'] ?? null,
                $row['UserAddressCountryCode'] ?? null,

                DateLibrary::getFormat($row['CreatedDateTime '] ?? null),
            );

            $arr[$row['Id']] = $entity;
        }

        return $arr;
    }

    public function userSecret(int $num)
    {
        $userSecretModel = new UserSecretModel();
        $query = $userSecretModel->query($userSecretModel->sqlSecret, [
            'userId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new UserSecretEntity(
            $num,
            $arr['UserSecretSalt'] ?? null,
            $arr['UserSecretPassword'] ?? null
        );

        return $entity;
    }

    public function userSecretReset(string $token)
    {
        $userSecretResetModel = new UserSecretResetModel();
        $query = $userSecretResetModel->query($userSecretResetModel->sqlToken, [
            'userSecretResetToken' => $token
        ]);
        $row = $query->getRowArray();
        if (is_null($row))
            return null;
        else {
            return new UserSecretResetEntity(
                $row['UserId'] ?? null,
                $token,
                $row['UserSecretExpiresAt'] ?? null
            );
        }
    }

    public function store($data, $dataSecret)
    {
        try {
            $userModel = new UserModel();

            $userModel->transException(true)->transStart();

            // Insert into user
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $userId = $userModel->insert($data);

            // Insert into user_secret
            $userSecretModel = new UserSecretModel();
            $dataSecret['UserId'] = $userId;
            $userSecretModel->insert($dataSecret);

            $userModel->transComplete();

            if ($userModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function storeBillingAddress($data)
    {
        try {
            $userBillingAddressModel = new UserBillingAddressModel();

            $userBillingAddressModel->transException(true)->transStart();

            // Insert into user_billing_address
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $userId = $userBillingAddressModel->insert($data);

            $userBillingAddressModel->transComplete();

            if ($userBillingAddressModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
            die;
        }
    }

    public function storeShippingAddress($data)
    {
        try {
            $userShippingAddressModel = new UserShippingAddressModel();

            $userShippingAddressModel->transException(true)->transStart();

            // Insert into user_shipping_address
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $userId = $userShippingAddressModel->insert($data);

            $userShippingAddressModel->transComplete();

            if ($userShippingAddressModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
            die;
        }
    }

    public function update($num, $data, $dataImage)
    {
        try {
            $userModel = new UserModel();

            $userModel->transException(true)->transStart();

            // Update into user
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($num, $data);

            // Insert or Update in user_image
            if (!empty($dataImage)) {
                $userImageModel = new userImageModel();
                $userImageFileId = $this->getUserImageFileFk($num);
                if (is_null($userImageFileId)) {
                    $userImageModel->insert($dataImage);
                } else {
                    $userImageModel->update($num, $dataImage);
                }
            }



            $userModel->transComplete();

            if ($userModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function updateSecret($num, $dataSecret, $forgetPassword)
    {
        try {
            $userSecretModel = new UserSecretModel();

            $userSecretModel->transException(true)->transStart();

            // Update into user_secret
            $userSecretModel->update($num, $dataSecret);

            // Delete forgetPassword if true
            if ($forgetPassword === true) {
                $userSecretResetModel = new UserSecretResetModel();
                $userSecretResetModel->delete($num);
            }

            // Update into user
            $userModel = new UserModel();
            $dataUser['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($num, $dataUser);

            $userSecretModel->transComplete();

            if ($userSecretModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function updateBillingAddress($num, $data)
    {
        try {
            $userBillingAddressModel = new UserBillingAddressModel();

            $userBillingAddressModel->transException(true)->transStart();

            // Update into user_billing_address
            $userBillingAddressModel->update($num, $data);

            // Update into user
            $userModel = new UserModel();
            $dataUser['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($data['UserBillingAddressUserFk'], $dataUser);

            $userBillingAddressModel->transComplete();

            if ($userBillingAddressModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function updateShippingAddress($num, $data)
    {
        try {
            $userShippingAddressModel = new UserShippingAddressModel();

            $userShippingAddressModel->transException(true)->transStart();

            // Update into user_shipping_address
            $userShippingAddressModel->update($num, $data);

            // Update into user
            $userModel = new UserModel();
            $dataUser['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($data['UserShippingAddressUserFk'], $dataUser);

            $userShippingAddressModel->transComplete();

            if ($userShippingAddressModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function saveSecretReset($num, $dataSecretReset)
    {
        try {
            $userSecretResetModel = new UserSecretResetModel();

            $userSecretResetModel->transException(true)->transStart();

            // Update into user_secret_reset
            $userSecretResetModel->delete($num);
            $userSecretResetModel->insert($dataSecretReset);

            // Update into user
            $userModel = new UserModel();
            $dataUser['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($num, $dataUser);

            $userSecretResetModel->transComplete();

            if ($userSecretResetModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function saveCookie($num, $dataCookie)
    {
        try {
            $userCookieModel = new UserCookieModel();

            $userCookieModel->transException(true)->transStart();

            // Update into user_cookies
            $userCookieModel->delete($num);
            $userCookieModel->insert($dataCookie);

            // Update into user
            $userModel = new UserModel();
            $dataUser['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $userModel->update($num, $dataUser);

            $userCookieModel->transComplete();

            if ($userCookieModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function deleteCookie(int $num)
    {
        try {
            $userCookieModel = new UserCookieModel();
            $userCookieModel->transException(true)->transStart();

            $query = $userCookieModel->query($userCookieModel->sqlDelete, [
                'userId' => $num,
            ]);

            $affected_rows = $userCookieModel->affectedRows();

            $userCookieModel->transComplete();
            if ($affected_rows >= 1 && $userCookieModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }

    public function deleteBillingAddress(int $num)
    {
        try {
            $userBillingAddressModel = new UserBillingAddressModel();
            $userBillingAddressModel->transException(true)->transStart();

            $query = $userBillingAddressModel->query($userBillingAddressModel->sqlDelete, [
                'id' => $num,
            ]);

            $affected_rows = $userBillingAddressModel->affectedRows();

            $userBillingAddressModel->transComplete();
            if ($affected_rows >= 1 && $userBillingAddressModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }

    public function deleteShippingAddress(int $num)
    {
        try {
            $userShippingAddressModel = new UserShippingAddressModel();
            $userShippingAddressModel->transException(true)->transStart();

            $query = $userShippingAddressModel->query($userShippingAddressModel->sqlDelete, [
                'id' => $num,
            ]);

            $affected_rows = $userShippingAddressModel->affectedRows();

            $userShippingAddressModel->transComplete();
            if ($affected_rows >= 1 && $userShippingAddressModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            d($e);
            die;
        }
    }


    // Other 
    public function getIdByEmail(string $email)
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlEmail, [
            'email' => $email
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'UserId'};
    }

    public function getIdByCookieSelector(string $selector)
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlIdByCookieSelector, [
            'selector' => $selector
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'UserId'};
    }

    public function getUserImageFileFk(int $num)
    {
        $userImageModel = new UserImageModel();
        $query = $userImageModel->query($userImageModel->sqlUserImageFileFk, [
            'userId' => $num
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'UserImageFileFk'};
    }


}