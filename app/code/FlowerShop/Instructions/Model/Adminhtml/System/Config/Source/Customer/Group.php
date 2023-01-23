<?php
declare(strict_types=1);

namespace FlowerShop\Instructions\Model\Adminhtml\System\Config\Source\Customer;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;


/**
 * Class
 */
class Group implements OptionSourceInterface
{
    /**
     * @var
     */
    protected $options;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $groupCollectionFactory;

    /**
     * @param CollectionFactory $groupCollectionFactory
     */
    public function __construct(
        CollectionFactory $groupCollectionFactory
    )
    {
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = $this->groupCollectionFactory->create()->loadData()->toOptionArray();
        }
        return $this->options;
    }
}
