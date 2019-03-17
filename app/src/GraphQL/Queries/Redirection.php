<?php

namespace App\Web\GraphQL\Queries;

use SilverStripe\RedirectedURLs\Model\RedirectedURL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class RedirectorQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readRedirector'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('Redirection'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        return RedirectedURL::get();
    }
}
