<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Model\AwardProgramme;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class AwardProgrammesQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readAwardProgrammes'
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('AwardProgramme'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        return AwardProgramme::get();
    }
}
