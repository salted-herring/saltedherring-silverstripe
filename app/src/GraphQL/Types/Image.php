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
            'URL'           => ['type' => Type::string()],
            'Thumbnail' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->FitMax(300, 300)->getURL();
                }
            ],
            'FitFullScreen' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->ScaleMaxWidth(1920)->getURL();
                }
            ]
        ];
    }
}
