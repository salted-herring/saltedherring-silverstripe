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
use App\Web\Extensions\QuoteBlock;

use SilverStripe\ORM\DataObject;

class TextBlock extends ContentBlock
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Alignment' => 'Enum(array("left", "right"), "left")',
        'Content'   => 'HTMLText'
    ];

    private static $extensions = [
        QuoteBlock::class
    ];

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

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function getType() {
        $type = $this->singular_name();

        if ($this->ShowQuote) {
            $type .= ' (includes a quote)';
        }

        return $type;
    }
}
