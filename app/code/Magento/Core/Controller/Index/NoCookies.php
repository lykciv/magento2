<?php
/**
 *
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Core\Controller\Index;

class NoCookies extends \Magento\Framework\App\Action\Action
{
    /**
     * No cookies action
     *
     * @return void
     */
    public function execute()
    {
        $redirect = new \Magento\Framework\Object();
        $this->_eventManager->dispatch(
            'controller_action_nocookies',
            ['action' => $this, 'redirect' => $redirect]
        );

        $url = $redirect->getRedirectUrl();
        if ($url) {
            $this->getResponse()->setRedirect($url);
        } elseif ($redirect->getRedirect()) {
            $this->_redirect($redirect->getPath(), $redirect->getArguments());
        } else {
            $this->_view->loadLayout(['default', 'noCookie']);
            $this->_view->renderLayout();
        }

        $this->getRequest()->setDispatched(true);
    }
}
