<?php
/**
 * @name Section
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Section to add to the About us page.
 *
 * */
namespace App\Web\Model;

use Page;
use App\Web\Extensions\SortOrder;

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Section extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(100)',
        'Introduction' => 'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Page' => Page::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'Section';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $title = $fields->fieldByName('Root.Main.Title');
        $title->setDescription('Display as background text.');

        $intro = $fields->fieldByName('Root.Main.Introduction');
        $intro->setDescription('you can use &lt;b&gt; and &lt;i&gt; tags to emphasise text.');

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
