<?php

namespace Categories\Responder;

use App\Responder\AppResponder;
use DataTable\Table;
use Rad\Network\Http\Response\JsonResponse;
use Twig\Library\TwigResponse;

/**
 * Get Method Responder
 *
 * @package Categories\Responder
 */
class GetMethodResponder extends AppResponder
{
    /**
     * Invoke responder
     *
     * @return JsonResponse|TwigResponse
     * @throws \DataTable\Exception
     */
    public function __invoke()
    {
        /** @var Table $table */
        $table = $this->getData('table');
        if ($table instanceof Table) {
            if ($this->getRequest()->isAjax()) {
                return new JsonResponse($table->getResponse()->toArray());
            } else {
                return new TwigResponse('@Categories/index.twig', ['table' => $table->render()]);
            }
        }

        if ($this->getRequest()->isAjax()) {
            return new JsonResponse($this->getData('categories', []));
        } else {
            // if it is edit form
            if ($form = $this->getData('form', false)) {
                return new TwigResponse(
                    '@Categories/form.twig',
                    [
                        'form' => $form->createView(),
                        'title' => 'Edit a category',
                    ]
                );
            }
        }
    }
}
