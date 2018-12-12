<?php

namespace App\Web\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\Assets\Image;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class ReadSaltedCroppableImageQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'readSaltedCroppableImage'
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
        return Type::listOf($this->manager->getType('SaltedCroppableImage'));
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $list = SaltedCroppableImage::get();

        if (isset($args['ID'])) {
            $list = $list->filter('ID', $args['ID']);
        }

        return $list;
    }
}
