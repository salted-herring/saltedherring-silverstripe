<?php
/**
 * @name FooterDetail
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Footer Details - an item including a title & content
 * to display as part of a list in the footer.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;

use SilverStripe\ORM\DataObject;

class FooterDetail extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'   => 'Varchar(64)',
        'Content' => 'HTMLText'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        SortOrder::class
    ];

    private static $table_name = 'FooterDetail';

    /**
     * CMS Fields
     * @return FieldList
     */
    // public function getCMSFields()
    // {
    //     $fields = parent::getCMSFields();
    //     $this->extend('updateCMSFields', $fields);
    //     return $fields;
    // }
}
