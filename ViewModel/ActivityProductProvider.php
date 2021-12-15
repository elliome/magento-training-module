<?php

declare(strict_types=1);

namespace Elliot\LandingPage\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Directory\Model\Currency;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Helper\Image;
use Magento\Framework\App\Request\Http;

class ActivityProductProvider implements ArgumentInterface
{
    protected CollectionFactory $productCollectionFactory;
    protected Image $imageHelper;
    protected Visibility $visibility;
    protected Http $http;

    public function __construct(
        CollectionFactory $productCollectionFactory,
        Currency $currency,
        Image $imageHelper,
        Http $http
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->currency = $currency;
        $this->imageHelper = $imageHelper;
        $this->http = $http;
    }


    public function getProducts(): Collection
    {
        /** @var $productCollection Collection */
        $productCollection = $this->productCollectionFactory->create()
            ->addAttributeToFilter(
                'visibility',
                Visibility::VISIBILITY_BOTH
            )
            ->addAttributeToFilter(
                'type_id',
                ['eq' => 'simple']
            )
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('small_image')
            ->addAttributeToSelect('activity')

            ->addAttributeToFilter(
                'activity',
                ['neq' => null]
            )
            ->setPageSize(12);

        $query = $this->http->getParam('activity');
        if($query !== null)
        {
            $productCollection->addAttributeToFilter(
                'activity',
                ['finset' => $query]
            );
        }


        return $productCollection;
    }

    public function getCurrencySymbol(): string
    {
        $currencySymbol = $this->currency->getCurrencySymbol();

        return $currencySymbol;
    }

    public function getImageUrl(Product $product, string $imageId): string
    {
        $imageUrl = $this->imageHelper->init($product, $imageId)->getUrl();

        return $imageUrl;
    }
}
