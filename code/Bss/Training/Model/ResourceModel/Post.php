<?php

namespace Bss\Training\Model\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('bss_customer_posts', 'post_id');
    }
}
