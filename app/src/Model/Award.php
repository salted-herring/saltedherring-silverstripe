<?php
/**
 * @name Award
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Model to contain award entries.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;
use App\Web\Model\AwardProgramme;
use App\Web\Model\AwardDetail;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class Award extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'AwardProgramme' => AwardProgramme::class
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Entries' => AwardDetail::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'Award';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $entries = $fields->fieldByName('Root.Entries.Entries');

        if (!is_null($entries)) {
            $config = $entries->getConfig();

            $config
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
        }

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
