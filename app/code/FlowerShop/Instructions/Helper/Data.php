<?php
declare(strict_types=1);

namespace FlowerShop\Instructions\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Helper Class
 */
class Data extends AbstractHelper
{
    /**
     * @return string
     */
    public function getCustomerGroup(): string
    {
        return (string)$this->scopeConfig->getValue(
            'custom_section/custom/customer_group_list',
            ScopeInterface::SCOPE_STORE);
    }
}
