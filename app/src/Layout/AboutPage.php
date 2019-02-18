<?php
/**
 * @file ￼About
 * @author Simon Winter <simon@saltedherring.com>
 *
 * About Page.
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Model\ColourTheme;
use App\Web\Model\Section;
use App\Web\Model\BlocksSection;
use App\Web\Model\ContentOnlySection;
use App\Web\Model\IntroductionSection;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

use Heyday\ColorPalette\Fields\ColorPaletteField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class AboutPage extends Page
{
    private static $allowed_children = [];
    private static $description = 'About us page.';

    private static $table_name = 'AboutUs';

    /**
     * Database fields
     * @var array
     */
    private static $db = [

    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'BackgroundColour' => ColourTheme::class,
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Sections' => Section::class,
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Hero');

        $colours = [];

        foreach (ColourTheme::get() as $colour) {
            $colours[$colour->ID . ""] = '#' . $colour->Colour;
        }

        $fields->addFieldToTab(
            'Root.Main',
            ColorPaletteField::create(
                'BackgroundColourID',
                'Page Background Colour',
                $colours
            )
            ->setDescription('This colour will be applied to the background of the page.')
        );

        if ($this->exists()) {
            $fields->addFieldsToTab(
                'Root.Sections',
                [
                    GridField::create(
                        'Sections',
                        'Sections',
                        $this->Sections(),
                        GridFieldConfig_RelationEditor::create()
                            ->addComponent(
                                new GridFieldOrderableRows('SortOrder')
                            )
                            ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                            ->removeComponentsByType(GridFieldAddNewButton::class)
                            ->addComponent($multi = new GridFieldAddNewMultiClass())
                    )
                ]
            );

            $multi->setClasses([
                BlocksSection::class,
                ContentOnlySection::class,
                IntroductionSection::class
            ]);
        }

        return $fields;
    }
}
