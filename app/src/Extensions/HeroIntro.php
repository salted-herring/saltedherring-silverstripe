<?php
/**
 * HeroIntro
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Adds intro text to a hero block.
 *
 * */
namespace App\Web\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;

class HeroIntro extends DataExtension
{
    private static $db = [
        'Introduction'            => 'Varchar(100)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertBefore('HeroTitle',
            TextareaField::create(
                'Introduction',
                'Introduction'
            )->setDescription('Short text intro/instruction.')
        );
    }
}
