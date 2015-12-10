<?php

namespace Categories\Action;

use App\Action\AppAction;
use Categories\Library\AuthorizationTrait;
use Cake\ORM\TableRegistry;
use Categories\Domain\Table\CategoriesTable;
use Rad\Network\Http\Response;

/**
 * Delete Method Action
 *
 * @package Categories\Action
 */
class DeleteMethodAction extends AppAction
{
    use AuthorizationTrait;

    /**
     * Invoke delete method
     *
     * @param int $id Category id
     *
     * @return Response
     */
    public function __invoke($id)
    {
        /** @var CategoriesTable $categoriesTable */
        $categoriesTable = TableRegistry::get('Categories.Categories');

        return new Response($categoriesTable->deleteAll(['id' => $id]));
    }
}
