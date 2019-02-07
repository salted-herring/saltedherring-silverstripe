<?php

namespace App\Web\GraphQL\Queries;

use Page;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadMenuQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readMenu'
        ];
    }

    public function args()
    {
        return [
            'menuType' => ['type' => Type::string()]
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('Menu'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $menuType = 'ShowInMain';

        if (isset($args['menuType'])) {
            $menuType = $args['menuType'];
        }

        return singleton(Page::class)->SortableMenu($menuType);
    }
}
