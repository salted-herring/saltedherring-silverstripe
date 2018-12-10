<?php

namespace {

    use App\Web\Extensions\HeroExtension;
    use App\Web\Extensions\MetaExtension;
    use App\Web\Extensions\OpenGraphExtension;

    use SilverStripe\CMS\Model\SiteTree;

    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [];

        /**
         * Defines extension names and parameters to be applied
         * to this object upon construction.
         * @var array
         */
        private static $extensions = [
            HeroExtension::class,
            MetaExtension::class,
            OpenGraphExtension::class
        ];

        /**
         * CMS Fields
         * @return FieldList
         */
        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->removeByName([
                'Content'
            ]);
            return $fields;
        }
    }
}
