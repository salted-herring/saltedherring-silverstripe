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

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

class QuoteBlock extends DataExtension
{
    private static $db = [
        'ShowQuote' => 'Boolean',
        'Quote'     => 'Text',
        'Source'    => 'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'SourceLink' => Link::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'SourceLinkID'
        ]);

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
                ),
                LinkField::create(
                    'SourceLink',
                    $this->owner->fieldLabel('SourceLink'),
                    $this->owner
                )
            ]
        );
    }
}
