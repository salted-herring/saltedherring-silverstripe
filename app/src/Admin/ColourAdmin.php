<?php
namespace App\Web\Model\Admin;

use App\Web\Model\ColourTheme;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Security\Permission;

class ColourAdmin extends ModelAdmin
{
    private static $managed_models = [
        ColourTheme::class
    ];

    private static $url_segment = 'colour-themes';
    private static $menu_title = 'Colours';
    private static $menu_icon_class = 'font-icon-thumbnails';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm();
        $model = $this->sanitiseClassName($this->modelClass);
        $config = $form->Fields()->fieldByName($model)->getConfig();
        $delete = $config->getComponentByType('SilverStripe\Forms\GridField\GridFieldDeleteAction');

        $delete->setRemoveRelation(false);

        // if (!Permission::check('EDIT_COLOURTHEME')) {
        //     $config
        //         ->removeComponentsByType(GridFieldEditButton::class);
        // }

        return $form;
    }
}
