<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

class AboutPageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'AboutPage'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $conn = Connection::create('AboutSectionsConn')
            ->setConnectionType(function () {
                return $this->manager->getType('AboutSection');
            })
            ->setDescription('A list of about blocks');

        return array_merge($fields, [
            'BackgroundColour' => ['type' => $this->manager->getType('Colour')],
            'AboutSections' => [
                'type' => $conn->toType(),
                'args' => $conn->args(),
                'resolve' => function ($obj, $args, $context) use ($conn) {
                    return $conn->resolveList(
                        $obj->AboutSections(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
