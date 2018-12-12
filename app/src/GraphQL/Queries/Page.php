<?php

namespace App\Web\GraphQL\Queries;

use Page;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadPageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readPage'
        ];
    }

    public function args()
    {
        return [
            'ID' => ['type' => Type::int()]
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('Page'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $list = Page::get();

        if (isset($args['ID'])) {
            $list = $list->filter('ID', $args['ID']);
        }

        return $list;
    }
}
