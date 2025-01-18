<?php

namespace App\ImplModel;



use App\Models\User\UserModel;
use App\Models\User\UserImageModel;
use App\Models\User\UserBillingAddressModel;
use App\Models\User\UserShippingAddressModel;
use App\Libraries\DateLibrary;
use App\Libraries\SecurityLibrary;
use App\Entities\User\UserEntity;
use App\Entities\User\UserImageEntity;
use App\Entities\User\UserAddressEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class UserImplModel
{


    public function list(int $from, int $to)
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlTable, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();


        $output = array();
        foreach ($list as $key => $value) {
            $entity = new UserEntity(
                $value['UserId'] ?? null,
                SecurityLibrary::encryptUrlId($value['UserId']),
                $value['Name'] ?? null,
                null,
                null,
                $value['UserEmail'] ?? null,
                null,
                $value['UserDescription'] ?? null,

                null,
                null,
                
                $this->userImage($value['UserId']) ?? null,
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieve(int $num)
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlRetrieve, [
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
            SecurityLibrary::encryptUrlId($value['UserId']),
            $value['UserFirstName'] . ' ' . $value['UserLastName'],
            $value['UserFirstName'] ?? null,
            $value['UserLastName'] ?? null,
            $value['UserEmail'] ?? null,
            $value['UserNumber'] ?? null,
            $value['UserDescription'] ?? null,

            DateLibrary::getFormat($value['CreatedDateTime'] ?? null),
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->userImage($value['UserId']) ?? null,
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

                DateLibrary::getFormat($row['CreatedDateTime'] ?? null),
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


    // Other 
    public function count()
    {
        $userModel = new UserModel();
        $query = $userModel->query($userModel->sqlCount);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT'};
    }

    public function pagination(int $queryPage, int $queryLimit)
    {
        $pagination = array();
        $totalCount = $this->count();
        $list = array();
        $pageCount = ceil($totalCount / $queryLimit);
        $arrayPageCount = array();

        $next = ($queryPage * $queryLimit) - $queryLimit;
        $list = $this->list($next, $queryLimit);

        for ($i = 0; $i < $pageCount; $i++)
            array_push($arrayPageCount, $i + 1);

        $pagination['list'] = $list;
        $pagination['queryLimit'] = $queryLimit;
        $pagination['queryPage'] = $queryPage;
        $pagination['arrayPageCount'] = $arrayPageCount;

        return $pagination;
    }


}