<?php


namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;
use App\ImplModel\FileManagerImplModel;
use App\ImplModel\SettingImplModel;
use App\Libraries\FileLibrary;
use App\Enums\FileType;
use App\Enums\SettingType;

use Cocur\Slugify\Slugify;


class FileManager extends BaseController
{
    protected $maxFileSize; // 5368709120 (5gb)

    protected $fieldName = [
        'name' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Name is required',
                'max_length' => 'Max length for name is 50'
            ]
        ]
    ];

    protected $fieldDescription = [
        'description' => [
            'rules' => 'required|max_length[150]',
            'errors' => [
                'required' => 'Description is required',
                'max_length' => 'Max length for description is 150'
            ]
        ]
    ];

    protected $fieldFiles = [
        'files' => [
            'rules' => 'uploaded[files]|max_size[files,20480]|mime_in[files,image/apng,image/avif,image/gif,image/webp,image/svg+xml,image/png,image/jpeg,image/jpg,video/mp4,text/plain,text/csv,application/pdf,application/msword,audio/mpeg,audio/ogg,application/zip,text/richtext]',
            'errors' => [
                'uploaded' => 'Files is required',
                'max_size' => 'Max files size is 20mb',
                'mime_in' => 'Mime type not allowed',
            ]
        ]
    ];

    protected $fieldFileName = [
        'name' => [
            'rules' => 'required|regex_match[/^[\w\-. ]+$/]',
            'errors' => [
                'required' => 'Name is required',
                'regex_match' => 'Name is not valid',
            ]
        ]
    ];

    protected $fileManagerImplModel;

    public function __construct()
    {
        $this->fileManagerImplModel = new FileManagerImplModel();

        // set createdId
        $this->fileManagerImplModel->setCreatedId(session()->get('familyId'));

        $this->maxFileSize = disk_total_space("/");
    }

    public function index()
    {
        try {
            $settingImplModel = new SettingImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $this->fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            return redirect()->to('file-manager/' . $this->fileManagerImplModel->getFileManagerPrivateId());
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function indexAdesam(string $privateId)
    {
        try {
            $settingImplModel = new SettingImplModel();

            // Get fileManagerPrivateId from settings
            $file = $settingImplModel->list(SettingType::FILE->name);
            $this->fileManagerImplModel->setFileManagerPrivateId($file->first_public_id->value);

            $breadCrumbArray = array();
            $breadCrumbArray[$this->fileManagerImplModel->getFileManagerPrivateId()] = 'File Manager';
            if ($this->request->isAJAX()) {
                if ($privateId == 'Favourite') {
                    // Retrieve all files in favourite
                    $files = $this->fileManagerImplModel->retrieveFavorite();
                    $breadCrumbArray[0] = 'Favourite';

                    $data = [
                        'breadcrumb' => $breadCrumbArray,
                        'files' => $files
                    ];

                    return json_encode($data);
                } else {
                    $breadCrumbArray = $this->breadCrumb($privateId, $breadCrumbArray);

                    // Retrieve all files in privateId
                    $files = $this->fileManagerImplModel->retrieve($privateId);

                    $data = [
                        'breadcrumb' => $breadCrumbArray,
                        'files' => $files
                    ];

                    return json_encode($data);
                }
            }

            $data['title'] = 'File Manager';

            // Get All Places
            $places = $this->fileManagerImplModel->places($this->fileManagerImplModel->getFileManagerPrivateId());

            $files = array();
            if ($privateId == 'Favourite') {
                // Retrieve all files in favourite
                $files = $this->fileManagerImplModel->retrieveFavorite();
                $breadCrumbArray[0] = 'Favourite';
            } elseif ($privateId == 'Trash') {
                // Retrieve all files in trash
                $files = $this->fileManagerImplModel->retrieveTrash();
                $breadCrumbArray[0] = 'Trash';
            } else {
                $breadCrumbArray = $this->breadCrumb($privateId, $breadCrumbArray);

                if ($this->fileManagerImplModel->getFileManagerPrivateId() == $privateId)
                    // Retrieve all files in privateId
                    $files = $this->fileManagerImplModel->retrieve($privateId);
                elseif ($this->fileManagerImplModel->privateType($privateId) == false)
                    return view('null_error', $data);
                else
                    // Retrieve all files in privateId
                    $files = $this->fileManagerImplModel->retrieve($privateId);


            }


            $data['css_custom'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_custom'] = '<script src=/assets/js/custom/search_table.js></script>' .
                '<script src="/assets/js/custom/info_modal.js"></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/files_modal.js"></script>' .
                '<script src="/assets/js/custom/rename_modal.js"></script>';
            $data['datas'] = $files;
            $data['places'] = $places;
            $data['dataPrivateId'] = $privateId;
            $data['dataFileManagerPrivateId'] = $this->fileManagerImplModel->getFileManagerPrivateId();
            $data['dataBreadCrumbArray'] = $breadCrumbArray;

            return view('file/index', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            //throw PageNotFoundException::forPageNotFound();
            d($exception);
        }
    }

    public function createFolder(string $privateId, $validator = null)
    {
        try {

            $data['title'] = 'New Folder';
            $data['validation'] = $validator;
            $data['dataPrivateId'] = $privateId;
            $data['fileTypeEnum'] = FileType::getAll();

            return view('file/create-folder', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function createFile(string $privateId, $validator = null)
    {
        try {
            $data['title'] = 'New File';

            $acceptedFileInput = 'application/pdf, application/msword, application/zip, text/*, audio/*, video/*, image/*';

            $data['js_custom'] = '<script src="/assets/js/custom/file_manager.js"></script>';
            $data['validation'] = $validator;
            $data['acceptedFileInput'] = $acceptedFileInput;
            $data['dataPrivateId'] = $privateId;

            return view('file/create-file', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function detailsFolder(int $num, $validator = null)
    {
        try {
            $data['title'] = 'View Folder';

            $file = $this->fileManagerImplModel->retrieve($num);
            if (is_null($file))
                return view('null_error', $data);

            $countFiles = $this->fileManagerImplModel->countFiles($num);
            $sumFiles = $this->fileManagerImplModel->sumFileSize($num);
            $folderFiles = $this->fileManagerImplModel->listFolderFile($num);

            $data['css_files'] = '<link rel="stylesheet" href="/assets/css/custom/modal.css">';
            $data['js_files'] = '<script src=/assets/js/custom/search_table.js></script>' .
                '<script src="/assets/js/custom/view_modal.js"></script>' .
                '<script src="/assets/js/custom/delete_modal.js"></script>' .
                '<script src="/assets/js/custom/rename_modal.js"></script>' .
                '<script src="/assets/js/custom/info_modal.js"></script>';
            $data['validation'] = $validator;
            $data['data'] = $file;
            $data['dataCountFiles'] = $countFiles;
            $data['dataSumFiles'] = $sumFiles;
            $data['dataFiles'] = $folderFiles;

            return view('file_manager/folder/details', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function editFolder(string $privateId, $validator = null)
    {
        try {
            $data['title'] = 'Update Folder';

            $file = $this->fileManagerImplModel->retrieveFolder($privateId);
            if (is_null($file))
                return view('null_error', $data);

            $data['validation'] = $validator;
            $data['data'] = $file;
            //$data['fileTypeEnum'] = FileType::getAll();

            return view('file/update-folder', $data);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function delete(string $privateId)
    {
        try {
            $result = null;
            $file = $this->fileManagerImplModel->retrievePrivate($privateId);
            if ($file->isDirectory) {
                $result = $this->fileManagerImplModel->deleteFolder($file->id, $file->path);
            } else {
                $result = $this->fileManagerImplModel->deleteFile($file->id);
            }


            if ($result === true) {
                if ($file->isDirectory) {
                    FileLibrary::deleteDirectory($file->path);
                    return redirect()->back()->with('success', 'Folder deleted successfully!');
                } else {
                    FileLibrary::deleteFile($file->path);
                    return redirect()->back()->with('success', 'File deleted successfully!');
                }
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'Files in folder is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting folder!');
            }
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function favourite(string $privateId)
    {
        try {
            $file = $this->fileManagerImplModel->retrievePrivate($privateId);

            if ($this->fileManagerImplModel->favourite($file->id)) {
                $check = $this->fileManagerImplModel->retrievePrivate($privateId);
                if ($check->isFavourite)
                    return redirect()->back()->with('success', 'Added to favourite successfully!');
                else
                    return redirect()->back()->with('success', 'Removed from favourite successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops error when adding or removing favourite!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function trash(string $privateId)
    {
        try {
            $file = $this->fileManagerImplModel->retrievePrivate($privateId);
            $data = array();
            if ($file->isTrash) {
                $data = array_merge(
                    $data,
                    array(
                        'FileIsTrash' => false,
                        'FilePath' => $file->parentPath . DIRECTORY_SEPARATOR . $file->name
                    )
                );
            } else {
                $data = array_merge(
                    $data,
                    array(
                        'FileIsTrash' => true,
                        'FilePath' => null
                    )
                );
            }

            if ($this->fileManagerImplModel->trash($file->id, $data)) {
                $check = $this->fileManagerImplModel->retrievePrivate($privateId);
                if ($check->isTrash)
                    return redirect()->back()->with('success', 'Added to trash successfully!');
                else
                    return redirect()->back()->with('success', 'Removed from trash successfully!');
            } else {
                return redirect()->back()->with('fail', 'Ooops error when adding or removing from trash!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function deleteFile(string $privateId)
    {
        try {
            $file = $this->fileManagerImplModel->retrievePrivate($privateId);
            $result = $this->fileManagerImplModel->deleteFile($file->id);

            if ($result === true) {
                FileLibrary::deleteFile($file->path);
                return redirect()->back()->with('success', 'File deleted successfully!');
            } else if ($result === 1451)
                return redirect()->back()->with('fail', 'File is already used!');
            else {
                return redirect()->back()->with('fail', 'An error occur when deleting file!');
            }

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function downloadFile(string $privateId)
    {
        try {
            $file = $this->fileManagerImplModel->retrievePrivate($privateId);

            return $this->response->download($file->path, null);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFolder(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $type = $this->request->getPost('type');
                $familyId = session()->get('familyId');

                // Insert into file
                $file = $this->fileManagerImplModel->retrievePrivate($privateId);
                $folder = $file->path . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FilePublicId' => $privateId,
                    'FileIsDirectory' => true,
                    'FileParentPath' => $file->path,
                    'FileDescription' => $description,
                    'FileType' => $type,
                    'FileIsFavourite' => false,
                    'FileIsTrash' => false,
                    'FileIsShow' => true,
                    'FilePath' => $folder,
                    'CreatedId' => $familyId,
                ];

                $result = $this->fileManagerImplModel->saveFolder($data);
                if ($result === true) {
                    FileLibrary::createFolder($folder);
                    return redirect()->back()->with('success', 'Folder added successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding folder!');

            } else
                return $this->createFolder($privateId, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function storeFile(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldFiles);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $files = $this->request->getFileMultiple('files');
                $privateId = $this->request->getPost('privateId');
                $familyId = session()->get('familyId');

                // Insert into fileFile
                $file = $this->fileManagerImplModel->retrievePrivate($privateId);
                $path = $file->path;
                $sumAllFileSize = $this->fileManagerImplModel->sumAllFileSize();
                $datas = array();
                $totalSize = $sumAllFileSize;
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $fileName = $file->getClientName();
                        $fileMimeType = $file->getMimeType();
                        $fileSize = $file->getSize();
                        $fileExtension = $file->guessExtension();
                        $totalSize = $totalSize + $fileSize;
                        $lastModified = $file->getMTime();

                        $fileArray = [
                            'FilePublicId' => $privateId,
                            'FileIsDirectory' => false,
                            'FilePath' => $path . DIRECTORY_SEPARATOR . $fileName,
                            'FileUrlPath' => base_url($path . DIRECTORY_SEPARATOR . $fileName),
                            'FileParentPath' => $path,
                            'FileName' => $fileName,
                            'FileSize' => $fileSize,
                            'FileIsFavourite' => false,
                            'FileIsTrash' => false,
                            'FileIsShow' => true,
                            'FileMimeType' => $fileMimeType,
                            'FileExtension' => $fileExtension,
                            'FileLastModified' => $lastModified,
                            'CreatedId' => $familyId,
                        ];
                        array_push($datas, $fileArray);
                    }
                }

                // Update into file
                $folder = [
                    'ModifiedId' => $familyId,
                ];

                if ($totalSize >= $this->maxFileSize)
                    return redirect()->back()->with('fail', 'Max file size reached! ' . FileLibrary::formatBytes($this->maxFileSize));

                $result = $this->fileManagerImplModel->saveFile($datas);
                if ($result === true) {
                    FileLibrary::moveFiles($files, $path);
                    return redirect()->back()->with('success', 'File added successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when adding file!');

            } else
                return $this->createFile($privateId, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function updateFolder(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldName, $this->fieldDescription);
            $validated = $this->validate($fieldValidation);


            if ($validated) {
                $slugify = new Slugify();

                $name = $this->request->getPost('name');
                $description = $this->request->getPost('description');
                $familyId = session()->get('familyId');


                // Update into file 
                $file = $this->fileManagerImplModel->retrieveFolder($privateId);
                if (is_null($file))
                    return view('null_error', ['title' => 'Update Folder']);


                $folder = $file->parentPath . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FileDescription' => $description,
                    'FilePath' => $folder,
                    'ModifiedId' => $familyId,
                ];

                $childFiles = array();
                $files = $this->fileManagerImplModel->retrievePaths($privateId);
                foreach ($files as $key => $value) {
                    $urlPath = str_replace($file->path, $folder, $value->urlPath);
                    $path = str_replace($file->path, $folder, $value->path);

                    $childFile['FileUrlPath'] = ($value->isDirectory) ? null : $urlPath;
                    $childFile['FilePath'] = $path;
                    $childFile['FileParentPath'] = $folder;
                    $childFiles[$value->id] = $childFile;
                }

                $result = $this->fileManagerImplModel->updateFolder($file->id, $data, $childFiles);
                if ($result === true) {
                    FileLibrary::rename($file->path, $folder);
                    return redirect()->back()->with('success', 'Folder updated successfully!');
                } else if ($result === 1062)
                    return redirect()->back()->with('fail', 'Name already exist!');
                else
                    return redirect()->back()->with('fail', 'An error occur when updating folder!');

            } else
                return $this->editFolder($privateId, $this->validator);

        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function renameFile(string $privateId)
    {
        try {
            $fieldValidation = array_merge($this->fieldFileName);
            $validated = $this->validate($fieldValidation);

            if ($validated) {
                $name = $this->request->getPost('name');
                $familyId = session()->get('familyId');

                $file = $this->fileManagerImplModel->retrievePrivate($privateId);

                // Rename file 
                $newPath = $file->parentPath . DIRECTORY_SEPARATOR . $name;
                $data = [
                    'FileName' => $name,
                    'FilePath' => $newPath,
                    'FileExtension' => pathinfo($name, PATHINFO_EXTENSION),
                    'ModifiedId' => $familyId,
                ];

                $result = $this->fileManagerImplModel->renameFile($file->id, $data);
                if ($result === true) {
                    FileLibrary::rename($file->path, $newPath);
                    return redirect()->back()->with('success', 'File renamed successfully!');
                } else if ($result === 1644)
                    return redirect()->back()->with('fail', 'File Name already exist in this folder!');
                else
                    return redirect()->back()->with('fail', 'An error occur when renaming file!');
            } else
                return redirect()->back()->with('fail', 'File name not valid');


        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
            throw PageNotFoundException::forPageNotFound();
        }
    }

    private function breadCrumb(string $privateId, array $breadCrumbArray)
    {
        // Get selected
        $file = $this->fileManagerImplModel->retrievePrivate($privateId);

        // Breadcrumb array
        if ($privateId != $this->fileManagerImplModel->getFileManagerPrivateId()) {
            $filePathArray = array();
            $eachFilePathArrays = array();
            foreach (explode('/', $file->path) as $key => $value) {
                array_push($eachFilePathArrays, $value);
                $filePathArray[implode(DIRECTORY_SEPARATOR, $eachFilePathArrays)] = $value;
            }
            array_shift($filePathArray);
            array_shift($filePathArray);
            $lastFilePathValue = array_pop($filePathArray);
            foreach ($filePathArray as $key => $value) {
                $filePrivateId = $this->fileManagerImplModel->getPrivateId($key);
                $breadCrumbArray = array_merge($breadCrumbArray, array($filePrivateId => $value));
            }
            $breadCrumbArray = array_merge($breadCrumbArray, array($lastFilePathValue));
        }

        return $breadCrumbArray;
    }





}
