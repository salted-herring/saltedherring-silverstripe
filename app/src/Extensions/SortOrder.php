<?php
/**
 * SortOrder
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Add SortOrder field & orders records on a model.
 *
 * */
namespace App\Web\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class SortOrder extends DataExtension
{
    private static $db = [
        'SortOrder' => 'Int'
    ];

    private static $default_sort = 'SortOrder ASC';

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'SortOrder'
        ]);
    }
}
