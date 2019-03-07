<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class MenuTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Menu'
        ];
    }

    public function fields()
    {
        $conn = Connection::create('Page')
            ->setConnectionType(function () {
                return $this->manager->getType('Page');
            })
            ->setDescription('A list of pages');

        $colourConn = Connection::create('MenuColourTheme')
            ->setConnectionType(function () {
                return $this->manager->getType('Colour');
            })
            ->setDescription('A list of pages');

        $colourConn1 = Connection::create('MenuColourTheme1')
            ->setConnectionType(function () {
                return $this->manager->getType('Colour');
            })
            ->setDescription('A list of pages');

        return [
            'ID'            => ['type' => Type::id()],
            'Title'         => ['type' => Type::string()],
            'MenuTitle'     => ['type' => Type::string()],
            'Sort'          => ['type' => Type::int()],
            'Link'  => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->Link();
                }
            ],
            'Children' => [
                'type' => $conn->toType(),
                'args' => $conn->args(),
                'resolve' => function ($obj, $args, $context) use ($conn) {
                    return $conn->resolveList(
                        $obj->Children(),
                        $args,
                        $context
                    );
                }
            ],
            'TitleColour' => ['type' => $this->manager->getType('Colour')],
            'BackgroundColour' => ['type' => $this->manager->getType('Colour')]
        ];
    }
}
