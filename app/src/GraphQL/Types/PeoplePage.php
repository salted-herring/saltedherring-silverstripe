<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class PeoplePageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'PeoplePage'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $partners = Connection::create('Partners')
            ->setConnectionType(function () {
                return $this->manager->getType('Latest');
            })
            ->setDescription('A list of partners');

        $pageConn = Connection::create('PagePartners')
            ->setConnectionType(function () {
                return $this->manager->getType('Person');
            })
            ->setDescription('A list of pages');

        return array_merge($fields, [
            'ShowPartners'              => ['type' => Type::boolean()],
            'PartnersTitle'             => ['type' => Type::string()],
            'PartnersBackgroundColour'  => ['type' => $this->manager->getType('Colour')],
            'Partners' => [
                'type' => $partners->toType(),
                'args' => $partners->args(),
                'resolve' => function ($obj, $args, $context) use ($partners) {
                    return $partners->resolveList(
                        $obj->Partners(),
                        $args,
                        $context
                    );
                }
            ],
            'People' => [
                'type' => $pageConn->toType(),
                'args' => $pageConn->args(),
                'resolve' => function ($obj, $args, $context) use ($pageConn) {
                    return $pageConn->resolveList(
                        $obj->Children(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
