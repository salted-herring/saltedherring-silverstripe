<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Model\FooterDetail;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadFooterDetailQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readFooter'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('FooterDetail'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        return FooterDetail::get();
    }
}
