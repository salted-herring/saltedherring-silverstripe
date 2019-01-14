<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class AwardProgrammeTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'AwardProgramme'
        ];
    }

    public function fields()
    {
        $conn = Connection::create('Award')
            ->setConnectionType(function () {
                return $this->manager->getType('Award');
            })
            ->setDescription('A list of awards');

        return [
            'ID'            => ['type' => Type::id()],
            'Title'         => ['type' => Type::string()],
            'Link'          => ['type' => $this->manager->getType('Link')],
            'Awards' => [
                'type' => $conn->toType(),
                'args' => $conn->args(),
                'resolve' => function ($obj, $args, $context) use ($conn) {
                    return $conn->resolveList(
                        $obj->Awards(),
                        $args,
                        $context
                    );
                }
            ]
        ];
    }
}
