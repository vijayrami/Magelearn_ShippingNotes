<?php

declare(strict_types=1);

namespace Magelearn\ShippingNotes\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Magelearn\ShippingNotes\Api\Data\ShippingNotesInterface;
use Magelearn\ShippingNotes\Api\ShippingNotesRepositoryInterface;
use Magelearn\ShippingNotes\Model\ShippingNoteConfig;

/**
 * Class ShippingNotes
 * @package Magelearn\ShippingNotes\Block\Order
 */
class ShippingNotes extends Template
{
	/**
     * @var ShippingNoteConfig
     */
    protected $shippingNoteConfig;

	/**
	 * @var Registry|null
	 */
	protected $_coreRegistry = null;

	/**
	 * @var ShippingNotesRepositoryInterface
	 */
	protected $_shippingNotesRepository;

	/**
	 * ShippingNotes constructor.
	 *
	 * @param Context $context
	 * @param Registry $registry
	 * @param ShippingNotesRepositoryInterface $shippingNotesRepository
	 * @param array $data
	 */
	public function __construct(
		Template\Context $context,
		Registry $registry,
		ShippingNotesRepositoryInterface $shippingNotesRepository,
		ShippingNoteConfig $shippingNoteConfig,
		array $data = []
	) {
		$this->_coreRegistry = $registry;
		$this->_shippingNotesRepository = $shippingNotesRepository;
		$this->shippingNoteConfig = $shippingNoteConfig;
		$this->_isScopePrivate = true;
		$this->_template = 'order/view/shipping_notes.phtml';
		parent::__construct( $context, $data );

	}
	
	/**
     * Check if show shipping note to customer account
     *
     * @return bool
     */
    public function isShowNoteInAccount()
    {
        return $this->shippingNoteConfig->isShowNoteInAccount();
    }
	
	/**
	 * Get current order
	 *
	 * @return Order
	 */
	public function getOrder() : Order {
		return $this->_coreRegistry->registry('current_order');
	}

	/**
	 * Get checkout shipping notes
	 *
	 * @param Order $order
	 *
	 * @return ShippingNotesInterface
	 */
	public function getShippingNotes( Order $order ) {
		return $this->_shippingNotesRepository->getShippingNotes($order);
	}

}