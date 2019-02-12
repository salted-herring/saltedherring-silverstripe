<?php
/**
 * @name ContentBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A base content block that is added to a project
 *
 * */
namespace App\Web\Model;

use App\Web\Layout\Project;
use App\Web\Extensions\SortOrder;

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class ContentBlock extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Project' => Project::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'ContentBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $title = $fields->fieldByName('Root.Main.Title');
        $title->setDescription('<i style="color: red;">* required - for CMS display purposes (not displayed on the site)</i>');

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        if (empty($this->Title)) {
            $result->addError('Title is required for CMS Purposes.');
        }

        return $result;
    }
}
