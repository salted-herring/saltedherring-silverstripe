<?php
/**
 * @name VideoBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A Video Block - can contain either a self hosted or vimeo video
 *
 * */
namespace App\Web\Model;

use App\Web\Model\ContentBlock;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataObject;

use Axllent\FormFields\FieldType\VideoLink;
use Axllent\FormFields\Forms\VideoLinkField;

class VideoBlock extends ContentBlock
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'VideoSource' => 'Enum(array("Internal","External"))',
        'VideoLink' => VideoLink::class
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'OptionalPreview' => Image::class,
        'VideoFile' => File::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];
    private static $owns = [
        'OptionalPreview',
        'VideoFile'
    ];

    private static $table_name = 'VideoBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->fieldByName('Root.Main.VideoSource')
            ->setDescription('choose whether to use the supplied internal or external video (below)');

        $fields->addFieldsToTab('Root.Main', [
            ToggleCompositeField::create('InternalVideo', 'Self Hosted Video', [
                $fields->fieldByName('Root.Main.VideoFile')
                    ->setFolderName('Projects/Videos')
                    ->setAllowedFileCategories('video'),
                $fields->fieldByName('Root.Main.OptionalPreview')
                    ->setFolderName('Projects/Videos')
                    ->setAllowedFileCategories('image')
                    ->setDescription('Shown to users before video is loaded')
            ])
                ->setStartClosed(false),
            VideoLinkField::create('VideoLink', 'External Video')
                ->showPreview(1920)
        ]);

        $fields->insertAfter('InternalVideo',
            $fields->fieldByName('Root.Main.VideoLink')
                ->setDescription('')
        );

        $fields->removeByName([
            'VideoFile',
            'OptionalPreview'
        ]);

        // $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
