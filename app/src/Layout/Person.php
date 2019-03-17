<?php
/**
 * @file ￼Person
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Layout model for people page.
 **/
namespace App\Web\Layout;

use Page;
use App\Web\Extensions\HeroIntro;

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;

class PersonPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Introduction'     => 'HTMLText'
    ];

    private static $extensions = [
        HeroIntro::class
    ];

    private static $show_in_sitetree = false;
    private static $allowed_children = [];
    private static $table_name = 'PersonPage';

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                HtmlEditorField::create(
                    'Introduction',
                    $this->fieldLabel('Introduction')
                )
                ->setDescription('Displayed in the header of the page - i.e. the person\'s name etc.'),
                HtmlEditorField::create(
                    'Content',
                    $this->fieldLabel('Content')
                )
            ]
        );
        return $fields;
    }
}
