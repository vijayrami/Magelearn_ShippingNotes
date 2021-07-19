<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Api;

use Magento\Sales\Model\Order;
use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;

/**
 * Interface ShippingNotesRepositoryInterface
 * @package Magelearn\ShippingNotes\Api
 */
interface ShippingNotesRepositoryInterface
{

	/**
	 * Save checkout shipping notes
	 *
	 * @param int $cartId
	 * @param \Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface $shippingNotes
	 *
	 * @return \Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface
	 */
	public function saveShippingNotes(
		int $cartId,
		ShippingNotesInterface $shippingNotes
	): ShippingNotesInterface;

	/**
	 * Get checkout shipping notes
	 *
	 * @param Order $order Order
	 *
	 * @return \Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface
	 */
	public function getShippingNotes(Order $order) : ShippingNotesInterface;

}