<?php

namespace Categories\Responder;

use App\Responder\AppResponder;
use Twig\Library\TwigResponse;

/**
 * New Page Responder
 *
 * @package Categories\Responder
 */
class NewResponder extends AppResponder
{
    /**
     * Get method
     *
     * @return TwigResponse
     */
    public function getMethod()
    {
        $form = $this->getData('form');

        return new TwigResponse(
            '@Categories/form.twig',
            [
                'form' => $form->createView(),
                'title' => 'Add a new category',
            ]
        );
    }
}
