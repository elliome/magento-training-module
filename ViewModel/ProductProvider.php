<?php declare(strict_types=1);

namespace Elliot\LandingPage\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductProvider implements ArgumentInterface
{
    protected ProductFactory $productFactory;

    public function __construct(
        ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    public function getProduct(int $id): Product
    {
        /** @var $product Product */
        $product = $this->productFactory->create();
        $product->load($id);

        return $product;
    }
}
