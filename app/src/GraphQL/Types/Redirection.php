<?php

namespace App\Web\GraphQL\Types;

use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class RedirectionTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Redirection'
        ];
    }

    public function fields()
    {
        return [
            'FromBase'        => ['type' => Type::string()],
            'FromQuerystring' => ['type' => Type::string()],
            'To'              => ['type' => Type::string()]
        ];
    }
}
