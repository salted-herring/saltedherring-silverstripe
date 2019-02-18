<?php

namespace App\Web\GraphQL\Types;

use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class SectionBlockTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Section'
        ];
    }

    public function fields()
    {
        return [
            'ID'        => ['type' => Type::id()],
            'Title'     => ['type' => Type::string()],
            'Introduction' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Introduction);
                }
            ],
            'SortOrder' => ['type' => Type::int()]
        ];
    }
}
