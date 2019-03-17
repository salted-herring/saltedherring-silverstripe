<?php

/**
 * Hero extension
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Adds a hero to each page.
 *
 * */
namespace App\Web\Extensions;

use App\Web\Model\ColourTheme;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

use Bummzack\SortableFile\Forms\SortableUploadField;
use Heyday\ColorPalette\Fields\ColorPaletteField;

class HeroExtension extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'HeroTitle'        => 'Varchar(100)',
        'HeroMenuColour'   => 'Enum(array("black", "white"))'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'HeroVideo'        => File::class,
        'BackgroundColour' => ColourTheme::class,
        'TitleColour'      => ColourTheme::class
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $many_many = [
        'HeroImages'       => Image::class
    ];

    private static $owns = [
        'HeroImages',
        'HeroVideo'
    ];

    private static $many_many_extraFields = [
        'HeroImages' => [
            'Sort'   => 'Int'
        ]
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $colours = [];

        foreach (ColourTheme::get() as $colour) {
            $colours[$colour->ID . ""] = '#' . $colour->Colour;
        }

        $fields->addFieldsToTab(
            'Root.Hero',
            [
                TextField::create(
                    'HeroTitle',
                    'Title'
                )
                ->setDescription('Title as shown in the background of the page (if not present will use the page name)'),
                DropdownField::create(
                    'HeroMenuColour',
                    'Menu Colour',
                    singleton(get_class($this->owner))->dbObject('HeroMenuColour')->enumValues()
                )
                ->setDescription('If the header needs to use the white menu, choose that here.'),
                ColorPaletteField::create(
                    'BackgroundColourID',
                    'Hero Background Colour',
                    $colours
                )
                ->setDescription('This colour will be applied to the background of the hero/page.'),
                ColorPaletteField::create(
                    'TitleColourID',
                    'Title Colour',
                    $colours
                )
                ->setDescription('This colour will be applied to the title used on the page.'),
                UploadField::create(
                    'HeroVideo',
                    'video'
                )
                ->setDescription('If you wish to use a video as the hero background, upload a video file.')
                ->setAllowedFileCategories('video')
                ->setFolderName('Heros/Videos'),
                SortableUploadField::create(
                    'HeroImages',
                    'Images'
                )
                ->setDescription('If no video is supplied, we\'ll use any supplied hero images. If more than 1 image is supplied, the images are displayed as a slideshow.')
                ->setSortColumn('Sort')
                ->setFolderName('Heros/Images')
                ->setAllowedFileCategories('image')
                ->setIsMultiUpload(true)
            ]
        );

        return $fields;
    }
}
