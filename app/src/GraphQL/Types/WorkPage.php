<?php

namespace App\Web\GraphQL\Types;

use App\Web\GraphQL\Types\PageTypeCreator;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

use SaltedHerring\Salted\Cropper\SaltedCroppableImage;

class WorkPageTypeCreator extends PageTypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'WorkPage'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $imageConn = Connection::create('Image')
            ->setConnectionType(function () {
                return $this->manager->getType('Image');
            })
            ->setDescription('A list of the images.');

        $awardsConn = Connection::create('AwardProgramme')
            ->setConnectionType(function () {
                return $this->manager->getType('AwardProgramme');
            })
            ->setDescription('A list of the awards programmes.');

        $pageConn = Connection::create('Page2')
            ->setConnectionType(function () {
                return $this->manager->getType('Project');
            })
            ->setDescription('A list of pages');

        return array_merge($fields, [
            'Introduction'            => [
                'type' => Type::string(),
                'resolve' => function ($obj, $args, $context) {
                    return nl2br($obj->Introduction);
                }
            ],
            'ShowAwards'              => ['type' => Type::boolean()],
            'AwardsTitle'             => ['type' => Type::string()],
            'ShowClients'             => ['type' => Type::boolean()],
            'ClientsTitle'            => ['type' => Type::string()],
            'AwardsBackgroundColour'  => ['type' => $this->manager->getType('Colour')],
            'ClientsBackgroundColour' => ['type' => $this->manager->getType('Colour')],
            'ClientLogos' => [
                'type' => $imageConn->toType(),
                'args' => $imageConn->args(),
                'resolve' => function ($obj, $args, $context) use ($imageConn) {
                    return $imageConn->resolveList(
                        $obj->ClientLogos(),
                        $args,
                        $context
                    );
                }
            ],
            'Programmes' => [
                'type' => $awardsConn->toType(),
                'args' => $awardsConn->args(),
                'resolve' => function ($obj, $args, $context) use ($awardsConn) {
                    return $awardsConn->resolveList(
                        $obj->Programmes(),
                        $args,
                        $context
                    );
                }
            ],
            'Projects' => [
                'type' => $pageConn->toType(),
                'args' => $pageConn->args(),
                'resolve' => function ($obj, $args, $context) use ($pageConn) {
                    return $pageConn->resolveList(
                        $obj->Children(),
                        $args,
                        $context
                    );
                }
            ]
        ]);
    }
}
