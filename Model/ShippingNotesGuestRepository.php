<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Model;

use Magento\Quote\Model\QuoteIdMaskFactory;
use Magelearn\ShippingNotes\Api\ShippingNotesGuestRepositoryInterface;
use Magelearn\ShippingNotes\Api\ShippingNotesRepositoryInterface;
use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;

/**
 * Class ShippingNotesGuestRepository
 * @package Magelearn\ShippingNotes\Model
 */
class ShippingNotesGuestRepository implements ShippingNotesGuestRepositoryInterface
{

	/**
	 * @var QuoteIdMaskFactory
	 */
	protected $_quoteIdMaskFactory;

	/**
	 * @var ShippingNotesRepositoryInterface
	 */
	protected $_shippingNotesRepository;

	/**
	 * @param QuoteIdMaskFactory               $quoteIdMaskFactory
	 * @param ShippingNotesRepositoryInterface $shippingNotesRepository
	 */
	public function __construct(
		QuoteIdMaskFactory $quoteIdMaskFactory,
		ShippingNotesRepositoryInterface $shippingNotesRepository
	) {
		$this->_quoteIdMaskFactory     = $quoteIdMaskFactory;
		$this->_shippingNotesRepository = $shippingNotesRepository;
	}

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
	): ShippingNotesInterface {
		/** @var \Magento\Quote\Model\Quote  $quoteIdMask */
		$quoteIdMask = $this->_quoteIdMaskFactory->create()->load($cartId, 'masked_id');
		return $this->_shippingNotesRepository->saveShippingNotes((int)$quoteIdMask->getQuoteId(), $shippingNotes);
	}

}