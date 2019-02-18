<?php
/**
 * QuoteExtension
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Addsa a quote to a model
 *
 * */
namespace App\Web\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;

class QuoteBlock extends DataExtension
{
    private static $db = [
        'ShowQuote' => 'Boolean',
        'Quote'     => 'Text',
        'Source'    => 'Text'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            'Root.Quote',
            [
                CheckboxField::create(
                    'ShowQuote',
                    'Display Quote?'
                ),
                TextareaField::create(
                    'Quote',
                    'Quote'
                ),
                TextareaField::create(
                    'Source',
                    'Source'
                )
            ]
        );
    }
}
