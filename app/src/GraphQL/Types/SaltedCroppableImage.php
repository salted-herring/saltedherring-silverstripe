<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class SaltedCroppableImageTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'SaltedCroppableImage'
        ];
    }

    public function fields()
    {
        return [
            'ID'      => ['type' => Type::id()],
            'Title'   => ['type' => Type::string()],
            'URL'     => ['type' => Type::string()],
            'Cropped' => [
                'type'    => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    if ($obj->exists()) {
                        return $obj->Cropped()->getURL();
                    }
                    return null;
                }
            ]
        ];
    }
}
