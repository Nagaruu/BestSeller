<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AHT\BestSeller\Model;

use AHT\BestSeller\Api\BestSellerInterface as BestSellerCollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BestSellerRepository implements \AHT\BestSeller\Api\BestSellerInterface
{

	private $_bestSellerFactory;


    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param BestSellerCollectionFactory $bestSellerCollectionFactory
     */
    public function __construct(
    	\Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $_bestSellerFactory,
    	\Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
    	$this->_bestSellerFactory = $_bestSellerFactory;
    	$this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function getProductShowMore($item,$curpage) {
      $bestSellerCollection = $this->_bestSellerFactory->create();
      $bestSellerCollection->getSelect()->order('qty_ordered desc');
      return $bestSellerCollection->setPageSize($item)->setCurPage($curpage);
    }
}
