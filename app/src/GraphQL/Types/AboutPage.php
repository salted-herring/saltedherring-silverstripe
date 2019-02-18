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
            'name' => 'About'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'Sections' => [
                'type' => $this->manager->getType('Section'),
                'args' => $contentConn->args(),
                'resolve' => function ($obj, $args, $context) use ($contentConn) {
                    return $contentConn->resolveList(
                        $obj->Sections(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
