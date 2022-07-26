<?php
namespace Bss\Training\Controller\Training;

class AddPost extends \Magento\Framework\App\Action\Action
{
    protected $request;
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Action\Context $context
        )
    {
        $this->request = $request;
        return parent::__construct($context);

    }

    public function execute()
    {
//       dd($this->getRequest()->getParams());
    }
}
