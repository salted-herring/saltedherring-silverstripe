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
            'ThumbnailWidth' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->FitMax(300, 300)->getWidth();
                }
            ],
            'ThumbnailHeight' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->FitMax(300, 300)->getHeight();
                }
            ],
            'FitFullScreen' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->ScaleMaxWidth(1920)->getURL();
                }
            ],
            'FitFullScreenWidth' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->ScaleMaxWidth(1920)->getWidth();
                }
            ],
            'FitFullScreenHeight' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->ScaleMaxWidth(1920)->getHeight();
                }
            ]
        ];
    }
}
