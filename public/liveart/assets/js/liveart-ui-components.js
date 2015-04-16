var liveartUI = {
    activeTab: null,
    productColorPicker: null,
    textFillColorPicker: null,
    textStrokeColorPicker: null,
    textForm: null,
    textFillColorPicker2: null,
    textStrokeColorPicker2: null,
    productsGallery: null,
    productCategories: null,
    graphicsGallery: null,
    graphicsCategories: null,
    graphicsFillColorPicker: null,
    graphicsStrokeColorPicker: null,
    productDimensionsWidth: null,
    productDimensionsHeight: null,


    closeActiveTab: function () {
        if (liveartUI.activeTab && liveartUI.activeTab.length) {
            liveartUI.activeTab.next('.dropdown-menu').hide();
            liveartUI.activeTab.parent().removeClass('open');
            liveartUI.activeTab = null;
        }
        jQuery('#liveart-main-menu').removeClass('collapsed');
    },

    showTextForm: function () {
        liveartUI.closeActiveTab();

        if (liveartUI.textForm && liveartUI.activeTab != liveartUI.textForm.prev()) {
            liveartUI.activeTab = liveartUI.textForm.prev();
            liveartUI.activeTab.next('.dropdown-menu').show();
            liveartUI.activeTab.parent().addClass('open');
            jQuery('#liveart-main-menu').addClass('collapsed');

            this.setFocusToTextTab();
        }
    },

    setFocusToTextTab: function () {
        if (jQuery('#add-text').hasClass("open")) {
            //set focus
            if (jQuery("#add-text-input").is(':visible')) {
                setTimeout(function () {
                    jQuery("#add-text-input").focus();
                }, 0);
            } else if (jQuery("#edit-text-input").is(':visible')) {
                setTimeout(function () {
                    jQuery("#edit-text-input").focus();
                }, 0);
            }
        }
    },

    createColorPickers: function () {
        var laUI = liveartUI;
        laUI.productColorPicker = jQuery('#product-color-picker');
        laUI.productColorPicker.colorPicker({ container: jQuery('#product-color-btn'), isDropup: true, gap: 2 });

        laUI.textFillColorPicker = jQuery('#text-fill-color-picker');
        laUI.textFillColorPicker.colorPicker({ gap: 2 });

        laUI.textStrokeColorPicker = jQuery('#text-stroke-color-picker');
        laUI.textStrokeColorPicker.colorPicker({ gap: 2 });

        laUI.graphicsColorPicker = jQuery('#graphics-color-picker');
        laUI.graphicsColorPicker.colorPicker({ gap: 2 });

        laUI.graphicsStrokeColorPicker = jQuery('#graphics-stroke-picker');
        laUI.graphicsStrokeColorPicker.colorPicker({ gap: 2 });

        laUI.graphicsFillColorPicker = jQuery('#graphics-fill-color-picker');
        laUI.graphicsFillColorPicker.colorPicker({ gap: 2, container: laUI.graphicsFillColorPicker.parent(), isDropup: true });

        laUI.graphicsStrokeColorPicker = jQuery('#graphics-stroke-color-picker');
        laUI.graphicsStrokeColorPicker.colorPicker({ gap: 2, container: laUI.graphicsStrokeColorPicker.parent(), isDropup: true });

        laUI.textFillColorPicker2 = jQuery('#text-fill-color-picker-2');
        laUI.textFillColorPicker2.colorPicker({ gap: 2, container: laUI.textFillColorPicker2.parent(), isDropup: true });

        laUI.textStrokeColorPicker2 = jQuery('#text-stroke-color-picker-2');
        laUI.textStrokeColorPicker2.colorPicker({ gap: 2, container: laUI.textStrokeColorPicker2.parent(), isDropup: true });

        //to force toggling color palette when clicking on button in bar
        laUI.productColorPicker.parent().click(function (e) {
            laUI.productColorPicker.next('div.colorPicker-picker').click();
        });
        //stop event propagation to avoid cycling
        laUI.productColorPicker.next('div.colorPicker-picker').click(function (e) {
            e.stopPropagation();
        });

        laUI.graphicsFillColorPicker.parent().click(function (e) {
            laUI.graphicsFillColorPicker.next('div.colorPicker-picker').click();
        });
        laUI.graphicsFillColorPicker.next('div.colorPicker-picker').click(function (e) {
            e.stopPropagation();
        });

        laUI.graphicsStrokeColorPicker.parent().click(function (e) {
            laUI.graphicsStrokeColorPicker.next('div.colorPicker-picker').click();
        });
        laUI.graphicsStrokeColorPicker.next('div.colorPicker-picker').click(function (e) {
            e.stopPropagation();
        });

        laUI.textFillColorPicker2.parent().click(function (e) {
            laUI.textFillColorPicker2.next('div.colorPicker-picker').click();
        });
        laUI.textFillColorPicker2.next('div.colorPicker-picker').click(function (e) {
            e.stopPropagation();
        });

        laUI.textStrokeColorPicker2.parent().click(function (e) {
            laUI.textStrokeColorPicker2.next('div.colorPicker-picker').click();
        });
        laUI.textStrokeColorPicker2.next('div.colorPicker-picker').click(function (e) {
            e.stopPropagation();
        });
    },

    /* jQuery File Upload init function */
    initFileUpload: function (scriptUrl, uploadHandler) {
        if (!jQuery("#fileupload").length) {
            var input = jQuery('<input id="fileupload" type="file" name="image" class="invisible" accept="image/*"/>');
            jQuery("#liveart-file-upload-container").append(input);
        }
        var modal = jQuery('#liveart-upload-bar'),
            bar = modal.find('.progress-bar');
        jQuery('#fileupload').fileupload({
            dataType: 'json',
            dropZone: null,
            url: scriptUrl,
            done: function (e, data) {
                modal.modal('hide');
                if (!data.result.error && uploadHandler) {
                    uploadHandler(data.result.url);                    
                } else {
                    alert(data.result.error.message);
                };
                jQuery("#liveart-upload-image-browse-btn").button("reset");
            },
            progressall: function (e, data) {
                jQuery("#liveart-upload-image-browse-btn").button("loading")
                var progress = parseInt(data.loaded / data.total * 100, 10);
                jQuery('.progress-bar.animate').css(
                    'width',
                    progress + '%'
                );
            },
            fail: function (e, data) {
                modal.modal('hide');
                alert('Uploading error!');
                jQuery("#liveart-upload-image-browse-btn").button("reset");
            },
            start: function (e) {
                modal.modal('show');
                bar.addClass('animate');
            }
        });

        if (!jQuery.support.fileInput) {
            jQuery("#liveart-file-upload-container").hide();
        }

    },
    /* end jQuery File Upload init function */

    /* File Upload by URL function */

    fileUploadByUrl: function (scriptUrl) {
        var modal = jQuery('#liveart-upload-bar'),
            bar = modal.find('.progress-bar');
        var fileurl = jQuery('#liveart-upload-graphics-url-input').val();
        jQuery.ajax({
            dataType: 'json',
            type: 'POST',
            url: scriptUrl,
            data: "fileurl=" + fileurl,
            success: function (data) {
                modal.modal('hide');
                if (!data.error) {
                    userInteract({ uploadGraphics: data.url });
                } else {
                    alert(data.error.message);
                };
            },
            beforeSend: function (data) {
                modal.modal('show');
                bar.addClass('animate');
                jQuery('#liveart-upload-bar .animate').css('width', '100%');
            },
            fail: function (data) {
                modal.modal('hide');
                alert('Uploading error!');
            },
            error: function (data) {
                modal.modal('hide');
                alert('Uploading error!');
            }
        });
    }
    /* end File Upload by URL function */
}

