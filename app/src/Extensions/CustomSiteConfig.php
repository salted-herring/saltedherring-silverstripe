<?php
/**
 * Site Config Extension
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Adds custom site config.
 *
 * */
namespace App\Web\Extensions;

use App\Web\Model\FooterDetail;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataExtension;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class CustomSiteConfig extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $footerDetails = GridField::create(
            'FooterDetails',
            'Footer Details',
            FooterDetail::get(),
            GridFieldConfig_RelationEditor::create()
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
        );

        $fields->addFieldToTab("Root.Footer",
            $footerDetails
        );
    }
}
