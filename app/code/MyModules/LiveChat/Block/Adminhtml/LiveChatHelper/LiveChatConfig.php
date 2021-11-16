<?php

namespace MyModules\LiveChat\Block\Adminhtml\LiveChatHelper;

class LiveChatConfig extends \Magento\Framework\View\Element\Template
{
    protected $scopeConfig;
    const XML_PATH_ENABLED = 'MyModules_livechat/livechat/enabled';
    const XML_PATH_WIDGET = 'MyModules_livechat/livechat/widget';
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    public function isEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED, $storeScope);
    }
    public function getWidget()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_WIDGET, $storeScope);
    }
}
