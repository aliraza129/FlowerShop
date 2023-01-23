<?php
declare(strict_types=1);

namespace FlowerShop\Instructions\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Framework\App\RequestInterface;

/**
 * Data Save Class
 */
class Save implements ActionInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    protected QuoteIdMaskFactory $quoteIdMaskFactory;

    /**
     * @var CartRepositoryInterface
     */
    protected CartRepositoryInterface $quoteRepository;
    /**
     * @var RequestInterface
     */
    private RequestInterface $requestInterface;

    /**
     * @param Context $context
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param CartRepositoryInterface $quoteRepository
     * @param RequestInterface $requestInterface
     */
    public function __construct(
        Context $context,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $quoteRepository,
        RequestInterface $requestInterface
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->requestInterface = $requestInterface;
    }

    /**
     * @return void
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $post = $this->requestInterface->getPostValue();
        if ($post) {
            $cartId       = $post['cartId'];
            $flowerSetting = $post['flower_setting'];
            $loggin       = $post['is_customer'];

            if ($loggin === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('flower_setting', $flowerSetting);
            $this->quoteRepository->save($quote);
        }
    }
}
