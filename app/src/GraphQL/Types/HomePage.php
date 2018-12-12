<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class HomePageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'HomePage'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $latestConn = Connection::create('Latest')
            ->setConnectionType(function () {
                return $this->manager->getType('Latest');
            })
            ->setDescription('A list of the latest news');

        return array_merge($fields, [
            'LatestSectionTitle' => ['type' => Type::string()],
            'Latest' => [
                'type' => $latestConn->toType(),
                'args' => $latestConn->args(),
                'resolve' => function ($obj, $args, $context) use ($latestConn) {
                    return $latestConn->resolveList(
                        $obj->Latest(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
