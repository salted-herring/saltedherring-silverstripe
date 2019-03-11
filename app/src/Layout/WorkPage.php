<?php
/**
 * @file ￼WorkPage.php
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Landing Page for Work projects.
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Extensions\HeroIntro;
use App\Web\Layout\ProjectPage;
use App\Web\Model\AwardProgramme;
use App\Web\Model\ColourTheme;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Lumberjack\Model\Lumberjack;

use Bummzack\SortableFile\Forms\SortableUploadField;
use Colymba\BulkManager\BulkManager;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class WorkPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'ShowAwards'              => 'Boolean',
        'AwardsTitle'             => 'Varchar(100)',
        'ShowClients'             => 'Boolean',
        'ClientsTitle'            => 'Varchar(100)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'AwardsBackgroundColour'  => ColourTheme::class,
        'ClientsBackgroundColour' => ColourTheme::class
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Programmes'              => AwardProgramme::class
    ];

    private static $many_many = [
        'ClientLogos'             => Image::class
    ];

    private static $many_many_extraFields = [
        'ClientLogos' => [
          'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Programmes',
        'ClientLogos'
    ];

    private static $extensions = [
        Lumberjack::class,
        HeroIntro::class
    ];

    private static $allowed_children = [
        Project::class
    ];

    private static $table_name = 'WorkPage';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $colours = [];

        foreach (ColourTheme::get() as $colour) {
            $colours[$colour->ID . ""] = '#' . $colour->Colour;
        }

        $fields->addFieldsToTab(
            'Root.Awards',
            [
                CheckboxField::create(
                    'ShowAwards',
                    'Show Awards Section?'
                ),
                TextField::create(
                    'AwardsTitle',
                    'Awards Title'
                ),
                ColorPaletteField::create(
                    'AwardsBackgroundColourID',
                    'Awards Background Colour',
                    $colours
                )
                ->setDescription('This colour will be applied to the background of the awards section.'),
                GridField::create(
                    'Programmes',
                    'Programmes',
                    $this->Programmes(),
                    GridFieldConfig_RelationEditor::create()
                        ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                        ->addComponent(new GridFieldOrderableRows('SortOrder'))
                )
            ]
        );

        $fields->addFieldsToTab(
            'Root.Clients',
            [
                CheckboxField::create(
                    'ShowClients',
                    'Show Clients Section?'
                ),
                TextField::create(
                    'ClientsTitle',
                    'Clients Title'
                ),
                ColorPaletteField::create(
                    'ClientsBackgroundColourID',
                    'Clients Background Colour',
                    $colours
                )
                ->setDescription('This colour will be applied to the background of the clients section.'),
                SortableUploadField::create(
                    'ClientLogos',
                    'Client Logos'
                )
                ->setSortColumn('SortOrder')
                ->setFolderName('Work/ClientLogos')
                ->setAllowedFileCategories('image')
                ->setIsMultiUpload(true)
            ]
        );


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
