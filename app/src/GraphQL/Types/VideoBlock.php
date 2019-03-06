<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\ContentBlockTypeCreator;

use SilverStripe\Core\ClassInfo;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use Axllent\FormFields\FieldType\VideoLink;
use GraphQL\Type\Definition\Type;

class VideoBlockTypeCreator extends ContentBlockTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'VideoBlock'
        ];
    }

    // private static $db = [
    //     'VideoSource' => 'Enum(array("Internal","Enternal"))',
    //     'VideoLink' => VideoLink::class
    // ];
    //
    // /**
    //  * Has_one relationship
    //  * @var array
    //  */
    // private static $has_one = [
    //     'OptionalPreview' => Image::class,
    //     'VideoFile' => File::class
    // ];

    public function fields()
    {
        $preview = Connection::create(Classinfo::shortName($this) . 'Image')
            ->setConnectionType(function () {
                return $this->manager->getType('Image');
            })
            ->setDescription('optional preview image');

        return array_merge(parent::fields(), [
            'VideoSource' => ['type' => Type::string()],
            'VideoLink' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    $link = $obj->VideoLink;
                    return $link;
                }
            ],
            'OptionalPreview' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->OptionalPreview()->exists()) {
                        return $obj->OptionalPreview()->FitMax(1920, 1280)->getURL();
                    }
                    return null;
                }
            ],
            'VideoFile' => ['type' => $this->manager->getType('File')],
        ]);
    }
}
