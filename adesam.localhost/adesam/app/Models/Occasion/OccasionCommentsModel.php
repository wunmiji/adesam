<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionCommentsModel extends Model
{

    protected $table = 'occasion_comments';
    protected $primaryKey = 'OccasionCommentsId';
    protected $allowedFields = [
        'OccasionCommentsId',
        'OccasionCommentsOccasionFk',
        'OccasionCommentsUserFk',
        'OccasionCommentsParentId',
        'OccasionCommentsChildId',
        'OccasionCommentsComment',
        'OccasionCommentsIsDeleted',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlDelete = 'DELETE FROM occasion_comments WHERE OccasionCommentsId = :commentId:;';
    protected $sqlId = 'SELECT OccasionCommentsId AS Id FROM occasion_comments WHERE OccasionCommentsChildId = :uuid:';
    protected $sqlComments = 'SELECT
                                oc.OccasionCommentsId AS Id,
                                oc.OccasionCommentsOccasionFk AS OccasionId,
                                oc.OccasionCommentsUserFk AS UserId,
                                oc.OccasionCommentsParentId,
                                oc.OccasionCommentsChildId,
                                oc.OccasionCommentsComment,
                                oc.CreatedDateTime,
                                u.UserFirstName,
                                u.UserLastName,
                                (
                                    SELECT 
                                        COUNT(OccasionCommentsParentId) 
                                    FROM 
                                        occasion_comments
		                            WHERE OccasionCommentsParentId = oc.OccasionCommentsChildId
                                ) AS Replies,
                                ui.UserImageFileFk AS FileId,
                                f.FileName,
                                f.FileUrlPath
                            FROM
                                occasion_comments oc
                                JOIN user u ON u.UserId = oc.OccasionCommentsUserFk
                                JOIN occasion o ON o.OccasionId = oc.OccasionCommentsOccasionFk
                                LEFT JOIN user_image ui ON ui.UserId = u.UserId 
                                LEFT JOIN file f ON ui.UserImageFileFk = f.FileId 
                            WHERE
                                oc.OccasionCommentsIsDeleted = false
                                AND
                                oc.OccasionCommentsParentId = :parentId:
                                AND
                                o.OccasionSlug = :slug:;';



}
