<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Api\Data;

/**
 * Interface ShippingNotesInterface
 * @package Magelearn\ShippingNotes\Api\Data
 */
interface ShippingNotesInterface
{
	const CHECKOUT_SHIPPING_NOTES = 'checkout_shipping_notes';

	/**
	 * Get checkout shipping notes
	 *
	 * @return string|null
	 */
	public function getCheckoutShippingNotes();

	/**
	 * Set checkout shipping notes
	 *
	 * @param string|null $checkoutShippingNotes
	 * @return ShippingNotesInterface
	 */
	public function setCheckoutShippingNotes(string $checkoutShippingNotes = null);

}
