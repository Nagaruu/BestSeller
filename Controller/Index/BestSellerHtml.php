<?php
 
namespace AHT\BestSeller\Controller\Index;
 
class BestSellerHtml extends \Magento\Framework\App\Action\Action
{
    protected $bestSellerInterface;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \AHT\BestSeller\Api\BestSellerInterface $bestSellerInterface
    )
    {
        $this->bestSellerInterface = $bestSellerInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $block = $this->_objectManager->get('AHT\BestSeller\Block\BestSeller');
        $item_config = number_format($block->getNumberBestSellerConfig());
        $data = $this->getRequest()->getParams();
        if($data != null) {
            $pageNum = $data['pageNum'];
        }

        $items = $this->bestSellerInterface->getProductShowMore($item_config,$pageNum);        

        if($items != null) 
        {
            $currencySymbols = $block->getStoreCurrency();
            foreach ($items as $item) {
                $product_url = $block->getProductUrl($item->getProductId());
                echo "<li id='bestseller-item'>";
                echo "<a href=". $product_url . " ><img src=" . $block->getImageBestSeller($item->getProductId()) . "></a>";
                echo "<a href=". $product_url . " ><p class='bestseller-name'>" . $item->getProductName() . "</p></a>";
                echo "<p class='bestseller-price'>" .$currencySymbols. number_format($item->getProductPrice(),2) . "</p>";
                echo "<p class='bestseller-order'>" . 'Ordered: ' . number_format($item->getQtyOrdered()) . "</p>";
                echo "</li>";
            }
        }   
    }
}