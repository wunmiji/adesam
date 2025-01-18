<?php

namespace App\ImplModel;


use App\Libraries\FileLibrary;
use App\Models\FileManager\FileManagerModel;
use App\Libraries\DateLibrary;
use App\Enums\FileType;
use App\Entities\FileManager\FileManagerEntity;

use CodeIgniter\Database\Exceptions\DatabaseException;

use Ramsey\Uuid\Uuid;


/**
 * 
 */

class FileManagerImplModel extends BaseImplModel
{

    public $namespace = '9597c04a-10cb-11ef-b01a-a0d3c198cfa0';
    public $fileManager = '4c0c7bf3-686f-5b42-8098-7554aa90f346'; // name = 'file-manager'

    public function places(string $publicId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlPlaces, [
            'publicId' => $publicId
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'],
                null,
                null,
                null,
                null,
                $value['FilePath'],
                null,
                null,
                null,

                null,
                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null
            );
            array_push($output, $entity);
        }

        return $output;
    }

    public function retrievePrivate(string $privateId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrievePrivate, [
            'privateId' => $privateId,
        ]);
        $value = $query->getRowArray();

        if (is_null(($value)))
            return null;
        else {
            return new FileManagerEntity(
                $value['FileId'],
                null,
                $value['FilePublicId'],
                $value['FileName'],
                $value['FileIsDirectory'],
                null,
                null,
                null,
                $value['FilePath'],
                $value['FileParentPath'],
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                null,
                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null
            );
        }

    }

    public function retrieve(string $publicId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrieveAll, [
            'publicId' => $publicId,
            'createdId' => $this->getCreatedId()
        ]);
        $rows = $query->getResultArray();


        $output = array();
        foreach ($rows as $key => $value) {
            $lastModifiedTimeStamp = intval($value['FileLastModified']);
            $modifiedDateTimeTimeStamp = DateLibrary::toTimestamp($value['ModifiedDateTime']);

            $entity = new FileManagerEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileType'] ?? null,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                ($modifiedDateTimeTimeStamp > $lastModifiedTimeStamp) ? DateLibrary::formatTimestamp($modifiedDateTimeTimeStamp) : DateLibrary::formatTimestamp($lastModifiedTimeStamp),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }

        return $output;
    }

    public function retrieveFavorite()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrieveFavorite, [
            'createdId' => $this->getCreatedId()
        ]);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileType'] ?? null,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                DateLibrary::formatTimestamp($value['FileLastModified']),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }


        return $output;
    }

    public function retrieveTrash()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlRetrieveTrash, [
            'createdId' => $this->getCreatedId()
        ]);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $value) {
            $entity = new FileManagerEntity(
                $value['FileId'],
                $value['FilePrivateId'],
                null,
                $value['FileName'] ?? null,
                ($value['FileIsDirectory'] == 1) ? true : false,
                $value['FileType'] ?? null,
                $value['FileUrlPath'] ?? null,
                $value['FileDescription'] ?? null,
                $value['Path'] ?? null,
                $value['ParentPath'] ?? null,
                ($value['FileIsFavourite'] == 1) ? true : false,
                ($value['FileIsTrash'] == 1) ? true : false,

                $value['FileMimeType'],
                ($value['FileIsDirectory'] == 1) ? $value['FileSize'] . ' items' : FileLibrary::formatBytes($value['FileSize']),
                $value['FileExtension'],
                DateLibrary::formatTimestamp($value['FileLastModified']),

                $value['CreatedId'] ?? null,
                $value['CreatedByFirstName'] ?? '' . ' ' . $value['CreatedByLastName'] ?? '',
                DateLibrary::getFormat($value['CreatedDateTime'] ?? null),

                $value['ModifiedId'] ?? null,
                $value['ModifiedByFirstName'] ?? '' . ' ' . $value['ModifiedByLastName'] ?? '',
                DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),
            );

            array_push($output, $entity);
        }


        return $output;
    }

    public function retrieveFolder(string $privateId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlSimpleRetrieve, [
            'privateId' => $privateId,
            'createdId' => $this->getCreatedId()
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return new FileManagerEntity(
                $row['FileId'],
                $row['FilePrivateId'],
                null,
                $row['FileName'],
                null,
                null,
                null,
                $row['FileDescription'],
                $row['FilePath'],
                $row['FileParentPath'],
                null,
                null,


                null,
                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null
            );
        }
    }

    public function retrievePaths(string $publicId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlUpdateOther, [
            'publicId' => $publicId,
            'createdId' => $this->getCreatedId()
        ]);
        $rows = $query->getResultArray();

        $output = array();
        foreach ($rows as $key => $row) {
            $entity = new FileManagerEntity(
                $row['FileId'],
                null,
                null,
                null,
                $row['FileIsDirectory'],
                null,
                $row['FileUrlPath'],
                null,
                $row['FilePath'],
                $row['FileParentPath'],
                null,
                null,

                null,
                null,
                null,
                null,

                null,
                null,
                null,

                null,
                null,
                null
            );

            array_push($output, $entity);
        }

        return $output;

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

    public function updateFolder($num, $data, $childFiles)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Update into file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileManagerModel->update($num, $data);

            // Update childFiles
            foreach ($childFiles as $key => $value) {
                $value['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
                $fileManagerModel->update($key, $value);
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

    public function renameFile($num, $data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Rename file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $fileId = $fileManagerModel->update($num, $data);

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

    public function favourite(int $num)
    {
        try {
            $fileManagerModel = new FileManagerModel();
            $fileManagerModel->transException(true)->transStart();

            $query = $fileManagerModel->query($fileManagerModel->sqlFavourite, [
                'fileId' => $num,
            ]);

            $affected_rows = $fileManagerModel->affectedRows();

            $fileManagerModel->transComplete();
            if ($affected_rows >= 1 && $fileManagerModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function trash(int $num, $data)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            // Update into file
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $data['ModifiedId'] = session()->get('employeeId');
            $fileId = $fileManagerModel->update($num, $data);

            $affected_rows = $fileManagerModel->affectedRows();

            $fileManagerModel->transComplete();
            if ($affected_rows >= 1 && $fileManagerModel->transStatus() === true)
                return true;
            else
                return false;
        } catch (DatabaseException $e) {
            \Sentry\captureException($e);
        }
    }

    public function deleteFolder(int $num, string $path)
    {
        try {
            $fileManagerModel = new FileManagerModel();
            $fileManagerModel->transException(true)->transStart();

            $query = $fileManagerModel->query($fileManagerModel->sqlDelete, [
                'fileId' => $num,
            ]);

            $children = $this->sqlAllFolderChildren($path);
            foreach ($children as $key => $value) {
                $fileManagerModel->delete($value['Id']);
            }


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

    public function deleteFile(int $num)
    {
        try {
            $fileManagerModel = new FileManagerModel();

            $fileManagerModel->transException(true)->transStart();

            $query = $fileManagerModel->query($fileManagerModel->sqlDelete, [
                'fileId' => $num,
            ]);

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

    public function folderPath($num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlFolderPath, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FilePath'};
    }

    public function createPlaces()
    {
        $this->createPlace('Home', 'Home');
        $this->createPlace('Documents', 'Documents');
        $this->createPlace('Pictures', 'Pictures');
        $this->createPlace('Videos', 'Videos');
        $this->createPlace('Shop', 'Media for e-commerce');
    }


    // Other 
    public function getFileId(int $num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlId, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'Id'};
    }

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

    public function sqlAllFolderChildren(string $filePath)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlAllFolderChildren, [
            'filePath' => $filePath . '%',
            'createdId' => $this->getCreatedId()
        ]);
        return $query->getResultArray();
    }

    public function getPrivateId(string $filePath)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlWhereFilePath, [
            'filePath' => $filePath
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'FilePrivateId'};
    }

    public function countFiles(int $num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlCountFiles, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'COUNT(*)'};
    }

    public function sumAllFileSize()
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlSumAllFileSize);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'SUM(FileSize)'};
    }

    public function sumFileSize(int $num)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlSumFileSize, [
            'fileId' => $num,
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : FileLibrary::formatBytes($row->{'SUM(FileSize)'});
    }

    public function privateType(string $privateId)
    {
        $fileManagerModel = new FileManagerModel();
        $query = $fileManagerModel->query($fileManagerModel->sqlPrivateType, [
            'createdId' => $this->getCreatedId(),
            'privateId' => $privateId
        ]);
        $row = $query->getRow();
        return ($row->{'PrivateType'} == "1") ? true : false;
    }

    private function createPlace(string $name, string $description)
    {
        try {
            $publicId = $this->getFileManagerPrivateId();
            if (is_null($this->getFileIdUsingPublicIdName($publicId, $name))) {
                $folder = FileLibrary::$dir . $name;
                $data = [
                    'FilePublicId' => $publicId,
                    'FileName' => $name,
                    'FileIsShow' => true,
                    'FileIsDirectory' => true,
                    'FileType' => FileType::PUBLIC->name,
                    'FileParentPath' => FileLibrary::$dir,
                    'FileDescription' => $description,
                    'FileIsTrash' => false,
                    'FilePath' => $folder,
                ];

                if ($this->saveFolder($data)) {
                    FileLibrary::createFolder($folder);
                } else
                    return redirect()->back()->with('fail', 'An error occur when adding' . $name . 'folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
            die;
        }
    }


}