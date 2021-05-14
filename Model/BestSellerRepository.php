<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AHT\BestSeller\Model;

use AHT\BestSeller\Helper\Data;
use AHT\BestSeller\Api\BestSellerInterface as BestSellerCollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BestSellerRepository implements \AHT\BestSeller\Api\BestSellerInterface
{

	private $_bestSellerFactory;

    private $_helper;

    private $productCollectionFactory;


    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param BestSellerCollectionFactory $bestSellerCollectionFactory
     */
    public function __construct(
    	\Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $_bestSellerFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
    	\Magento\Framework\Serialize\Serializer\Json $json,
        Data $_helper
    ) {
    	$this->_bestSellerFactory = $_bestSellerFactory;
    	$this->json = $json;
        $this->_helper = $_helper;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function getProductShowMore($item,$curpage) {
        $productIds = [];
        $arr = [];
        $bestSellerCollection = $this->_bestSellerFactory->create();
        $bestSellerCollection->getSelect()->order('qty_ordered desc');
        $bestSellerCollection->setPageSize($item)->setCurPage($curpage);

        foreach ($bestSellerCollection as $item) {
            $productIds[] = $item->getProductId();
            $productCollection = $this->productCollectionFactory->create()->addIdFilter($productIds);

            $productData = [
                'url' => $this->_helper->getProductUrl($item->getProductId()),
                'src' => $this->_helper->getImageBestSeller($item->getProductId()),
                // 'src' => $arr,
                'name' => $item->getProductName(),
                'price' => $this->_helper->getCurrentCurrencySymbol() . number_format($item->getProductPrice(),2),
                'ordered' => number_format($item->getQtyOrdered())
            ];
            array_push($arr,$productData);
        }
        return json_encode($arr);

    }

    // public function getProductShowMore($item,$curpage) {
    //     $productIds = [];
        
    //     $bestSellerCollection = $this->_bestSellerFactory->create();
    //     $bestSellerCollection->getSelect()->order('qty_ordered desc');
    //     $bestSellerCollection->setPageSize($item)->setCurPage($curpage);
    //     foreach ($bestSellerCollection as $item1) {
    //         $productIds[] = $item1->getProductId();
    //     }
    //     return $productIds;
    // }

    // public function getProductShowMore1($item,$curpage) {
    //     $arr = [];
    //     $productIds = $this->getProductShowMore($item,$curpage);
    //     $productCollection = $this->productCollectionFactory->create()->addIdFilter($productIds);
    //     foreach ($productCollection as $item2) {
    //         $productData = [
    //             'url' => $item2->getProductUrl(),
    //             'name' => $item2->getProductName(),
    //             'price' => $this->_helper->getCurrentCurrencySymbol() . number_format($item2->getProductPrice(),2),
    //             'ordered' => number_format($item2->getQtyOrdered())
    //         ];
    //         array_push($arr,$productData);
    //     }
    //     return json_encode($arr);
    // }
}
