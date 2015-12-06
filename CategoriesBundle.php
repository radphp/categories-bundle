<?php

namespace Categories;

use Rad\Core\AbstractBundle;
use Rad\Stuff\Admin\Menu;

/**
 * Categories Bundle
 *
 * @package Categories
 */
class CategoriesBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function startup()
    {
        $this->getEventManager()->attach(Menu::EVENT_GET_MENU, [$this, 'addAdminMenu']);
    }

    /**
     * Add required menu for admin panel
     */
    public function addAdminMenu()
    {
        $menuItem1 = (new Menu())
            ->setLabel('Categories')
            ->setLink('/admin/bundles/categories')
            ->setOrder(100);

        $menuItem2 = (new Menu())
            ->setLabel('Add Category')
            ->setLink('/admin/bundles/categories/new')
            ->setOrder(110);

        $root = new Menu();
        $root->setLabel('Categories')
            ->setIcon('fa-file-text')
            ->setOrder(100)
            ->addChild($menuItem1)
            ->addChild($menuItem2)
            ->setAsRoot();
    }
}
