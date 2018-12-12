<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Model\Latest;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\Assets\Image;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadLatestQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readLatest'
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
        return Type::listOf($this->manager->getType('Latest'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $list = Latest::get();

        if (isset($args['ID'])) {
            $list = $list->filter('ID', $args['ID']);
        }

        return $list;
    }
}
