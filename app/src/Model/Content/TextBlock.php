<?php
/**
 * @name TextBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A text block with an optional quote block.
 *
 * */
namespace App\Web\Model;

use App\Web\Model\ContentBlock;

use SilverStripe\ORM\DataObject;

class TextBlock extends ContentBlock
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Alignment' => 'Enum(array("left", "right"), "left")',
        'Content'   => 'HTMLText',
        'ShowQuote' => 'Boolean',
        'Quote'     => 'Text',
        'Source'    => 'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'TextBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
