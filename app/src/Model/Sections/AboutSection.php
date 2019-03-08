<?php
/**
 * @name AboutSection
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Sections to be added to the About Page.
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;
use App\Web\Layout\AboutPage;
use App\Web\Model\AboutContentBlock;
use App\Web\Model\TextBlock;

use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

use Colymba\BulkManager\BulkManager;
use SilverShop\HasOneField\HasOneButtonField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class AboutSection extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'HeroTitle'        => 'Varchar(100)',
        'HeroIntroduction' => 'Varchar(255)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Page'             => AboutPage::class,
        'Introduction'     => TextBlock::class
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Blocks'           => AboutContentBlock::class
    ];

    /**
     * Relationship version ownership
     * @var array
     */
    private static $owns = [
        'Blocks'
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'HeroTitle' => 'Title'
    ];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    /**
     * Ensures that the methods are wrapped in the correct type and
     * values are safely escaped while rendering in the template.
     * @var array
     */
    private static $casting = [
        'HeroIntroduction' => 'HTMLText'
    ];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'AboutSection';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField('HeroIntroduction',
            TextareaField::create(
                'HeroIntroduction',
                $this->fieldLabel('HeroIntroduction')
            )->setDescription('You can use html tags (such as &lt;b&gt;&lt;/b&gt; to bold text)')
        );

        $fields->replaceField('IntroductionID',
            HasOneButtonField::create($this, 'Introduction')
        );

        if ($this->exists()) {
            $blocks = $fields->fieldByName('Root.Blocks.Blocks');

            $blocks->getConfig()
                ->addComponent(
                    new GridFieldOrderableRows('SortOrder')
                )
                ->addComponent(new BulkManager(null, false, true))
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
        }



        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function getTitle() {
        return $this->HeroTitle;
    }
}
