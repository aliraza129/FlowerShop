<?php
declare(strict_types=1);

namespace FlowerShop\Instructions\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use FlowerShop\Instructions\Helper\Data;

/**
 * Plugin Class
 */
class LayoutProcessorPlugin
{
    /**
     * @var Data
     */
    private Data $data;

    /**
     * @param Data $data
     */
    public function __construct(
        Data $data
    ){

        $this->data = $data;
    }

    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array  $jsLayout
    ) {
        if ($this->data->getCustomerGroup() == 1) {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['before-form']['children']['flower_setting'] = [
                'component' => 'Magento_Ui/js/form/element/date',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/date',
                    'options' => [],
                    'id' => 'flower_setting'
                ],
                'dataScope' => 'shippingAddress.flower_setting',
                'label' => __('Flower Setting Instruction'),
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 200,
                'id' => 'flower_setting'
            ];
        }

        return $jsLayout;
    }

}
