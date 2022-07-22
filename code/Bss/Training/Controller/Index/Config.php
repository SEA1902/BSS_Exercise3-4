<?php
namespace Bss\Training\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    protected $helperEarnPointRate;
    protected $customerRepositoryInterface;
    protected $customerSession;

    protected $customerFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\Session $customerSession,
        \Bss\Training\Helper\EarnPointRate $helperEarnPointRate)
    {
        $this->pageFactory = $pageFactory;
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->helperEarnPointRate = $helperEarnPointRate;
        return parent::__construct($context);
    }

    public function execute()
    {
        $customerId =  $this->customerSession->getCustomer()->getId();
        $customer =$this->customerRepositoryInterface->getById($customerId);
        $reward_point = $customer->getCustomAttribute('reward_point')->getValue();
//        dd($reward_point);
    }
}
