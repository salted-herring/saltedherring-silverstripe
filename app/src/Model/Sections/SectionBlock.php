<?php
/**
 * @name SectionBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A sortable block paced inside a section.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\QuoteBlock;
use App\Web\Extensions\SortOrder;
use App\Web\Model\BlocksSection;

use SilverStripe\ORM\DataObject;

class SectionBlock extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(100)',
        'Content' => 'HTMLText'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Section' => BlocksSection::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        QuoteBlock::class,
        SortOrder::class
    ];

    private static $table_name = 'SectionBlock';

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
