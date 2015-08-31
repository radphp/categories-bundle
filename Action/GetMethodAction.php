<?php

namespace Categories\Action;

use App\Action\AppAction;
use Cake\ORM\TableRegistry;
use Categories\Domain\Entity\Category;
use Categories\Library\Form;
use DataTable\Column;
use DataTable\DataSource\ServerSide\CakePHP;
use DataTable\Table;
use Twig\Library\Helper as TwigHelper;

/**
 * Get Method Action
 *
 * @package Categories\Action
 */
class GetMethodAction extends AppAction
{
    /**
     * Invoke Action
     *
     * @param int $id Category id
     *
     * @return void
     * @throws \Rad\Core\Exception\BaseException
     */
    public function __invoke($id = null)
    {
        if (null !== $id) {
            $this->getResponder()->setData('form', Form::create()->getForm($this->getCategories($id)));
        } else {
            $this->getResponder()->setData('table', $this->getDataTable());
        }
    }

    /**
     * Get categories
     *
     * @param null $id Category id
     *
     * @return \Cake\ORM\Query|mixed
     */
    protected function getCategories($id = null)
    {
        $categoriesTable = TableRegistry::get('Categories.Categories');

        if (null !== $id) {
            return $categoriesTable->find()
                ->where(['id' => $id])
                ->first();
        }

        return $categoriesTable->find()
            ->contain('ParentCategories');
    }

    /**
     * Get DataTable
     *
     * @return Table
     * @throws \DataTable\Exception
     */
    protected function getDataTable()
    {
        TwigHelper::addCss('file:///Admin/vendor/datatables/media/css/jquery.dataTables.min.css', 100);
        TwigHelper::addJs('file:///Admin/vendor/jquery/dist/jquery.min.js', 20);
        TwigHelper::addJs('file:///Admin/vendor/datatables/media/js/jquery.dataTables.min.js', 100);
        TwigHelper::addJs('
        function deleteCategory(id) {
    if (confirm(\'Delete this category?\')) {
        $.ajax({
            type: "DELETE",
            url: \'categories/\' + id,
            success: function(affectedRows) {
                if (affectedRows > 0) window.location = \'categories\';
            }
        });
    }
}', 110);

        $table = new Table();
        $col = new Column();
        $col->setTitle('Slug')
            ->setData('Categories.slug');
        $table->addColumn($col);

        $col = new Column();
        $col->setTitle('Title')
            ->setData('Categories.title');
        $table->addColumn($col);

        $col = new Column();
        $col->setTitle('Parent')
            ->setData('Categories.parent_id')
            ->isSearchable(false)
            ->setFormatter(function ($parentId, Category $category) {
                if (null === $parentId) {
                    return 'No Parent';
                }

                return $category->parentCategory->get('title');
            });
        $table->addColumn($col);

        $router = $this->getRouter();
        $col = new Column\Action();
        $col->setManager(
            function (Column\ActionBuilder $action, Category $category) use ($router) {
                /* TODO Admin RBAC */
                if (true) {
                    $action->addAction(
                        'edit',
                        'Edit',
                        $router->generateUrl(['categories', $category->get('id')])
                    );
                    $action->addAction(
                        'delete',
                        'Delete',
                        'javascript:deleteCategory("' . $category->get('id') . '");'
                    );
                }
            }
        )
            ->setTitle('Actions');
        $table->addColumn($col);

        $table->setDataSource(new CakePHP($this->getCategories(), $this->getRequest()->getRequestTarget()));

        return $table;
    }
}
