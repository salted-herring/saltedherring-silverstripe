<?php

namespace App\Web\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use SilverStripe\Core\ClassInfo;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\View\Parsers\ShortcodeParser;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class PageTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Page'
        ];
    }

    public function fields()
    {
        $heroImgConn = Connection::create(Classinfo::shortName($this) . 'HeroImages')
            ->setConnectionType(function () {
                return $this->manager->getType('Image');
            })
            ->setDescription('A list of the hero images');

        return [
            'ID'              => ['type' => Type::id()],
            'Sort'            => ['type' => Type::int()],
            'URLSegment'      => ['type' => Type::string()],
            'AbsoluteLink'    => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->AbsoluteLink();
                }
            ],
            'Link'            => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return $obj->Link();
                }
            ],
            'Content'         => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return ShortcodeParser::get_active()->parse($obj->Content);
                }
            ],
            'ClassName'       => ['type' => Type::string()],
            'MetaTitle'       => ['type' => Type::string()],
            'MenuTitle'       => ['type' => Type::string()],
            'Title'           => ['type' => Type::string()],
            'MetaDescription' => ['type' => Type::string()],
            'MetaKeywords'    => ['type' => Type::string()],
            'ExtraMeta'       => ['type' => Type::string()],
            'MetaRobots'      => ['type' => Type::string()],
            'ConanicalURL'    => ['type' => Type::string()],
            'OGType'          => ['type' => Type::string()],
            'OGTitle'         => ['type' => Type::string()],
            'OGDescription'   => ['type' => Type::string()],
            'OGImage'         => ['type' => $this->manager->getType('SaltedCroppableImage')],
            'OGImageLarge'    => ['type' => $this->manager->getType('SaltedCroppableImage')],
            'HeroTitle'       => ['type' => Type::string()],
            'HeroMenuColour'  => ['type' => Type::string()],
            'HeroImages'      => [
                'type' => $heroImgConn->toType(),
                'args' => $heroImgConn->args(),
                'resolve' => function ($obj, $args, $context) use ($heroImgConn) {
                    return $heroImgConn->resolveList(
                        $obj->HeroImages(),
                        $args,
                        $context
                    );
                }
            ],
            'HeroVideo'         => ['type' => $this->manager->getType('File')],
            'BackgroundColour' => ['type' => $this->manager->getType('Colour')],
            'TitleColour' => ['type' => $this->manager->getType('Colour')]
        ];
    }
}
