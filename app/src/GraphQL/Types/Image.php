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
                    $img = $obj->FitMax(300, 300);

                    if(!is_null($img)) {
                        return $img->getURL();
                    }

                    return null;
                }
            ],
            'ThumbnailWidth' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    $img = $obj->FitMax(300, 300);

                    if(!is_null($img)) {
                        return $img->getWidth();
                    }

                    return null;
                }
            ],
            'ThumbnailHeight' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    $img = $obj->FitMax(300, 300);

                    if(!is_null($img)) {
                        return $img->getHeight();
                    }

                    return null;
                }
            ],
            'FitFullScreen' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    $img = $obj->ScaleMaxWidth(1920);

                    if(!is_null($img)) {
                        return $img->getURL();
                    }

                    return null;
                }
            ],
            'FitFullScreenWidth' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    $img = $obj->ScaleMaxWidth(1920);

                    if(!is_null($img)) {
                        return $img->getWidth();
                    }

                    return null;
                }
            ],
            'FitFullScreenHeight' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    $img = $obj->ScaleMaxWidth(1920);

                    if(!is_null($img)) {
                        return $img->getHeight();
                    }

                    return null;
                }
            ]
        ];
    }
}
