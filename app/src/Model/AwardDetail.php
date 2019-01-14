<?php
/**
 * @name AwardDetail
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Award Entry record for an individual award.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;
use App\Web\Model\Award;

use SilverStripe\ORM\DataObject;

class AwardDetail extends DataObject
{
    private static $db = [
        'Year'    => 'Varchar(20)',
        'Details' => 'HTMLText'
    ];

    private static $has_one = [
        'Award'   => Award::class
    ];

    private static $extensions = [
        SortOrder::class
    ];

    private static $summary_fields = [
        'Year'
    ];

    private static $table_name = 'AwardDetail';
    private static $singular_name = 'Entry';
    private static $plural_name = 'Entries';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->fieldByName('Root.Main.Details')
            ->setDescription('Limit this to 1 or 2 sentences.');

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function getTitle()
    {
        return $this->Year;
    }
}
