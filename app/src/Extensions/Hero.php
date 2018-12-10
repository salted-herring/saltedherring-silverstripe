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

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class HeroExtension extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'HeroTitle' => 'Varchar(100)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'HeroVideo' => File::class,
        'BackgroundColour' => ColourTheme::class,
        'TitleColour' => ColourTheme::class
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'HeroImages' => Image::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
    }
}
