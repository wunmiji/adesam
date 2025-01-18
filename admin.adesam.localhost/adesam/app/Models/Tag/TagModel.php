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
    protected $sqlDelete = 'DELETE FROM tag WHERE TagId = :tagId:;';
    protected $sqlTable = 'SELECT
                                t.TagId,
                                t.TagName,
                                t.TagSlug,
                                t.TagType,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                t.CreatedDateTime,
                                t.CreatedId
                            FROM
                                tag t
                                JOIN family ce ON t.CreatedId = ce.FamilyId
                            WHERE 
                                t.TagType = :type: 
                            ORDER BY 
                                t.TagId';

    protected $sqlTags = 'SELECT
                                TagId,
                                TagName,
                                TagType
                            FROM
                                tag
                            WHERE 
                                TagType = :type: 
                            ORDER BY 
                                TagId';
    

}
