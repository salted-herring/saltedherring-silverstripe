<?php
/**
 * @name ImageBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Block that contains one or more images.
 *
 * */
namespace App\Web\Model;

use App\Web\Model\ContentBlock;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

use Bummzack\SortableFile\Forms\SortableUploadField;

class ImageBlock extends ContentBlock
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Padding' => 'Boolean'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [];

    private static $many_many = [
        'Images' => Image::class
    ];

    private static $owns = [
        'Images'
    ];

    private static $many_many_extraFields = [
        'Images' => [
            'Sort'   => 'Int'
        ]
    ];

    private static $table_name = 'ImageBlock';

    private static $field_labels = [
        'Padding' => 'Add top and bottom padding?'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Images'
        ]);

        $fields->addFieldToTab(
            'Root.Main',
            SortableUploadField::create(
                'Images',
                'Images'
            )
            ->setDescription('If more than 1 image is supplied, the images are displayed as a slideshow.')
            ->setSortColumn('Sort')
            ->setFolderName('Projects/Images')
            ->setAllowedFileCategories('image')
            ->setIsMultiUpload(true)
        );

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
