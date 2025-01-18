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
        'OccasionStatus'
    ];

    // SQL
    protected $sqlCount = 'SELECT COUNT(OccasionId) AS COUNT FROM occasion WHERE OccasionStatus = "PUBLISHED"';
    protected $sqlId = 'SELECT OccasionId FROM occasion WHERE OccasionSlug = :slug:';
    protected $sqlList = 'SELECT
                            OccasionId,
                            OccasionTitle,
                            OccasionSlug,
                            OccasionStatus,
                            OccasionSummary,
                            OccasionPublishedDate
                        FROM
                            occasion 
                        WHERE 
                            OccasionStatus = "PUBLISHED"
                        ORDER BY 
                            OccasionId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';

    protected $sqlListTag = 'SELECT
                            o.OccasionId,
                            o.OccasionTitle,
                            o.OccasionSlug,
                            o.OccasionStatus,
                            o.OccasionSummary,
                            o.OccasionPublishedDate
                        FROM
                            occasion o
                            JOIN occasion_tags ot ON ot.OccasionTagOccasionFk = o.OccasionId
                            JOIN tag t ON t.TagId = ot.OccasionTagTagFk 
                        WHERE 
                            o.OccasionStatus = "PUBLISHED"
                            AND
                            t.TagSlug = :slug:
                        ORDER BY 
                            OccasionId 
                        DESC 
                        LIMIT 
                            :from:, :to:;';

    protected $sqlRetrieve = 'SELECT
                                OccasionId,
                                OccasionTitle,
                                OccasionSlug,
                                OccasionSummary,
                                OccasionStatus,
                                OccasionPublishedDate
                            FROM
                                occasion 
                            WHERE
                                OccasionStatus = "PUBLISHED"
                                AND
                                OccasionSlug = :slug:;';

    // SQL FOR SEARCH
    protected $sqlSearchCount = 'SELECT 
                                    COUNT(o.OccasionId)  AS COUNT
                                FROM 
                                    occasion o
                                WHERE 
                                    o.OccasionStatus = "PUBLISHED"
                                    AND
                                    o.OccasionSlug REGEXP :search:';


    protected $sqlTagCount = 'SELECT 
                                    COUNT(o.OccasionId)  AS COUNT
                                FROM 
                                    occasion o
                                    JOIN occasion_tags ot ON ot.OccasionTagOccasionFk = o.OccasionId
                                    JOIN tag t ON t.TagId = ot.OccasionTagTagFk 
                                WHERE 
                                    o.OccasionStatus = "PUBLISHED"
                                    AND
                                    t.TagSlug = :slug:';

    protected $sqlSlugSearch = 'SELECT 
                                    o.OccasionId,
                                    o.OccasionTitle,
                                    o.OccasionSlug,
                                    o.OccasionStatus,
                                    o.OccasionSummary,
                                    o.OccasionPublishedDate 
                                FROM 
                                    occasion o
                                WHERE 
                                    o.OccasionStatus = "PUBLISHED"
                                    AND
                                    o.OccasionSlug REGEXP :search:
                                ORDER BY 
                                    o.OccasionPublishedDate DESC 
                                LIMIT 
                                    :from:, :to:';




}