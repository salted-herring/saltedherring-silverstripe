<?php
/**
 * @name TextBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A text block with an optional quote block.
 *
 * */
namespace App\Web\Model;

use App\Web\Model\ContentBlock;

use SilverStripe\ORM\DataObject;

class TextBlock extends ContentBlock
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Alignment' => 'Enum(array("left", "right"), "left")',
        'Content'   => 'HTMLText',
        'ShowQuote' => 'Boolean',
        'Quote'     => 'Text',
        'Source'    => 'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'TextBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->fieldByName('Root.Main.Alignment')
            ->setDescription('Set the alignment of the content - if no quote is displayed, the block is aligned centrally');

        $fields->addFieldsToTab(
            'Root.Quote',
            [
                $fields->fieldByName('Root.Main.ShowQuote')
                    ->setDescription('will display a quote to left or right of main content (depending on alignment chosen)'),
                $fields->fieldByName('Root.Main.Quote'),
                $fields->fieldByName('Root.Main.Source')
            ]
        );

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
