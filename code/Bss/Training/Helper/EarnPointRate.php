<?php

namespace Bss\Training\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class EarnPointRate extends AbstractHelper
{
    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getData() {
        return $this->scopeConfig->getValue(
            "general/earn_point_rate/rate",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,null
        );
    }
}
