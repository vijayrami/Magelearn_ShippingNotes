<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Plugin\Block\Adminhtml;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Block\Adminhtml\Order\View\Info;
use Magelearn\ShippingNotes\Api\ShippingNotesRepositoryInterface;

/**
 * Class ShippingNotesPlugin
 * @package Magelearn\ShippingNotes\Plugin\Block\Adminhtml
 */
class ShippingNotesPlugin
{

	/**
	 * @var ShippingNotesRepositoryInterface
	 */
	protected $_shippingNotesRepository;

	/**
	 * ShippingNotesPlugin constructor.
	 *
	 * @param ShippingNotesRepositoryInterface $shippingNotesRepository
	 */
	public function __construct(
		ShippingNotesRepositoryInterface $shippingNotesRepository
	) {
		$this->_shippingNotesRepository = $shippingNotesRepository;
	}

	/**
	 * Add shipping notes to order view block
	 *
	 * @param Info $subject
	 * @param string $result
	 *
	 * @return string
	 * @throws LocalizedException
	 */
	public function afterToHtml( Info $subject, $result ) {
		$block = $subject->getLayout()->getBlock('order_shipping_notes');
		if ($block !== false) {
			$block->setOrderShippingNotes(
				$this->_shippingNotesRepository->getShippingNotes($subject->getOrder())
			);
			$result = $result . $block->toHtml();
		}

		return $result;
	}

}