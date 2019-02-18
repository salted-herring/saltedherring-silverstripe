<?php
/**
 * @name BlocksSection
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A section with blocks.
 *
 * */
namespace App\Web\Model;

use App\Web\Model\Section;
use App\Web\Model\SectionBlock;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\DataObject;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class BlocksSection extends Section
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'DisplayContent' => 'Boolean',
        'Content' => 'HTMLText'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [];

    private static $has_many = [
        'Blocks' => SectionBlock::class,
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $field_labels = [
        'DisplayContent' => 'Display Content on this section?'
    ];

    private static $table_name = 'BlocksSection';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $this->extend('updateCMSFields', $fields);

        if ($this->exists()) {
            $grid = $fields->fieldByName('Root.Blocks.Blocks');

            $grid->getConfig()
            ->addComponent(
                new GridFieldOrderableRows('SortOrder')
            )
            ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
        }

        return $fields;
    }
}
