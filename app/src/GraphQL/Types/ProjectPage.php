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

        $contentConn = Connection::create('ContentBlocks')
            ->setConnectionType(function () {
                return $this->manager->getType('ContentBlock');
            })
            ->setDescription('A list of related blocks');

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
            ],
            'ContentBlocks' => [
                'type' => $this->manager->getType('ContentBlock'),
                'args' => $contentConn->args(),
                'resolve' => function ($obj, $args, $context) use ($contentConn) {
                    return $contentConn->resolveList(
                        $obj->ContentBlocks(),
                        $args,
                        $context
                    );
                }
            ],
        ]);
    }
   //  $scaffolder->type(MyObject::class)
   // ->nestedQuery(
   //     'MyNestedField',  // the name of the field on the parent object
   //     new MyCustomListQueryScaffolder(
   //       'customOperation', // The name of the operation. Must be unique.
   //       'MyCustomType' // The type the query will return. Make sure it's been registered.
   //     )
   // );
}
