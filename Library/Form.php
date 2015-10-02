<?php

namespace Categories\Library;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\TableRegistry;
use Categories\Domain\Entity\Category;
use Categories\Domain\Table\CategoriesTable;
use Rad\DependencyInjection\Container;
use Rad\Events\EventManagerTrait;
use Symfony\Component\Form\Forms;

/**
 * Form Library
 *
 * @package Categories\Library
 */
class Form
{
    use EventManagerTrait;

    const EVENT_CATEGORIES_FORM_SCOPE = 'categories.FormScope';

    /**
     * @return self
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Get form
     *
     * @param Category $category
     *
     * @return \Symfony\Component\Form\Form
     * @throws \Rad\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function getForm(Category $category = null)
    {
        $data = null;
        if ($category) {
            $data = $category->toArray();
        }

        $action = $category ? Container::get('router')->generateUrl(['categories', $data['id']]) :
            Container::get('router')->generateUrl(['categories']);
        $formFactory = Forms::createFormFactory();
        $options = [
            'action' => $action,
            'method' => $category ? 'PUT' : 'POST'
        ];

        $event = $this->getEventManager()->dispatch(self::EVENT_CATEGORIES_FORM_SCOPE, $this);

        /** @var CategoriesTable $categoriesTable */
        $categoriesTable = TableRegistry::get('Categories.Categories');
        $treeList = $categoriesTable->find('treeList');

        if (!empty($category)) {
            $treeList->where(['id !=' => $data['id']]);
        }

        $formBuilder = $formFactory->createBuilder('form', $data, $options)
            ->add('title', 'text', ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('slug', 'text', ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add(
                'parent_id',
                'choice',
                [
                    'choices' => $treeList,
                    'empty_data' => null,
                    'empty_value' => "No Parent",
                    'label' => 'Parent',
                    'required' => false
                ]
            );

        if (!empty($event->getResult())) {
            $choices = $event->getResult();

            if (!is_array($choices)) {
                $choices = [$choices];
            }

            $formBuilder->add('scope', 'choice', ['choices' => $choices, 'label' => 'Group']);
        }

        return $formBuilder->add(
            'description',
            'textarea',
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control wysiwyg'
                ]
            ])
            ->add('submit', 'submit')
            ->getForm();
    }
}
