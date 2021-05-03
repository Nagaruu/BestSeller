<?php
 
namespace AHT\BestSeller\Controller\Index;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $json;
    protected $resultJsonFactory;
    protected $_bestSellerFactory;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        // \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $_bestSellerFactory
    )
    {
        // $this->_bestSellerFactory = $_bestSellerFactory;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        //lấy dữ liệu từ ajax gửi sang
        $response = $this->getRequest()->getParams('test2');
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();

        // $items = $this->_bestSellerFactory->create();
        // $items->getSelect()->order('qty_ordered desc');
        // foreach ($items as $item) {
        //     $a = $item->getProductName();
        //     $b[] = $a;
        // }
        // $data = json_encode($b);
         // chuyển kết quả về dạng object json và trả về cho ajax
        return $resultJson->setData('abc');
    }
}