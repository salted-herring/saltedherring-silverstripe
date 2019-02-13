<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\ContentBlockTypeCreator;

use SilverStripe\Core\ClassInfo;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class ImageBlockTypeCreator extends ContentBlockTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'ImageBlock'
        ];
    }

    public function fields()
    {
        $imgConn = Connection::create(Classinfo::shortName($this) . 'Images')
            ->setConnectionType(function () {
                return $this->manager->getType('Image');
            })
            ->setDescription('A list of the hero images');

        return array_merge(parent::fields(), [
            'Images' => [
                'type' => $imgConn->toType(),
                'args' => $imgConn->args(),
                'resolve' => function ($obj, $args, $context) use ($imgConn) {
                    return $imgConn->resolveList(
                        $obj->Images(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
