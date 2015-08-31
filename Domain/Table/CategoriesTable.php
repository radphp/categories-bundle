<?php

namespace Categories\Domain\Table;

use Cake\ORM\Table;

/**
 * Categories Table
 *
 * @package Categories\Domain\Table
 */
class CategoriesTable extends Table
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        $this->belongsTo(
            'ParentCategories',
            [
                'className' => 'Categories',
                'foreignKey' => 'parent_id',
                'propertyName' => 'parentCategory'
            ]
        );

        $this->addBehavior('Tree', [
            'left' => 'tree_left',
            'right' => 'tree_right',
            'level' => 'level'
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always'
                ]
            ]
        ]);
    }
}
