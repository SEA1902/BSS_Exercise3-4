<?php

namespace Bss\Training\Observer;

use Psr\Log\LoggerInterface;

class UpdateRewardPoint implements \Magento\Framework\Event\ObserverInterface
{
    protected $helperEarnPointRate;
    protected $customerRepositoryInterface;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Order constructor.
     * @param \Bss\Training\Helper\EarnPointRate $earnPointRate
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     *
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Bss\Training\Helper\EarnPointRate $helperEarnPointRate,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
)
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->helperEarnPointRate = $helperEarnPointRate;

        $this->logger = $logger;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $earnPointRate = $this->helperEarnPointRate->getData();
        $order = $observer->getEvent()->getOrder()->getData();
        $priceProductTotal = $order['base_subtotal'];
        $customerId = $order['customer_id'];
        $customer = $this->customerRepositoryInterface->getById($customerId);
        $rewardPoint = $customer->getCustomAttribute('reward_point')->getValue();
        $rewardPoint = $rewardPoint + $priceProductTotal * ($earnPointRate/100);
        $customer->setCustomAttribute('reward_point', $rewardPoint);
        $this->customerRepositoryInterface->save($customer);
        return $this;
    }
}
