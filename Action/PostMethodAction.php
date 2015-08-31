<?php

namespace Categories\Action;

use App\Action\AppAction;
use Cake\ORM\TableRegistry;
use Categories\Domain\Table\CategoriesTable;
use Rad\Network\Http\Response\RedirectResponse;

/**
 * Post Method Action
 *
 * @package Categories\Action
 */
class PostMethodAction extends AppAction
{
    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        /** @var CategoriesTable $categoriesTable */
        $categoriesTable = TableRegistry::get('Categories.Categories');
        $formValues = $this->getRequest()->getParsedBody()['form'];

        $data = [
            'parent_id' => $formValues['parent_id'],
            'slug' => $formValues['slug'],
            'title' => $formValues['title'],
            'description' => $formValues['description'],
            'scope' => isset($formValues['scope']) ? $formValues['scope'] : null,
        ];

        $categoriesTable->save($categoriesTable->newEntity($data));

        return new RedirectResponse($this->getRouter()->generateUrl(['categories']));
    }
}
