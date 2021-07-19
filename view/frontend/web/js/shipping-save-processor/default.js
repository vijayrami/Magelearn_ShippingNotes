/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'ko',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/resource-url-manager',
    'mage/storage',
    'Magento_Checkout/js/model/payment-service',
    'Magento_Checkout/js/model/payment/method-converter',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Checkout/js/model/full-screen-loader',
    'Magento_Checkout/js/action/select-billing-address',
    'Magento_Checkout/js/model/shipping-save-processor/payload-extender',
    'jquery',
    'Magento_Ui/js/modal/alert'
], function (
    ko,
    quote,
    resourceUrlManager,
    storage,
    paymentService,
    methodConverter,
    errorProcessor,
    fullScreenLoader,
    selectBillingAddressAction,
    payloadExtender,
    $,
    alert
) {
    'use strict';

    return {
        /**
         * @return {jQuery.Deferred}
         */
        saveShippingInformation: function () {
            var payload;
			
			if (window.checkoutConfig.show_shipping_note > 0 && window.checkoutConfig.max_length) {
			var shipping_notes = $('textarea[name="checkout_shipping_notes"]').val();
			//console.log(shipping_notes.length);
          	/*============ Customization Start =============*/
          	//if(quote.shippingMethod().method_code=='flaterate_flaterate'){ // Check if flaterate is selected
            if(shipping_notes.length > window.checkoutConfig.max_length){
              alert({
                title: $.mage.__('Error'),
                content: $.mage.__('Please correct shipping notes character to further proceed.')
              });
              $(".shippipng-notes-error").show(); // show hidden message
              $('textarea[name="checkout_shipping_notes"]').focus();// move cursor to the point
              return false;
             }
           }
          // }
          /*============ Customization End =============*/
             
            if (!quote.billingAddress() && quote.shippingAddress().canUseForBilling()) {
                selectBillingAddressAction(quote.shippingAddress());
            }

            payload = {
                addressInformation: {
                    'shipping_address': quote.shippingAddress(),
                    'billing_address': quote.billingAddress(),
                    'shipping_method_code': quote.shippingMethod()['method_code'],
                    'shipping_carrier_code': quote.shippingMethod()['carrier_code']
                }
            };

            payloadExtender(payload);

            fullScreenLoader.startLoader();

            return storage.post(
                resourceUrlManager.getUrlForSetShippingInformation(quote),
                JSON.stringify(payload)
            ).done(
                function (response) {
                    quote.setTotals(response.totals);
                    paymentService.setPaymentMethods(methodConverter(response['payment_methods']));
                    fullScreenLoader.stopLoader();
                }
            ).fail(
                function (response) {
                    errorProcessor.process(response);
                    fullScreenLoader.stopLoader();
                }
            );
        }
    };
});
