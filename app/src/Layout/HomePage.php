<?php

/**
 * @file ￼Home
 * @author Simon Winter <simon@saltedherring.com>
 *
 *
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Model\Latest;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TextField;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class HomePage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'LatestSectionTitle' => 'Varchar(100)'
    ];

    private static $many_many = [
        'Latest'             => Latest::class
    ];

    private static $many_many_extraFields = [
        'Latest'             => [
            'SortOrder'   => 'Int'
        ]
    ];

    private static $owns = [
        'Latest'
    ];

    private static $table_name = 'HomePage';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $content = HtmlEditorField::create(
            'Content',
            $this->fieldLabel('Content')
        );

        $fields->addFieldToTab(
            'Root.Main',
            $content
        );

        $latest = GridField::create(
            'Latest',
            'Latest Updates',
            $this->Latest(),
            GridFieldConfig_RelationEditor::create()
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                ->addComponent(
                    new GridFieldOrderableRows('SortOrder')
                )
        );

        $fields->addFieldsToTab(
            'Root.Latest',
            [
                TextField::create(
                    'LatestSectionTitle',
                    $this->fieldLabel('LatestSectionTitle')
                ),
                $latest
            ]
        );

        return $fields;
    }
}
