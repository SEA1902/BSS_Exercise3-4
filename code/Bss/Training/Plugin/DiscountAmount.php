<?php

namespace Bss\Training\Plugin;

class DiscountAmount
{
    protected $customerSession;
    protected $customerGroup;
    protected $discountAmount;

    public function __construct(
        \Magento\Customer\Model\Session     $customerSession,
        \Bss\Training\Helper\DiscountAmount $discountAmount
    ) {
        $this->customerSession = $customerSession;
        $this->discountAmount = $discountAmount;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        if ($this->customerSession->isLoggedIn()) {
            $current_group_customer_id = $this->customerSession->getCustomer()->getGroupId();
        } else {
            $current_group_customer_id = 0;
        }
        $dataDiscount = $this->discountAmount->getData();
        $dataDiscount = json_decode($dataDiscount['discount_amount']);
        if (gettype($dataDiscount) == "object") {
            foreach ($dataDiscount as $groupid => $value) {
                if ($current_group_customer_id == $groupid) {
                    return $result * (1 - $value / 100);
                } elseif ($current_group_customer_id == 32000) {
                    return $result * (1 - $value / 100);
                }
            }
        } else {
            return $result * (1 - $dataDiscount / 100);
        }
        return $result;
    }
}