jQuery(function () {
    //tab control
    var activeTab;

    jQuery('#liveart-main-menu > .liveart-dropdown > a').click(function (e) {
        if (liveartUI.activeTab && liveartUI.activeTab.length) {
            liveartUI.activeTab.next('.dropdown-menu').hide();
            liveartUI.activeTab.parent().removeClass('open');
        }

        if (jQuery(e.currentTarget).parent("#clear-design").length != 0 &&
                liveartUI.activeTab && liveartUI.activeTab.length) {
            liveartUI.closeActiveTab();
            return;
        }

        if (liveartUI.activeTab && liveartUI.activeTab.is(e.currentTarget)) {
            jQuery('#liveart-main-menu').removeClass('collapsed');
            liveartUI.activeTab = null;
        } else {
            if (jQuery(e.currentTarget).parent("#clear-design").length != 0) {
                return;
            }
            jQuery('#liveart-main-menu').addClass('collapsed');
            liveartUI.activeTab = jQuery(e.currentTarget);
            liveartUI.activeTab.parent().addClass('open');
            liveartUI.activeTab.next('.dropdown-menu').show();
            if (jQuery('#add-text').hasClass("open")) {
                liveartUI.setFocusToTextTab();
            }
        }
    });

    jQuery('#liveart-main-menu > .liveart-dropdown > .dropdown-menu > .liveart-dropdown-form-header > .liveart-close-window-btn').click(function (e) {
        liveartUI.closeActiveTab();
    });

    jQuery.fn.colorPicker.defaults.colors = ['000', 'fff'];
    liveartUI.createColorPickers();
    liveartUI.textForm = jQuery('#add-text-form');
    liveartUI.productCategories = jQuery('#liveart-product-categories');
    liveartUI.productsGallery = jQuery('#liveart-product-gallery');
    liveartUI.productsGallery.hide();
    liveartUI.graphicsCategories = jQuery('#liveart-graphics-categories');
    liveartUI.graphicsGallery = jQuery('#liveart-graphics-gallery');
    liveartUI.graphicsGallery.hide();

    //for validation
    liveartUI.productDimensionsWidth = jQuery('#productDimensionsWidth');
    liveartUI.productDimensionsHeight = jQuery('#productDimensionsHeight');

    //jager: hack for names-numbers sizes dropdown menu
    var dropdownList;

    var modalHandler = function (e) {
        var target = jQuery(e.target);
        var dropdownToggle = dropdownList.prev('.dropdown-toggle');
        var btnGroup = dropdownList.parent();

        if (dropdownToggle.find(target).length > 0 || (!btnGroup.hasClass('open') && dropdownToggle.is(target))) return;
        dropdownList.hide();
        jQuery('body').unbind('click', modalHandler);
    }

    jQuery('#names-number-table').delegate('.liveart-names-numbers-size > .dropdown-toggle', 'click', function (e) {
        dropdownList = jQuery(this).next('.dropdown-menu');
        var position = jQuery(this).prev('.btn').offset();
        position.top += (jQuery(this).outerHeight() + 2);
        dropdownList.css('position', 'fixed');
        dropdownList.show();
        dropdownList.offset(position);
        jQuery('body').click(modalHandler);
    });

    //jager: format names-numbers buttons handlers
    var formatNamesNumbersHandler = function () {
        liveartUI.activeTab.next('.dropdown-menu').hide();
        liveartUI.activeTab.parent().removeClass('open');
        liveartUI.activeTab = jQuery('#add-text').children('a:first');
        liveartUI.activeTab.parent().addClass('open');
        liveartUI.activeTab.next('.dropdown-menu').show();
    }

    jQuery('#format-names-btn').click(formatNamesNumbersHandler);
    jQuery('#format-numbers-btn').click(formatNamesNumbersHandler);
});

/* Alert */

liveart_alert = function () { };

liveart_alert.show = function (message) {
    jQuery('#liveart-alert-message').text(message);
    jQuery('#liveart-alert-popup').modal('show');
}

/* Alert end */

/*  $.noUiSlider - WTFPL - refreshless.com/nouislider/ v6.0.0 
    Mouseleave event checks if a cursor is on "liveart-main-container".
    When it leaves the container, we remove "noUi-active" class from current slider
*/
jQuery(function () {
    jQuery("#liveart-main-container").mouseleave(function () {
        var active = jQuery(".noUiSlider .noUi-origin div").hasClass("noUi-active");
        if (active) {
            jQuery(".noUiSlider .noUi-origin div").removeClass("noUi-active");
        }
        return true;
    });
});
