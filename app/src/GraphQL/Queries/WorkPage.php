<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\WorkPage;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadWorkPageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readWorkPage'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('WorkPage'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $page = WorkPage::get();

        if ($page->Count() == 1) {
            return $page->first();
        }

        return null;
    }
}
