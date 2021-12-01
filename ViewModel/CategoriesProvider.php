<?php declare(strict_types=1);

namespace Elliot\LandingPage\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoriesProvider implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $categoryCollectionFactory;

    /**
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        CollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * @param int $limit
     * @param string $order_by
     * @param string $order_direction
     */
    public function getCategories($limit=10, $order_by = 'id', $order_direction = 'asc'){
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToFilter(
            'level',
            ['eq' => 2]
        )
        ->addAttributeToFilter(
            'is_active',
            ['eq' => '1']
        )
        ->setOrder($order_by, $order_direction)
        ->setPageSize($limit)
        ->addAttributeToSelect('*');

        return $collection;
    }
}
