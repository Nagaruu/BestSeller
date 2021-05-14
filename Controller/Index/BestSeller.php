<?php
 
namespace AHT\BestSeller\Controller\Index;

use AHT\BestSeller\Helper\Data;

class BestSeller extends \Magento\Framework\App\Action\Action
{
    protected $bestSellerInterface;
    protected $resultJsonFactory;
    protected $resultFactory;
    private $_helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \AHT\BestSeller\Api\BestSellerInterface $bestSellerInterface,
        Data $_helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->_helper = $_helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->bestSellerInterface = $bestSellerInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $item_config = $this->_helper->getNumberBestSellerConfig();
        $data = $this->getRequest()->getParams();
        if($data != null) {
            $pageNum = $data['pageNum'];
        }
        $items = $this->bestSellerInterface->getProductShowMore($item_config,$pageNum);      
        return $resultJson->setData($items);
    }
}