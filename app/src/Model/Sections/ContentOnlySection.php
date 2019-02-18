<?php
/**
 * @file ￼ContentOnlySection
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A section that only includes a content block & optional background image.
 */
namespace App\Web\Model;

use App\Web\Model\Section;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class ContentOnlySection extends Section
{
    private static $db = [
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $table_name = 'ContentOnlySection';
}
