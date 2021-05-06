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
            url: 'bestseller/index/bestSeller',
            method: 'post',
            pageNum: 1,
            triggerEvent: 'click'
        },

        _create: function() {
            var self = this;
            if(self.options.itemCount > self.options.item) {
                $('#show-more').remove();
            }
            this._bind();
            // console.log(self.options.itemCount);
        },

        _bind: function() {
            var self = this;
            self.element.on(self.options.triggerEvent, function() {
                self.options.pageNum +=1;
                self._ajaxSubmit();
            });
        },

        _isShow: function() {
            var self = this;
            if(self.options.itemCount <= self.options.pageNum*self.options.pageNum) {
                $('#show-more').remove();
            }
        },

        _ajaxSubmit: function() {
            var self = this;
            $.ajax({
                url: self.options.url,
                type: self.options.method,
                data: {
                    pageNum: self.options.pageNum
                },
                
                dataType: 'html',
                beforeSend: function() {
                    $('body').trigger('processStart');
                },

                success: function(res) {
                    if (res != '')
                    {   
                        $('.bestseller').append(res);
                        self._isShow();
                    }
                    $('body').trigger('processStop');
                    // $('#show-more').remove();
                }
            });
        },
    });

    return $.mage.list;
});