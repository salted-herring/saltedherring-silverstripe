<?php
/**
 * @name AboutContentBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A content block for an about page section carousel.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;
use App\Web\Extensions\QuoteBlock;
use App\Web\Model\AboutSection;

use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class AboutContentBlock extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'        => 'Varchar(100)',
        'Introduction' => 'Varchar(255)',
        'Details'      => 'HTMLText'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Section'      => AboutSection::class
    ];

    /**
     * Ensures that the methods are wrapped in the correct type and
     * values are safely escaped while rendering in the template.
     * @var array
     */
    private static $casting = [
        'Title'        => 'HTMLText',
        'Introduction' => 'HTMLText'
    ];

    private static $extensions = [
        SortOrder::class,
        QuoteBlock::class,
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'AboutContentBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $description = 'You can use html tags (such as &lt;b&gt;&lt;/b&gt; to bold text)';

        $fields->replaceField('Title',
            TextareaField::create(
                'Title',
                $this->fieldLabel('Title')
            )->setDescription($description)
        );

        $fields->replaceField('Introduction',
            TextareaField::create(
                'Introduction',
                $this->fieldLabel('Introduction')
            )->setDescription(
                $description .
                '<br>' .
                'Enter text here if you wish to allow for a "show more" option.'
            )
        );

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
