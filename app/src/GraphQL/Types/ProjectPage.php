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
            'PreviewVideo' => [
                'type' => $this->manager->getType('File'),
                'resolve' => function ($obj, $args, $context) {
                    if (!$obj->PreviewVideo()->exists() && $obj->HeroVideo()->exists()) {
                        return $obj->HeroVideo();
                    }

                    return $obj->PreviewVideo();
                }
            ],
            'PreviewImage' => [
                'type' => $this->manager->getType('Image'),
                'resolve' => function ($obj, $args, $context) {
                    if (!$obj->PreviewImage()->exists() && $obj->HeroImages()->count() > 0) {
                        return $obj->HeroImages()->first();
                    }

                    return $obj->PreviewImage();
                }
            ]
        ]);
    }
}
