<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class LatestTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Latest'
        ];
    }

    public function fields()
    {
        return [
            'ID'            => ['type' => Type::id()],
            'Title'         => ['type' => Type::string()],
            'SummaryText'   => ['type' => Type::string()],
            'Link'          => ['type' => $this->manager->getType('Link')],
            'Image' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(684, 400)->getURL();
                    }
                    return null;
                }
            ],
            'ImageWidth' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(684, 400)->getWidth();
                    }
                    return null;
                }
            ],
            'ImageHeight' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(684, 400)->getHeight();
                    }
                    return null;
                }
            ],
            'Imagex2' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(1240, 800)->getURL();
                    }
                    return null;
                }
            ],
            'Imagex2Width' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(1240, 800)->getWidth();
                    }
                    return null;
                }
            ],
            'Imagex2Height' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(1240, 800)->getHeight();
                    }
                    return null;
                }
            ]
        ];
    }
}
