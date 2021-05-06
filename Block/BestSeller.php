<?php
namespace AHT\BestSeller\Block;
use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\CartFactory;

class BestSeller extends Template
{
    protected $_helper;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $imageHelperFactory;
    protected $_bestSellerFactory;
    protected $productFactory;
    protected $_localeCurrency;
    protected $configurable;

    /**
     * FreeShippingBar constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Template\Context $context,CartFactory $_cart,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $_bestSellerFactory,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
        $this->imageHelperFactory = $imageHelperFactory;
        $this->_bestSellerFactory = $_bestSellerFactory;
        $this->_localeCurrency = $localeCurrency;
        $this->configurable = $configurable;
    }
    public function isEnable()
    {
        return $this->scopeConfig->getValue('bestseller/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getNumberBestSellerConfig()
    {
        return $this->scopeConfig->getValue('bestseller/general/numberbestseller', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getNumberPageSize()
    {
        $bestSellerCollection = $this->_bestSellerFactory->create();
        return $bestSellerCollection->count();    
    }
    public function getProductBestSeller($item){
        $bestSellerCollection = $this->_bestSellerFactory->create();
        $bestSellerCollection->getSelect()->order('qty_ordered desc');
        return $bestSellerCollection->setPageSize($item);
    }
    public function getProductUrl($id){
        $product_config = $this->configurable->getParentIdsByChild($id);
        if (isset($product_config[0])) {
            $id = $product_config[0];
        }
        $product = $this->productFactory->create()->load($id);
        return $product->getProductUrl();
    }
    public function getImageBestSeller($id){
        $product = $this->productFactory->create()->load($id);
        $imageUrl = $this->imageHelperFactory->create()->init($product, 'product_small_image')->getUrl();
        return $imageUrl;
    }
    public function getStoreCurrency(){
        $currencycode = $this->_storeManager->getStore()->getCurrentCurrencyCode();
        return $this->_localeCurrency->getCurrency($currencycode)->getSymbol();
    }
    public function getCurrentCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }
}
