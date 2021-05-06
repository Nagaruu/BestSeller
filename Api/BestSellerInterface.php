<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\BestSeller\Api;


interface BestSellerInterface
{
    /**
     * show more 
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function getProductShowMore($item,$curpage);

}
