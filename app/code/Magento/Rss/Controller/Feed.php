<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Rss\Controller;

/**
 * Class Feed
 */
class Feed extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Customer\Api\AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**
     * @var \Magento\Framework\HTTP\Authentication
     */
    protected $httpAuthentication;

    /**
     * @var \Magento\Framework\Logger
     */
    protected $logger;

    /**
     * @var \Magento\Rss\Model\RssManager
     */
    protected $rssManager;

    /**
     * @var \Magento\Rss\Model\RssFactory
     */
    protected $rssFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Rss\Model\RssManager $rssManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Rss\Model\RssFactory $rssFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement
     * @param \Magento\Framework\HTTP\Authentication $httpAuthentication
     * @param \Magento\Framework\Logger $logger
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Rss\Model\RssManager $rssManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Rss\Model\RssFactory $rssFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement,
        \Magento\Framework\HTTP\Authentication $httpAuthentication,
        \Magento\Framework\Logger $logger
    ) {
        $this->rssManager = $rssManager;
        $this->scopeConfig = $scopeConfig;
        $this->rssFactory = $rssFactory;
        $this->customerSession = $customerSession;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->httpAuthentication = $httpAuthentication;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function auth()
    {
        if (!$this->customerSession->isLoggedIn()) {
            list($login, $password) = $this->httpAuthentication->getCredentials();
            try {
                $customer = $this->customerAccountManagement->authenticate($login, $password);
                $this->customerSession->setCustomerDataAsLoggedIn($customer);
                $this->customerSession->regenerateId();
            } catch (\Exception $e) {
                $this->logger->logException($e);
            }
        }

        if (!$this->customerSession->isLoggedIn()) {
            $this->httpAuthentication->setAuthenticationFailed('RSS Feeds');
            return false;
        }

        return true;
    }
}
