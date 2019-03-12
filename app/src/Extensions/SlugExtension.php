<?php
/**
 * @file Slug extension
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Creates a slug for URLs when a DBO is saved.
 *
 * */
namespace App\Web\Extensions;

use ReflectionClass;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\SegmentField;
use SilverStripe\Forms\Filter\SlugFilter;
use SilverStripe\Forms\SegmentFieldModifier\SlugSegmentFieldModifier;
use SilverStripe\ORM\DataExtension;

class SlugField extends DataExtension
{
    /**
     * Has_one relationship
     * @var array
     */
    private static $db = [
        'Slug' => 'Varchar(100)'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->replaceField(
            'Slug',
            SegmentField::create('Slug')->setModifiers([
                SlugSegmentFieldModifier::create()->setDefault('tag'),
                ['','']
            ])
            ->setPreview($this->owner->Slug)
        );

        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (empty($this->Slug)) {
            $filter = new SlugFilter();
            $this->owner->Slug = $filter->filter(
                trim(
                    strtolower($this->owner->getTitle())
                )
            );
        }
    }

    public function updateSummaryFields(&$fields)
    {
        $fields = array_merge($fields, ['Slug' => 'Slug']);
    }

    public function getSlugValue() {
        if (!empty($this->owner->Slug)) {
            return $this->owner->Slug;
        }

        return strtolower($this->owner->getTitle());
    }
}
