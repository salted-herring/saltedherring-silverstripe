<?php

namespace App\Web\GraphQL\Types;

use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class AboutSectionBlockTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'AboutSection'
        ];
    }

    public function fields()
    {
        $conn = Connection::create('AboutBlocksConn')
            ->setConnectionType(function () {
                return $this->manager->getType('AboutContentBlock');
            })
            ->setDescription('A list of about blocks');

        return [
            'ID'               => ['type' => Type::id()],
            'SortOrder'        => ['type' => Type::int()],
            'HeroTitle'        => ['type' => Type::string()],
            'HeroIntroduction' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->HeroIntroduction);
                }
            ],
            'Slug'             => [
                'type' => Type::string(),
                'resolve' => function($obj, $args, $context) {
                    return $obj->getSlugValue();
                }
            ],
            'Introduction'     => ['type' => $this->manager->getType('TextBlock')],
            'Blocks'           => [
                'type' => $conn->toType(),
                'args' => $conn->args(),
                'resolve' => function ($obj, $args, $context) use ($conn) {
                    return $conn->resolveList(
                        $obj->Blocks(),
                        $args,
                        $context
                    );
                }
            ]
        ];
    }
}
