<?php
/**
 * @file ￼Home
 * @author Simon Winter <simon@saltedherring.com>
 *
 *
 **/
namespace App\Web\Layout;

use Page;

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;

class HomePage extends Page
{
    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $content = HtmlEditorField::create(
            'Content',
            'Content'
        );

        $fields->addFieldToTab(
            'Root.Main',
            $content
        );

        return $fields;
    }
}
