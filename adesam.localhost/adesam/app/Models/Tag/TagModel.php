<?php

namespace App\Models\Tag;

use CodeIgniter\Model;

class TagModel extends Model
{

    protected $table = 'tag';
    protected $primaryKey = 'TagId';
    protected $allowedFields = [
        'TagId',
        'TagName',
        'TagSlug',
        'TagType',
        'CreatedId',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlList = 'SELECT
                                TagId,
                                TagName,
                                TagSlug
                            FROM
                                tag
                            WHERE 
                                TagType = :tagType: 
                            ORDER BY 
                                TagId';

    protected $sqlListProduct = 'SELECT
                                TagId,
                                TagName,
                                TagSlug
                            FROM
                                tag
                            WHERE 
                                TagType = "PRODUCT" 
                            ORDER BY 
                                TagId';

    protected $sqlListOccasion = 'SELECT
                                TagId,
                                TagName,
                                TagSlug
                            FROM
                                tag
                            WHERE 
                                TagType = "OCCASION" 
                            ORDER BY 
                                TagId';

    protected $sqlRetrieve = 'SELECT
                                TagId,
                                TagName,
                                TagSlug
                            FROM
                                tag
                            WHERE 
                                TagType = :tagType:
                                AND
                                TagSlug = :tagSlug:';
    

}
