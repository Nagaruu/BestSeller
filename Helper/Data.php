<?php
namespace AHT\BestSeller\Helper;

use \Magento\Framework\Serialize\Serializer\Json;
use \Magento\Framework\View\Element\Template;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Serialize\Serializer\Serialize
     */
    protected $configurable;
    protected $currency;
    protected $productFactory;
    protected $imageHelperFactory;
    protected $_storeManager;
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        \Magento\Directory\Model\Currency $currency, 
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        Template $_storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $_storeManager;
        $this->imageHelperFactory = $imageHelperFactory;
        $this->currency = $currency;
        $this->productFactory = $productFactory;
        $this->configurable = $configurable;
        parent::__construct($context);
    }
    //Get
    public function getProductUrl($id){
        $product_config = $this->configurable->getParentIdsByChild($id);
        if (isset($product_config[0])) {
            $id = $product_config[0];
        }
        $product = $this->productFactory->create()->load($id);
        return $product->getProductUrl();
    }

    //Get number config admin
    public function getNumberBestSellerConfig()
    {
        return $this->scopeConfig->getValue('bestseller/general/numberbestseller', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getImageBestSeller($id){
        $product = $this->productFactory->create()->load($id);
        $imageUrl = $this->imageHelperFactory->create()->init($product, 'product_small_image')->getUrl();
        return $imageUrl;
    }

    //Get currency symbol 
    public function getCurrentCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }
}