<?php
/**
 * @name IntroductionSection
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Introduction section - contains Quote & Text area.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\QuoteBlock;
use App\Web\Model\Section;

use SilverStripe\ORM\DataObject;

class IntroductionSection extends Section
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Content' => 'HTMLText'
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

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        QuoteBlock::class
    ];

    private static $table_name = 'IntroductionSection';

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
