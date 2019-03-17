<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class PersonPageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Person'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'Introduction' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Introduction);
                }
            ]
        ]);
    }
}
