<?php
declare(strict_types=1);

namespace FlowerShop\Instructions\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Class OrderExport
 */
class OrderExport extends Command
{
    const ARG_NAME_CUSTOMER_ID = 'customer-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollectionFactory;


    /**
     * @param string|null $name
     */
    public function __construct(
        CollectionFactory $orderCollectionFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('customer-order-export:run')
            ->setDescription('Export order to ERP')
            ->addArgument(
                self::ARG_NAME_CUSTOMER_ID,
                InputArgument::REQUIRED,
                "Customer ID"
            )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Shipping date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_MERCHANT_NOTES,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes'
            );
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customerId = (int) $input->getArgument(self::ARG_NAME_CUSTOMER_ID);

        $customerOrder = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);
        $output->writeln(print_r($customerOrder->getData(), true));

        return 0;
    }
}
