<?php

namespace App\Models\File;

use CodeIgniter\Model;

class FileManagerModel extends Model
{

    protected $table = 'file';
    protected $primaryKey = 'FileId';
    protected $allowedFields = [
        'FileId',
        'FilePrivateId',
        'FilePublicId',
        'FileName',
        'FileIsDirectory',
        'FileIsFavourite',
        'FileIsTrash',
        'FileUrlPath',
        'FileDescription',
        'FileType',
        'FileIsShow',
        'FileParentPath',
        'FilePath',
        'FileSize',
        'FileMimeType',
        'FileExtension',
        'FileLastModified',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT FileId AS Id FROM file WHERE FileId = :fileId:';
    protected $sqlFileName = 'SELECT FileName FROM file WHERE FileId = :fileId:';
    protected $sqlCount = 'SELECT COUNT(FileId) AS COUNT FROM file';
    protected $sqlWherePublicIdName = 'SELECT FileId AS Id FROM file WHERE FilePublicId = :publicId: AND FileName = :name:';
    protected $sqlFolderPath = 'SELECT FilePath FROM file WHERE FileId = :fileId:';
    protected $sqlDelete = 'DELETE FROM file WHERE FileId = :fileId:;';
    protected $sqlSumAllFileSize = 'SELECT SUM(FileSize) FROM file';
    protected $sqlFavourite = 'UPDATE `file` set FileIsFavourite = !FileIsFavourite  WHERE FileId = :fileId:;';
    protected $sqlTable = 'SELECT
                            FileId,
                            FileName
                        FROM
                            file 
                        ORDER BY 
                            FileId 
                        DESC;';

    protected $sqlPlaces = 'SELECT
                                    FileId,
                                    FileName,
                                    FilePrivateId, 
                                    FilePath
                                FROM
                                    file 
                                WHERE 
                                    FilePublicId = :publicId:
                                    AND
                                    FileIsShow = true
                                ORDER BY 
                                    FileId 
                                ASC;';

    protected $sqlWhereFilePath = 'SELECT 
                                        FilePrivateId
                                    FROM 
                                        file 
                                    WHERE 
                                        FilePath = :filePath:';

    protected $sqlRetrieveUser = 'SELECT
                                        FileId,
                                        FileName,
                                        FilePrivateId,
                                        FilePublicId, 
                                        FilePath,
                                        FileParentPath
                                    FROM
                                        file 
                                    WHERE 
                                        FilePublicId = :publicId: 
                                        AND
                                        FileName = "Users"';

    protected $sqlList = 'SELECT
                            FileId,
                            FileName,
                            FilePath
                        FROM
                            file_manager 
                        WHERE 
                            FileType = :type:
                        ORDER BY 
                            FileName;';

    protected $sqlRetrieveAll = 'SELECT
                                    f.FileId,
                                    f.FilePrivateId,
                                    f.FileName,
                                    f.FileIsDirectory,
                                    f.FileIsFavourite,
                                    f.FileIsTrash,
                                    f.FileUrlPath,
                                    f.FileDescription,
                                    f.FilePath as Path,
                                    f.FileParentPath as ParentPath,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
									    	(SELECT count(FileId) 
									    		FROM adesam.file 
									    		WHERE FileParentPath = Path       
										    )
									    ELSE f.FileSize
								    END AS FileSize,
                                    f.FileMimeType,
                                    f.FileExtension,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
										    (SELECT MAX(FileLastModified) 
											    FROM adesam.file 
											    WHERE FileParentPath = Path
										    )
									    ELSE f.FileLastModified
								    END AS FileLastModified,
                                    ce.FamilyFirstName AS CreatedByFirstName,
                                    ce.FamilyLastName AS CreatedByLastName,
                                    f.CreatedDateTime,
                                    f.CreatedId,
                                    me.FamilyFirstName AS ModifiedByFirstName,
                                    me.FamilyLastName AS ModifiedByLastName,
                                    f.ModifiedDateTime,
                                    f.ModifiedId
                                FROM
                                    file f
                                    JOIN family ce ON ce.FamilyId = f.CreatedId 
                                    LEFT JOIN family me ON me.FamilyId = f.ModifiedId
                                WHERE
                                    f.FilePublicId = :publicId:
                                    AND 
                                    f.FileIsTrash = false;';

    protected $sqlRetrieveFavorite = 'SELECT
                                    f.FileId,
                                    f.FilePrivateId,
                                    f.FileName,
                                    f.FileIsDirectory,
                                    f.FileIsFavourite,
                                    f.FileIsTrash,
                                    f.FileUrlPath,
                                    f.FileDescription,
                                    f.FilePath as Path,
                                    f.FileParentPath as ParentPath,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
									    	(SELECT count(FileId) 
									    		FROM adesam.file 
									    		WHERE FileParentPath = Path        
									    	)
								    	ELSE f.FileSize
								    END AS FileSize,
                                    f.FileMimeType,
                                    f.FileExtension,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
										    (SELECT MAX(FileLastModified) 
											    FROM adesam.file 
											    WHERE FileParentPath = Path
										    )
									    ELSE f.FileLastModified
								    END AS FileLastModified,
                                    ce.FamilyFirstName AS CreatedByFirstName,
                                    ce.FamilyLastName AS CreatedByLastName,
                                    f.CreatedDateTime,
                                    f.CreatedId,
                                    me.FamilyFirstName AS ModifiedByFirstName,
                                    me.FamilyLastName AS ModifiedByLastName,
                                    f.ModifiedDateTime,
                                    f.ModifiedId
                                FROM
                                    file f
                                    JOIN family ce ON f.CreatedId = ce.FamilyId
                                    LEFT JOIN family me ON f.ModifiedId = me.FamilyId
                                WHERE
                                    f.FileIsFavourite = true 
                                    AND 
                                    f.FileIsTrash = false;';

    protected $sqlRetrieveTrash = 'SELECT
                                    f.FileId,
                                    f.FilePrivateId,
                                    f.FileName,
                                    f.FileIsDirectory,
                                    f.FileIsFavourite,
                                    f.FileIsTrash,
                                    f.FileUrlPath,
                                    f.FileDescription,
                                    f.FilePath as Path,
                                    f.FileParentPath as ParentPath,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
									    	(SELECT count(FileId) 
									    		FROM adesam.file 
									    		WHERE FileParentPath = concat(ParentPath, "/",  f.FileName)        
									    	)
								    	ELSE f.FileSize
								    END AS FileSize,
                                    f.FileMimeType,
                                    f.FileExtension,
                                    CASE
									    WHEN f.FileIsDirectory = true THEN 
										    (SELECT MAX(FileLastModified) 
											    FROM adesam.file 
											    WHERE FileParentPath = concat(ParentPath, "/",  f.FileName)
										    )
									    ELSE f.FileLastModified
								    END AS FileLastModified,
                                    ce.FamilyFirstName AS CreatedByFirstName,
                                    ce.FamilyLastName AS CreatedByLastName,
                                    f.CreatedDateTime,
                                    f.CreatedId,
                                    me.FamilyFirstName AS ModifiedByFirstName,
                                    me.FamilyLastName AS ModifiedByLastName,
                                    f.ModifiedDateTime,
                                    f.ModifiedId
                                FROM
                                    file f
                                    JOIN family ce ON f.CreatedId = ce.FamilyId
                                    LEFT JOIN family me ON f.ModifiedId = me.FamilyId
                                WHERE
                                    f.FileIsTrash = true;';


    protected $sqlSimpleRetrieve = 'SELECT
                                        FileId,
                                        FileName,
                                        FileDescription,
                                        FilePrivateId,
                                        FilePath,
                                        FileParentPath
                                    FROM
                                        file
                                    WHERE
                                        FilePrivateId = :privateId:;';

    protected $sqlAllFolderChildren = 'SELECT
                                        FileId as Id
                                    FROM
                                        file
                                    WHERE
                                        FileParentPath like :filePath:;';


    protected $sqlUpdateOther = 'SELECT
                                        FileId,
                                        FileUrlPath,
                                        FilePath,
                                        FileParentPath,
                                        FileIsDirectory
                                    FROM
                                        file
                                    WHERE
                                        FilePublicId = :publicId:;';

}
