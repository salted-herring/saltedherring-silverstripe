<?php

namespace App\Web\GraphQL\Queries;

use App\Web\Layout\Project;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\Assets\Image;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

class ReadProjectPageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readProject'
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
        return Type::listOf($this->manager->getType('Project'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $list = Project::get();

        if (isset($args['ID'])) {
            $list = $list->filter('ID', $args['ID']);
        }

        if (isset($args['URLSegment'])) {
            $list = $list->filter('URLSegment', $args['URLSegment']);
        }

        return $list;
    }
}
