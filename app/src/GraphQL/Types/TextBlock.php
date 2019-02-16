<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\ContentBlockTypeCreator;

use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use GraphQL\Type\Definition\Type;

class TextBlockTypeCreator extends ContentBlockTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'TextBlock'
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'Alignment' => ['type' => Type::string()],
            'Content' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Content);
                }
            ],
            'ShowQuote' => ['type' => Type::boolean()],
            'Quote'     => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Quote);
                }
            ],
            'Source'    => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Source);
                }
            ]
        ]);
    }
}
