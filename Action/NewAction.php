<?php

namespace Categories\Action;

use App\Action\AppAction;
use Categories\Library\Form;

/**
 * New Page Action
 *
 * @package Categories\Action
 */
class NewAction extends AppAction
{
    /**
     * Get method
     *
     * @throws \Rad\Core\Exception\BaseException
     */
    public function getMethod()
    {
        $this->getResponder()->setData('form', Form::create()->getForm());
    }
}
