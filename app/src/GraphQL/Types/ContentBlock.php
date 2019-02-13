<?php

namespace App\Web\GraphQL\Types;

use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class ContentBlockTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'ContentBlock'
        ];
    }

    public function fields()
    {
        return [
            'ID'        => ['type' => Type::id()],
            'Title'     => ['type' => Type::string()],
            'SortOrder' => ['type' => Type::int()]
        ];
    }
}
