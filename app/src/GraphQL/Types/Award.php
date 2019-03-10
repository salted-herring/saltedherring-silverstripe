<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class AwardTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Award'
        ];
    }

    public function fields()
    {
        $conn = Connection::create('AwardDetail')
            ->setConnectionType(function () {
                return $this->manager->getType('AwardDetail');
            })
            ->setDescription('A list of awards');

        return [
            'ID'            => ['type' => Type::id()],
            'Title'         => ['type' => Type::string()],
            'Image' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(300, 300)->getURL();
                    }
                    return null;
                }
            ],
            'ImageWidth' => [
                'type' => Type::int(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(300, 300)->getWidth();
                    }
                    return null;
                }
            ],
            'ImageHeight' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(300, 300)->getHeight();
                    }
                    return null;
                }
            ],
            'Imagex2' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(600, 600)->getURL();
                    }
                    return null;
                }
            ],
            'Imagex2Width' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(600, 600)->getWidth();
                    }
                    return null;
                }
            ],
            'Imagex2Height' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->Image()->exists()) {
                        return $obj->Image()->FitMax(600, 600)->getHeight();
                    }
                    return null;
                }
            ],
            'AwardDetails' => [
                'type' => $conn->toType(),
                'args' => $conn->args(),
                'resolve' => function ($obj, $args, $context) use ($conn) {
                    return $conn->resolveList(
                        $obj->Entries(),
                        $args,
                        $context
                    );
                }
            ]
        ];
    }
}
