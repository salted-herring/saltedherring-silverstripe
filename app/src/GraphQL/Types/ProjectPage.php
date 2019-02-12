<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class ProjectPageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Project'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $pageConn = Connection::create('RelatedPages')
            ->setConnectionType(function () {
                return $this->manager->getType('Page');
            })
            ->setDescription('A list of pages');

        return array_merge($fields, [
            'Summary' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Summary);
                }
            ],
            'Introduction' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Introduction);
                }
            ],
            'Services' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Services);
                }
            ],
            'Recognition' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Recognition);
                }
            ],
            'RelatedProjectsTitle' => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->RelatedProjectsTitle);
                }
            ],
            'RelatedProjects' => [
                'type' => $pageConn->toType(),
                'args' => $pageConn->args(),
                'resolve' => function ($obj, $args, $context) use ($pageConn) {
                    return $pageConn->resolveList(
                        $obj->RelatedProjects(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
