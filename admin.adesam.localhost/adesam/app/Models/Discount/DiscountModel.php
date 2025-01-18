<?php

namespace App\Models\Discount;

use CodeIgniter\Model;

class DiscountModel extends Model
{

    protected $table = 'discount';
    protected $primaryKey = 'DiscountId';
    protected $allowedFields = [
        'DiscountId',
        'DiscountType',
        'DiscountName',
        'DiscountValue',
        'CreatedId',
        'CreatedDateTime'
    ];

    // SQL
    protected $sqlDelete = 'DELETE FROM discount WHERE DiscountId = :discountId:;';
    protected $sqlTable = 'SELECT
                                d.DiscountId,
                                d.DiscountType,
                                d.DiscountName,
                                d.DiscountValue,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                d.CreatedDateTime,
                                d.CreatedId
                            FROM
                                discount d
                                JOIN family ce ON d.CreatedId = ce.FamilyId
                            ORDER BY 
                                d.DiscountId';
    protected $sqlList = 'SELECT
                                    DiscountId,
                                    DiscountType,
                                    DiscountName,
                                    DiscountValue
                                FROM
                                    discount 
                                ORDER BY 
                                    DiscountId';



    protected $sqlDiscount = 'SELECT
                                d.DiscountId,
                                d.DiscountType,
                                d.DiscountName,
                                d.DiscountValue,
                                ce.FamilyFirstName AS CreatedByFirstName,
                                ce.FamilyLastName AS CreatedByLastName,
                                d.CreatedDateTime,
                                d.CreatedId
                            FROM
                                discount d
                                JOIN family ce ON d.CreatedId = ce.FamilyId
                            WHERE
                                DiscountId = :discountId:;';

}
