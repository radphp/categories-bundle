<?php

namespace Categories;

use Admin\Library\Menu;
use Rad\Core\Bundle;

/**
 * Categories Bootstrap
 *
 * @package Categories
 */
class Bootstrap extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function startup()
    {
        parent::startup();

        $this->getEventManager()->attach(Menu::EVENT_GET_MENU, [$this, 'addAdminMenu']);
    }

    /**
     * Add required menu for admin panel
     */
    public function addAdminMenu()
    {
        $parent = Menu::addMenu('Categories', 'fa-file-text');
        Menu::addMenu('Categories', '', '/admin/bundles/categories', 100, $parent);
        Menu::addMenu('Add Category', '', '/admin/bundles/categories/new', 110, $parent);
    }
}
