<?php
/**
 * @name AwardProgramme
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Container for Awards.
 *
 * */
namespace App\Web\Model;

use Page;
use App\Web\Extensions\SortOrder;
use App\Web\Model\Award;
use App\Web\Model\ColourTheme;

use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class AwardProgramme extends DataObject
{
    private static $db = [
        'Title'     => 'Varchar(100)'
    ];

    private static $has_one = [
        'Link'      => Link::class,
        'Page'      => Page::class
    ];

    private static $has_many = [
        'Awards'    => Award::class
    ];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    private static $owns = [
        'Link'
    ];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'AwardProgramme';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'LinkID'
        ]);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create(
                    'Link',
                    'Link',
                    $this
                )
            ]
        );

        $awards = $fields->fieldByName('Root.Awards.Awards');
        $config = $awards->GetConfig();

        $config
            ->addComponent(new GridFieldOrderableRows('SortOrder'))
            ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
