<?php
/**
 * @file ￼ColourTheme
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Provides a model which can be used to add colours to different sections
 * throughout the site.
 */
namespace App\Web\Model;

use Page;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Storage\AssetStore;
use SilverStripe\Assets\FileFinder;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Versioned\Versioned;

use TractorCow\Colorpicker\Color;
use TractorCow\Colorpicker\Forms\ColorField;

class ColourTheme extends DataObject
{
    private static $db = [
        'Name'         => 'Varchar(100)',
        'Colour'       => Color::class
    ];

    private static $summary_fields = [
        'gettheColour' => 'Colour',
        'Name'         => 'Name'
    ];

    private static $searchable_fields = [
        'Name'
    ];

    private static $table_name = 'ColourTheme';
    private static $singular_name = 'Colour';
    private static $plural_name = 'Colours';

    public function validate()
    {
        $result = parent::validate();

        if (empty($this->Title)) {
            $result->addError('A name is required to help identify this colour in the CMS.');
        }

        return $result;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            'Root.Main',
            ColorField::create('Colour', 'Theme colour')
        );

        $fields->removeByName('LinkTracking');
        $fields->removeByName('FileTracking');

        return $fields;
    }

    public function gettheColour()
    {
        return DBField::create_field(
            'HTMLVarchar',
            sprintf(
                '<div style="width:40px;height:40px;background-color:#%s;"/>',
                $this->Colour
            )
        );
    }

    public function getColourName()
    {
        $name = strtolower($this->Name);
        return preg_replace('/\s/', '-', preg_replace('/[^\da-z\s]/', '', trim($name)));
    }
}
