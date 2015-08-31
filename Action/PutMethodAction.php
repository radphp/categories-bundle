<?php

namespace Categories\Action;

use App\Action\AppAction;
use Cake\ORM\TableRegistry;
use Categories\Domain\Table\CategoriesTable;
use Rad\Network\Http\Response\RedirectResponse;

/**
 * Put Method Action
 *
 * @package Categories\Action
 */
class PutMethodAction extends AppAction
{
    /**
     * Invoke put action
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function __invoke($id)
    {
        $formValues = $this->getRequest()->getParsedBody()['form'];

        /** @var CategoriesTable $categoriesTable */
        $categoriesTable = TableRegistry::get('Categories.Categories');
        $data = [
            'id' => $id,
            'parent_id' => $formValues['parent_id'],
            'title' => $formValues['title'],
            'description' => $formValues['description'],
            'scope' => isset($formValues['scope']) ? $formValues['scope'] : null
        ];

        $categoriesTable->save($categoriesTable->newEntity($data));

        return new RedirectResponse($this->getRouter()->generateUrl(['categories']));
    }
}
