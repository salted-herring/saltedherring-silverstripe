<?php
/**
 * @file ￼Project
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Project page - child of Work page.
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Extensions\HeroIntro;
use App\Web\Model\ContentBlock;
use App\Web\Model\TextBlock;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TextareaField;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class Project extends Page
{
    private static $db = [
        'Services'             => 'HTMLText',
        'Recognition'          => 'HTMLText',
        'Summary'              => 'Text',
        'RelatedProjectsTitle' => 'Text'
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'ContentBlocks' => ContentBlock::class
    ];

    /**
     * Many_many relationship
     * @var array
     */
    private static $many_many = [
        'RelatedProjects'      => self::class
    ];

    /**
     * Defines Database fields for the Many_many bridging table
     * @var array
     */
    private static $many_many_extraFields = [
        'RelatedProjects' => [
            'Sort' => 'Int'
        ]
    ];

    private static $belongs_many_many = [
        'Related' => 'Project.RelatedProjects'
    ];

    private static $defaults = [
        'RelatedProjectsTitle' => "Some other projects\n you might find interesting"
    ];

    private static $extensions = [
        HeroIntro::class
    ];

    private static $show_in_sitetree = false;
    private static $allowed_children = [];
    private static $description = 'A project\'s page.';

    private static $table_name = 'Project';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab(
            'Root.Tags',
            [
                HtmlEditorField::create(
                    'Services',
                    'Services'
                ),
                HtmlEditorField::create(
                    'Recognition',
                    'Recognition'
                )
            ]
        );

        $fields->addFieldToTab(
            'Root.Main',
            TextareaField::create(
                'Summary',
                'Summary'
            )
            ->setDescription('Short introduction to the project.')
        );

        if ($this->exists()) {
            $fields->addFieldsToTab(
                'Root.RelatedProjects',
                [
                    TextareaField::create(
                        'RelatedProjectsTitle',
                        'Related Projects Title'
                    ),
                    GridField::create(
                        'RelatedProjects',
                        'Related Projects',
                        $this->RelatedProjects(),
                        GridFieldConfig_RelationEditor::create()
                            ->addComponent(
                                new GridFieldOrderableRows('Sort')
                            )
                    )
                ]
            );

            $fields->addFieldsToTab(
                'Root.Blocks',
                [
                    GridField::create(
                        'ContentBlocks',
                        'Content Blocks',
                        $this->ContentBlocks(),
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
                TextBlock::class
            ]);
        }

        return $fields;
    }
}
