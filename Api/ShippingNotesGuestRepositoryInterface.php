<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Api;

use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;

/**
 * Interface ShippingNotesGuestRepositoryInterface
 * @package Magelearn\ShippingNotes\Api
 */
interface ShippingNotesGuestRepositoryInterface
{

	/**
	 * Save checkout shipping notes
	 *
	 * @param string $cartId
	 * @param \Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface $shippingNotes
	 *
	 * @return \Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface
	 */
	public function saveShippingNotes(
		string $cartId,
		ShippingNotesInterface $shippingNotes
	): ShippingNotesInterface;

}