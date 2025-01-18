<?php

namespace App\Models\Occasion;

use CodeIgniter\Model;

class OccasionModel extends Model
{

    protected $table = 'occasion';
    protected $primaryKey = 'OccasionId';
    protected $allowedFields = [
        'OccasionId',
        'OccasionTitle',
        'OccasionSlug',
        'OccasionSummary',
        'OccasionPublishedDate',
        'OccasionStatus',
        'CreatedId',
        'CreatedDateTime',
        'ModifiedId',
        'ModifiedDateTime'
    ];

    // SQL
    protected $sqlId = 'SELECT OccasionId FROM occasion ORDER BY OccasionId DESC LIMIT :from:, :to:';
    protected $sqlCount = 'SELECT COUNT(OccasionId) AS COUNT FROM occasion';
    protected $sqlDelete = 'DELETE FROM occasion WHERE OccasionId = :occasionId:;';
    protected $sqlStatus = 'SELECT OccasionStatus FROM occasion WHERE OccasionId = :occasionId:;';
    protected $sqlTable = 'SELECT
                            OccasionId,
                            OccasionTitle,
                            OccasionStatus,
                            OccasionSummary
                        FROM
                            occasion 
                        ORDER BY 
                            OccasionId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';
    protected $sqlRetrieve = 'SELECT
                                o.OccasionId,
                                o.OccasionTitle,
                                o.OccasionSlug,
                                o.OccasionSummary,
                                o.OccasionStatus,
                                o.OccasionPublishedDate,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                o.CreatedDateTime,
                                o.CreatedId,
                                me.FamilyFirstName AS ModifiedByFirstName,
                                me.FamilyLastName AS ModifiedByLastName,
                                o.ModifiedDateTime,
                                o.ModifiedId
                            FROM
                                occasion o
                                JOIN family ce ON o.CreatedId = ce.FamilyId
                                LEFT JOIN family me ON o.ModifiedId = me.FamilyId
                            WHERE
                                o.OccasionId = :occasionId:;';

    protected $occasionPerMonth = 'SELECT 
	                                DISTINCT DATE_FORMAT(OccasionPublishedDate, "%b") AS x,
	                                (SELECT COUNT(OccasionId) 
		                                FROM 
                                            occasion
		                                WHERE 
			                                DATE_FORMAT(OccasionPublishedDate, "%b") = x
                                            AND 
                                            DATE_FORMAT(OccasionPublishedDate, "%Y") = :year:
	                                ) AS y
                                FROM 
	                                occasion 
                                WHERE
	                                DATE_FORMAT(OccasionPublishedDate, "%Y") = :year:;';

}
