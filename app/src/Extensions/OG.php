<?php

namespace App\Web\Extensions;

use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;
use SaltedHerring\Salted\Cropper\Fields\CroppableImageField;

/**
 * @file SocialTagExtension
 *
 * Extension to provide Open Graph tags to page types.
 */
class OpenGraphExtension extends DataExtension
{
    private static $db = [
        'OGType'                =>  'Enum("website,article,blog,product")',
        'OGTitle'               =>  'Varchar(255)',
        'OGTitleAsDefault'      =>  'Boolean',
        'OGDescription'         =>  'Varchar(255)',
        'OGDescAsDefault'       =>  'Boolean'
    ];

    private static $has_one =  [
        'OGImage'               =>  SaltedCroppableImage::class,
        'OGImageLarge'          =>  SaltedCroppableImage::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [
        'OGTitleAsDefault'      =>  true,
        'OGDescAsDefault'       =>  true
    ];

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $is_site_config                             =   true;//$this->owner->ClassName == 'SilverStripe\SiteConfig\SiteConfig';

        if ($this->owner->OGTitleAsDefault) {
            $this->owner->OGTitle                   =   !empty($this->owner->MetaTitle) ?
                                                        $this->owner->MetaTitle :
                                                        $this->owner->Title;
        }

        if (!$is_site_config) {
            if ($this->owner->OGDescAsDefault) {
                $this->owner->OGDescription         =   $this->owner->MetaDescription;
            }
        }
    }


    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $is_site_config         =   true;//$this->owner->ClassName == 'SilverStripe\SiteConfig\SiteConfig';

        $fields->removeFieldsFromTab('Root.Main', [
            'OGTitle',
            'OGDescription',
            'OGType',
            'OGTitleAsDefault',
            'OGDescAsDefault',
            'OGImageID',
            'OGImageLargeID'
        ]);

        if (empty($fields->fieldByName('Root.SEO.OG'))) {
            $og_type            =   DropdownField::create(
                'OGType',
                'Type',
                singleton($this->owner->ClassName)->dbObject('OGType')->enumValues()
            );
            $og_title_default   =   CheckboxField::create(
                'OGTitleAsDefault',
                'Use Meta Title as OG Title'
            )->setDescription('If meta title is not set, it will use page title instead');
            $og_title           =   TextField::create(
                'OGTitle',
                'Title'
            );
            $og_desc_default    =   CheckboxField::create(
                'OGDescAsDefault',
                'Use Meta Description as OG Description'
            );
            $og_desc            =   TextareaField::create(
                'OGDescription',
                'Description'
            );
            $og_image           =   CroppableImageField::create('OGImageID', 'Square Image')
                                        ->setCropperRatio(1)
                                        ->setDescription('Image must be uploaded at a ratio of 1:1 (square)');
            $og_large_image     =   CroppableImageField::create('OGImageLargeID', 'Landscape Image')
                                        ->setCropperRatio(1200/630)
                                        ->setDescription('Image must be uploaded at a ratio of 1200/630 (landscape)');

            $og                 =   ToggleCompositeField::create(
                'OG',
                'Open Graph Tags',
                [
                                            $og_type,
                                            $og_title_default,
                                            $og_title,
                                            $og_desc_default,
                                            $og_desc,
                                            $og_image,
                                            $og_large_image ]
            );

            // $OGImage->setDescription('Image must be uploaded at a ratio of 1200px x 627px.');
            $fields->addFieldToTab('Root.SEO', $og);
        }
    }
}
