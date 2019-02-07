<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class FooterDetailTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'FooterDetail'
        ];
    }

    public function fields()
    {
        return [
            'ID'        => ['type' => Type::int()],
            'Title'     => ['type' => Type::string()],
            'Content'   => ['type' => Type::string()],
            'SortOrder' => ['type' => Type::int()]
        ];
    }
}
