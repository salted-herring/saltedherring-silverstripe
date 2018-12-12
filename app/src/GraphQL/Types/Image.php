<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class ImageTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Image'
        ];
    }

    public function fields()
    {
        return [
            'ID'            => ['type' => Type::id()],
            'Title'         => ['type' => Type::string()],
            'URL'          => ['type' => Type::string()],
            'FitFullScreen' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->FitMax(1920, 1080)->getURL();
                }
            ]
        ];
    }
}
