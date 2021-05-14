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
            if(self.options.item <= self.options.itemCount * self.options.pageNum) {                
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
                
                dataType: 'json',
                beforeSend: function() {
                    $('body').trigger('processStart');
                },

                success: function(res) {
                    if (res != '')
                    {   
                        var obj = JSON.parse(res);       

                        for(var k in obj) {
                            $('.bestseller').append("<li id='bestseller-item'>"
                                +"<a href="+ obj[k].url +"><img src=" + obj[k].src + "></a>"
                                +"<a href="+ obj[k].url +"><p class='bestseller-name'>"+ obj[k].name +"</p></a>"
                                +"<p class='bestseller-price'>"+ obj[k].price +"</p>"
                                +"<p class='bestseller-order'>" + 'Ordered: ' + obj[k].ordered + "</p>"
                            );
                            $('.bestseller').append("</li>"); 
                         }
                           
                        self._isShow();
                    }
                    $('body').trigger('processStop');
                }
            });
        },
    });

    return $.mage.list;
});