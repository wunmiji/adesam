<?php

namespace App\ImplModel;


use App\Libraries\FileLibrary;
use App\Models\File\FileManagerModel;
use App\Libraries\DateLibrary;
use App\Enums\FileType;
use App\Entities\FileManager\FileManagerEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;

use Ramsey\Uuid\Uuid;


/**
 * 
 */

class FileManagerImplModel
{

    public $path = 'assets/file-manager/Users';
    public $namespace = '9597c04a-10cb-11ef-b01a-a0d3c198cfa0';
    public $fileManager = '4c0c7bf3-686f-5b42-8098-7554aa90f346'; // name = 'file-manager'
    

    public function getFileIdUsingPublicIdName(string $publicId, string $name)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlWherePublicIdName, [
            'publicId' => $publicId,
            'name' => $name
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

    public function retrieveUser(string $publicId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrieveUser, [
            'publicId' => $publicId,
        ]);
        $value = $query->getRowArray();

        if (is_null(($value)))
            return null;
        else {
            return new FileManagerEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                $value['FilePublicId'],
                $value['FileName'],
                null,
                $value['FilePath'],
                $value['FileParentPath'],
               
            );
        }

    }

    public function saveFolder($data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Insert into file
            $data['CreatedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileManagerModel->insert($data);

            //Update file with privateId
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $fileId);
            $dataUpdated['FilePrivateId'] = $uuid->toString();
            $fileManagerModel->update($fileId, $dataUpdated);

            $fileManagerModel->transComplete();

            if ($fileManagerModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function saveFile($datas)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();
            $dateTime = DateLibrary::getZoneDateTime();

            // Insert into file
            foreach ($datas as $data) {
                $data['CreatedDateTime'] = $dateTime;
                $fileId = $fileManagerModel->insert($data);

                //Update file with privateId
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $fileId);
                $dataUpdated['FilePrivateId'] = $uuid->toString();
                $fileManagerModel->update($fileId, $dataUpdated);
            }


            $fileManagerModel->transComplete();

            if ($fileManagerModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function saveUpdateFile($userImageFileId, $data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            if (is_null($userImageFileId)) {
                // Insert into fileManager
                $userImageFileId = $fileManagerModel->insert($data);
            } else {
                // Delete old file from path
                $oldFileName = $this->getFileName($userImageFileId);
                FileLibrary::deleteFile($this->path . DIRECTORY_SEPARATOR . $oldFileName);

                // Update into fileManagerFile
                $fileManagerModel->update($userImageFileId, $data);
            }

            //Update file with privateId
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $userImageFileId);
            $dataUpdated['FilePrivateId'] = $uuid->toString();
            $fileManagerModel->update($userImageFileId, $dataUpdated);

            $fileManagerModel->transComplete();

            if ($fileManagerModel->transStatus() === false)
                return false;
            else
                return $userImageFileId;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }

    public function deleteFile(int $fileNum, $folderNum, $folder)
    {
        try {
            $fileManagerModel = new FileManagerFileModel();
            $fileManagerModel->transException(true)->transStart();

            $query = $fileManagerModel->query($fileManagerModel->sqlDelete, [
                'fileManagerFileId' => $fileNum,
            ]);

            // Update into fileManager
            $folder['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileManagerModel = new FileManagerModel();
            $fileManagerId = $fileManagerModel->update($folderNum, $folder);

            $affected_rows = $fileManagerModel->affectedRows();

            $fileManagerModel->transComplete();
            if ($affected_rows >= 1 && $fileManagerModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
            return $e->getCode();
        }
    }



    // Other
    public function getFileManagerPrivateId()
    {
        return $this->fileManager;
    }

    public function getFileName(int $id)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlFileName, [
            'fileId' => $id
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FileName'};
    }



}