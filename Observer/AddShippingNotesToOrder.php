<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;

/**
 * Class AddShippingNotesToOrder
 * @package Magelearn\ShippingNotes\Observer
 */
class AddShippingNotesToOrder implements ObserverInterface
{
	/**
     * @var \Magento\Framework\DataObject\Copy
     */
    protected $objectCopyService;
	
	/**
     * @param \Magento\Framework\DataObject\Copy $objectCopyService
     */
    public function __construct(
        \Magento\Framework\DataObject\Copy $objectCopyService
    )
    {
        $this->objectCopyService = $objectCopyService;
    }
	
	/**
	 * Execute observer method.
	 *
	 * @param Observer $observer Observer
	 *
	 * @return void
	 */
	public function execute( Observer $observer ) {
		/** @var \Magento\Sales\Model\Order $order */
		$order = $observer->getEvent()->getData('order');
		/** @var \Magento\Quote\Model\Quote $quote */
		$quote = $observer->getEvent()->getData('quote');

		/*$order->setData(
			ShippingNotesInterface::CHECKOUT_SHIPPING_NOTES,
			$quote->getData(ShippingNotesInterface::CHECKOUT_SHIPPING_NOTES)
		);*/
		$order->setCheckoutShippingNotes($quote->getCheckoutShippingNotes());

        $this->objectCopyService->copyFieldsetToTarget('sales_convert_quote', 'to_order', $quote, $order);

        return $this;
	}

}