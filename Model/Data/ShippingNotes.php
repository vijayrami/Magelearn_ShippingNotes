<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;

/**
 * Class ShippingNotes
 * @package Magelearn\ShippingNotes\Model\Data
 */
class ShippingNotes extends AbstractExtensibleObject implements ShippingNotesInterface
{

	/**
	 * Get checkout shipping notes
	 *
	 * @return string|null
	 */
	public function getCheckoutShippingNotes() {
		return $this->_get(self::CHECKOUT_SHIPPING_NOTES);
	}

	/**
	 * Set checkout shipping notes
	 *
	 * @param string|null $checkoutShippingNotes
	 *
	 * @return ShippingNotesInterface
	 */
	public function setCheckoutShippingNotes( string $checkoutShippingNotes = null ) {
		return $this->setData(self::CHECKOUT_SHIPPING_NOTES, $checkoutShippingNotes);
	}

}