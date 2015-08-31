<?php

Cake\ORM\TableRegistry::config(
    'Categories.Categories',
    [
        'table' => 'categories',
        'alias' => 'Categories',
        'className' => 'Categories\Domain\Table\CategoriesTable',
        'entityClass' => 'Categories\Domain\Entity\Category',
    ]
);