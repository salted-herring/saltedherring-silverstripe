<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\AboutPage;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadAboutPageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readAboutPage'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('AboutPage'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $page = AboutPage::get();

        if ($page->Count() == 1) {
            return $page->first();
        }

        return null;
    }
}
