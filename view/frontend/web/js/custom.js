/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @deprecated since version 2.2.0
 */
 define([
    'jquery',
    'mage/template',
    'jquery-ui-modules/widget'
], function ($, mageTemplate) {
    'use strict';

    $.widget('mage.list', {
        options: {
            url: 'AHT_BestSeller/getInfo',
            triggerEvent: 'click'
        },

        _create: function() {
            this._bind();
        },

        _bind: function() {
            var self = this;
            self.element.on(self.options.triggerEvent, function() {
                self._ajaxSubmit();
            });
        },

        _ajaxSubmit: function() {
            var self = this;
            $.ajax({
                url: self.options.url,
                dataType: 'json',
                beforeSend: function() {
                    console.log('beforeSend');
                    $('body').trigger('processStart');
                },
                success: function(res) {
                    console.log('success');
                    console.log(res);
                    $('body').trigger('processStop');
                }
            });
        },
    });

    return $.mage.list;
});