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

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Taxonomy\TaxonomyTerm;

class Project extends Page
{
    private static $db = [
        'Recognition' => 'HTMLText'
    ];

    private static $many_many =  [
        'Terms' => TaxonomyTerm::class
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
                ListboxField::create(
                    'Terms',
                    'Terms',
                    TaxonomyTerm::get()
                ),
                HtmlEditorField::create(
                    'Recognition',
                    'Recognition'
                )
            ]
        );

        return $fields;
    }
}
