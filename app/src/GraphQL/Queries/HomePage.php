<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\HomePage;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadHomePageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readHomePage'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('HomePage'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $home = HomePage::get();

        if ($home->Count() == 1) {
            return $home->first();
        }

        return null;
    }
}
