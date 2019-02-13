<?php
/**
 * @name ContentBlock
 * @author Simon Winter <simon@saltedherring.com>
 *
 * A base content block that is added to a project
 *
 * */
namespace App\Web\Model;

use App\Web\Extensions\SortOrder;
use App\Web\Layout\Project;
use App\Web\Model\ImageBlock;
use App\Web\Model\TextBlock;
use App\Web\Model\VideoBlock;

use SilverStripe\Core\ClassInfo;
use SilverStripe\GraphQL\Scaffolding\Interfaces\ScaffoldingProvider;
use SilverStripe\GraphQL\Scaffolding\Scaffolders\SchemaScaffolder;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Hierarchy\Hierarchy;
use SilverStripe\Versioned\Versioned;

use GraphQL\Type\Definition\ResolveInfo;

class ContentBlock extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $extensions = [
        SortOrder::class,
        Versioned::class
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Project' => Project::class
    ];

    /**
     * Add default values to database
     * @var array
     */
    private static $defaults = [];

    private static $versioned_gridfield_extensions = true;
    private static $table_name = 'ContentBlock';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $title = $fields->fieldByName('Root.Main.Title');
        $title->setDescription('<i style="color: red;">* required - for CMS display purposes (not displayed on the site)</i>');

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        if (empty($this->Title)) {
            $result->addError('Title is required for CMS Purposes.');
        }

        return $result;
    }

    // public function provideGraphQLScaffolding(SchemaScaffolder $scaffolder)
    // {
    //     $scaffolder
    //         ->type(ContentBlock::class)
    //             ->addFields(['ID', 'Title', 'SortOrder'])
    //             ->operation(SchemaScaffolder::READ)
    //                 ->end()
    //             ->end();
    //
    //     return $scaffolder;
    // }
    public function canView($member = null, $context = [])
    {
        return true;
    }
    public function canEdit($member = null, $context = [])
    {
        return true;
    }
    public function canCreate($member = null, $context = [])
    {
        return true;
    }
    public function canDelete($member = null, $context = [])
    {
        return true;
    }
}
