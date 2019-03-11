<?php
/**
 * @name Latest.php
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Displays a news snippet linking to either an internal or external link.
 *
 * */
namespace App\Web\Model;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

class Latest extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'       => 'Varchar(100)',
        'SummaryText' => 'Varchar(255)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Image'       => Image::class,
        'Link'        => Link::class
    ];

    private static $extensions = [
        Versioned::class
    ];

    /**
     * Ensures that the methods are wrapped in the correct type and
     * values are safely escaped while rendering in the template.
     * @var array
     */
    private static $casting = [
        'SummaryText' => 'HTMLText'
    ];

    private static $versioned_gridfield_extensions = true;
    private static $singular_name = 'Latest Update';
    private static $plural_name = 'Latest Updates';
    private static $table_name = 'Latest';

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Title',
        'LastEdited'
    ];

    /**
     * Relationship version ownership
     * @var array
     */
    private static $owns = [
        'Link',
        'Image'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'LinkID'
        ]);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create(
                    'Link',
                    'Link',
                    $this
                )
            ]
        );

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
