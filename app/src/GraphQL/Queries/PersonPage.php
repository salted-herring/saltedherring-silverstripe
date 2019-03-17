<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\PersonPage;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\Assets\Image;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadPersonPageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readPerson'
        ];
    }

    public function args()
    {
        return [
            'ID'         => ['type' => Type::int()],
            'URLSegment' => ['type' => Type::string()]
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('Person'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $list = PersonPage::get();

        if (isset($args['ID'])) {
            $list = $list->filter('ID', $args['ID']);
        }

        if (isset($args['URLSegment'])) {
            $list = $list->filter('URLSegment', $args['URLSegment']);
        }

        return $list;
    }
}
