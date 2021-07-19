<?php
namespace Magelearn\ShippingNotes\Plugin\Model\Checkout;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class LayoutProcessor
{
	/**
     *  Config Paths
     */
    const XML_PATH_GENERAL_MAX_LENGTH = 'shipping_note/general/max_length';
		  
	/**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }
	
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['before-form']['children']['custom-checkout-form-container']['children']['shipping-notes-form-fieldset']['children']['checkout_shipping_notes'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingNotesForm',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/textarea',
                'cols'		  => 10,
                'rows'		  => 4,
            ],
            'notice' => ($this->getMaxNoteLength() > 0) ? "Limited to ".$this->getMaxNoteLength()." characters.": '',
            'provider' => 'checkoutProvider',
            'dataScope' => 'shippingNotesForm.checkout_shipping_notes',
            'label' => 'Enter Shipping Notes',
            'sortOrder' => 10,
            'validation' => [
                'max_text_length' => $this->getMaxNoteLength(),
            ],
        ];
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['before-form']['children']['custom-checkout-form-container']['children']['shipping-notes-form-fieldset']['children']['shipping_notes_error_text'] = [
            'component' => 'uiComponent',
            'config' => [
                'template' => 'Magelearn_ShippingNotes/error_text',
            ],
            'sortOrder' => 35,
        ];

        return $jsLayout;
    }
	
	public function getMaxNoteLength () {
		$max_length = (int)$this->scopeConfig->getValue(self::XML_PATH_GENERAL_MAX_LENGTH, ScopeInterface::SCOPE_STORE);
		if($max_length > 0) {
			return $max_length;
		} else {
			return false;
		}
	}
}
