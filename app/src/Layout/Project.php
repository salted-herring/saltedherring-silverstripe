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
use App\Web\Model\ImageBlock;
use App\Web\Model\VideoBlock;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\GraphQL\Scaffolding\Interfaces\ScaffoldingProvider;
use SilverStripe\GraphQL\Scaffolding\Scaffolders\SchemaScaffolder;

use GraphQL\Type\Definition\ResolveInfo;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class Project extends Page implements ScaffoldingProvider
{
    private static $db = [
        'Services'             => 'HTMLText',
        'Recognition'          => 'HTMLText',
        'Summary'              => 'Text',
        'RelatedProjectsTitle' => 'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'PreviewVideo' => File::class,
        'PreviewImage' => Image::class
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

    private static $owns = [
        'PreviewVideo',
        'PreviewImage'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab(
            'Root.Preview',
            [
                UploadField::create(
                    'PreviewVideo',
                    'Video'
                )
                ->setDescription('If you wish to use a video as the preview, upload a video file.')
                ->setAllowedFileCategories('video')
                ->setFolderName('Projects/Previews'),
                UploadField::create(
                    'PreviewImage',
                    'Image'
                )
                ->setDescription('If you wish to use an image as the preview (or add a poster for the video), upload an image file')
                ->setAllowedFileCategories('image')
                ->setFolderName('Projects/Previews')
            ]
        );

        $fields->addFieldsToTab(
            'Root.Tags',
            [
                HtmlEditorField::create(
                    'Services',
                    'Top Tags'
                ),
                HtmlEditorField::create(
                    'Recognition',
                    'Bottom Tags'
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
                TextBlock::class,
                ImageBlock::class,
                VideoBlock::class
            ]);
        }

        return $fields;
    }

    public function provideGraphQLScaffolding(SchemaScaffolder $scaffolder)
    {
        $scaffolder
            ->type('App\\Web\\Model\\ContentBlock')
                ->addFields(['ClassName', 'ID', 'Title', 'SortOrder'])
                ->operation(SchemaScaffolder::READ)
                    ->addArgs([
                        'ProjectSlug' => 'String'
                    ])
                    ->setResolver(function ($object, array $args, $context, ResolveInfo $info) {
                        $list = ContentBlock::get();

                        if (isset($args['ProjectSlug'])) {
                            $list = $list->filter('Project.URLSegment', $args['ProjectSlug']);
                        }
                        return $list;
                    })
                    ->end()
                ->end();

        return $scaffolder;
    }
}
