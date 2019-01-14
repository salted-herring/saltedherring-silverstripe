<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class AwardDetailTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'AwardDetail'
        ];
    }

    public function fields()
    {
        return [
            'ID'      => ['type' => Type::id()],
            'Year'    => ['type' => Type::string()],
            'Details' => ['type' => Type::string()]
        ];
    }
}
