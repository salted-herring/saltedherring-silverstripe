<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

class AboutContentBlockTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'AboutContentBlock'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        return [
            'ID'           => ['type' => Type::id()],
            'SortOrder'    => ['type' => Type::int()],
            'Title'        => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Title);
                }
            ],
            'Introduction' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Introduction);
                }
            ],
            'Details'      => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Details);
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
        ];
    }
}
