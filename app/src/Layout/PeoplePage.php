<?php
/**
 * @file ￼PeoplePage.php
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Landing Page for People pages.
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Extensions\HeroIntro;
use App\Web\Model\Latest;
use App\Web\Model\ColourTheme;
use App\Web\Layout\PersonPage;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Lumberjack\Model\Lumberjack;

use Bummzack\SortableFile\Forms\SortableUploadField;
use Colymba\BulkManager\BulkManager;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class PeoplePage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'ShowPartners'             => 'Boolean',
        'PartnersTitle'            => 'Varchar(100)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'PartnersBackgroundColour' => ColourTheme::class
    ];

    private static $many_many = [
        'Partners'             => Latest::class
    ];

    private static $many_many_extraFields = [
        'Partners'             => [
            'SortOrder'   => 'Int'
        ]
    ];

    private static $field_labels = [
        'ShowPartners' => 'Show Partners section?'
    ];

    private static $owns = [
        'Partners'
    ];

    private static $extensions = [
        Lumberjack::class,
        HeroIntro::class
    ];

    private static $allowed_children = [
        PersonPage::class
    ];

    private static $table_name = 'PeoplePage';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $colours = [];

        foreach (ColourTheme::get() as $colour) {
            $colours[$colour->ID . ""] = '#' . $colour->Colour;
        }

        $fields->addFieldsToTab(
            'Root.Main',
            [
                HtmlEditorField::create(
                    'Content',
                    $this->fieldLabel('Content')
                )
            ]
        );

        $fields->addFieldsToTab(
            'Root.Partners',
            [
                CheckboxField::create(
                    'ShowPartners',
                    $this->fieldLabel('ShowPartners')
                ),
                TextField::create(
                    'PartnersTitle',
                    $this->fieldLabel('PartnersTitle')
                ),
                ColorPaletteField::create(
                    'PartnersBackgroundColourID',
                    $this->fieldLabel('PartnersBackgroundColour'),
                    $colours
                )
                ->setDescription('This colour will be applied to the background of the partners section.'),
                $partners = GridField::create(
                    'Partners',
                    'Partners',
                    $this->Partners(),
                    $partnersConfig = GridFieldConfig_RelationEditor::create()
                        ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                        ->addComponent(
                            new GridFieldOrderableRows('SortOrder')
                        )
                )
            ]
        );

        $button = $partnersConfig->getComponentByType(GridFieldAddNewButton::class);
        $button->setButtonName('Add Partner');


        $childConfig = $fields
            ->fieldByName('Root.ChildPages.ChildPages')
            ->getConfig();

        $childConfig
            ->addComponent(
                new GridFieldOrderableRows('Sort')
            )
            ->addComponent(new BulkManager(null, false, true));

        return $fields;
    }
}
