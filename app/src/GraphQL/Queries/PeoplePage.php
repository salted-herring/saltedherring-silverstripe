<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\PeoplePage;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadPeoplePageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readPeoplePage'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('PeoplePage'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $page = PeoplePage::get();

        if ($page->Count() == 1) {
            return $page->first();
        }

        return null;
    }
}
