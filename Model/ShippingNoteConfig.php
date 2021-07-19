<?php

namespace Magelearn\ShippingNotes\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Authorization\Model\UserContextInterface;


class ShippingNoteConfig implements ConfigProviderInterface
{
    /**
     *  Config Paths
     */
    const XML_PATH_GENERAL_ENABLED = 'shipping_note/general/enabled';
    const XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT = 'shipping_note/general/is_show_in_myaccount';
    const XML_PATH_GENERAL_MAX_LENGTH = 'shipping_note/general/max_length';


    /**
     * @var \Magento\Authorization\Model\UserContextInterface
     */
    private $userContext;


    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;


    /**
     * @var \Magento\Framework\App\Action\Context
     */
    private $context;

    /**
     * @var \Magento\Quote\Api\Data\CartInterface
     */
    private $quote;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        UserContextInterface $userContext,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Checkout\Model\Session $session,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->userContext = $userContext;
        $this->quoteRepository = $quoteRepository;
        $this->scopeConfig = $scopeConfig;
        $this->session = $session;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_GENERAL_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if show order note to customer account
     *
     * @return bool
     */
    public function isShowNoteInAccount()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get order note max length
     *
     * @return int
     */
    public function getConfig()
    {
        $show_shipping_note = $this->getItemInternalShippingNote();
        return [
            'max_length' => (int)$this->scopeConfig->getValue(self::XML_PATH_GENERAL_MAX_LENGTH, ScopeInterface::SCOPE_STORE),
            'show_shipping_note' => $show_shipping_note
        ];
    }

    public function getItemInternalShippingNote()
    {
        $showShippingNote = false;
        if (!$this->isEnabled()) {
            return $showShippingNote;
        } else {
        	$showShippingNote = true;
        }

        return $showShippingNote;
    }


    /**
     * Get quote.
     *
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote()
    {
        if ($this->quote === null) {
            try {
                if ($this->userContext->getUserId()) {
                    $this->quote = $this->quoteRepository->getActiveForCustomer($this->userContext->getUserId());
                } else {
                    $this->quote = $this->session->getQuote();
                }

            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                // $this->quote = $this->quoteRepository->get($id);
            }
        }

        return $this->quote;
    }
}
