(function ($) {
    Drupal.behaviors.md_thenews = {
        attach: function () {
            $('#edit-logo').appendTo($('#edit-favicon-webclip > .fieldset-wrapper'));
            $('#edit-favicon').appendTo($('#edit-favicon-webclip > .fieldset-wrapper'));
            $('.form-item-css3-textarea').before($('#edit-theme-settings'));
            $('#edit-skins, #edit-choose-pattern, #edit-contentop-blocks, #edit-sidebar-position, #edit-bottom-blocks, #edit-node-article-display, #edit-node-photo-display, #edit-node-video-display').removeClass('form-select');


        }
    };
})(jQuery);

jQuery(function ($) {
    var colorpickerHTML = '<span class="colorSelect"><span></span></span>';


    $(".md-listleft a").click(function () {
        $(this).parent().parent().find("a").removeClass("border-white");
        $(this).parent().prev().find("a").addClass("border-white")
    });

    // Fonts
    $(".choosefont").choosefont();

    // Change select
    $('.form-select').dropkick();

    $("#md-general-settings, #md-design, #md-text-typography, #md-pages, #md-nodes, #md-sliders, #md-custom-code, #md-tabs, #md-subtabs").tabs({
        cookie: {
            expires: 1
        }
    });

    $(".md-listleft li.ui-state-active").each(function () {
        $(this).prev().find("a").addClass("border-white");
    });

    // Color picker
    $('.form-colorpicker').before(colorpickerHTML);
    $('.colorSelect').each(function () {
        tmpbackground = $(this).next().val();
        $(this).css({'background-color': "#" + tmpbackground});
    });
    $('span.colorSelect').ColorPicker({
        onSubmit: function (hsb, hex, rgb, el) {
            $(el).css({'background-color': "#" + hex});
            $(el).next().val(hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            current_obj = this;
            $(this).ColorPickerSetColor($(this).next().val());
        },
        onChange: function (hsb, hex, rgb) {
            $(current_obj).css({'background-color': "#" + hex});
            $(current_obj).next().val(hex);
        }
    });


    listcontentw = $(".md-wrap").width() - 300;
    $(".md-listcontent").width(listcontentw);

    $('.md-listcontent legend').each(function () {
        tmphtml = $(this).find('span').html();
        $(this).replaceWith('<h3>' + tmphtml + '</h3>');
    });

    // Design: Background
    changebackground($('#dk_container_edit-choose-bg .dk_option_current a').attr('data-dk-dropdown-value'));
    $('#dk_container_edit-choose-bg .dk_options_inner a').click(function () {
        changebackground($(this).attr('data-dk-dropdown-value'));
    });


    fakeselect('#edit-choose-pattern', 'pt', 44);
    // background pattern
    if ($('#edit-bg-color').val()) {
        $('.ptwrap div').css({'background-color': '#' + $('#edit-bg-color').val()})
    }
    // Background color picker
    $('input#edit-bg-color').before('<span id="backgroundcolorselect" class="colorSelect2"><span></span></span>');
    $('.colorSelect2').each(function () {
        tmpbackground = $(this).next().val();
        $(this).css({'background-color': "#" + tmpbackground});
        $('.ptwrap div').css({'background-color': "#" + tmpbackground});
    });
    $('span.colorSelect2').ColorPicker({
        onSubmit: function (hsb, hex, rgb, el) {
            $(el).css({'background-color': "#" + hex});
            $('.ptwrap div').css({'background-color': "#" + hex});
            $(el).next().val(hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            current_obj = this;
            $(this).ColorPickerSetColor($(this).next().val());
        },
        onChange: function (hsb, hex, rgb) {
            $(current_obj).css({'background-color': "#" + hex});
            $('.ptwrap div').css({'background-color': "#" + hex});
            $(current_obj).next().val(hex);
        }
    });

    fakeselect('#edit-skins', 'sk', 7);
    fakeselect('#edit-sidebar-position', 'sbp', 2);
    fakeselect('#edit-contentop-blocks', 'fb', 4);
    fakeselect('#edit-bottom-blocks', 'bb', 6);
    fakeselect('#edit-node-article-display', 'nbd', 6);
    fakeselect('#edit-node-photo-display', 'npd', 4);
    fakeselect('#edit-node-video-display', 'nvd', 4);

    // Design: Header
    changetopbl($('#dk_container_edit-ht-type .dk_option_current a').attr('data-dk-dropdown-value'));
    $('#dk_container_edit-ht-type .dk_options_inner a').click(function () {
        changetopbl($(this).attr('data-dk-dropdown-value'));
    });

    // Design: Footer
    inputtoslide("#edit-footer-bo-size", 1, 20);
    // Design: Block
    inputtoslide("#edit-block-title-content-space", 0, 20);
    inputtoslide("#edit-block-bo-size", 1, 20);

    // Border type:
    $('.form-bordertype label').each(function () {
        $(this).after('<div class="border-type border-type-' + $(this).text() + '"></div>')
    })

    filestyle("#edit-logo-upload", '.form-item-files-logo-upload', '.form-item-logo-path', 1);
    filestyle("#edit-favicon-upload", '.form-item-files-favicon-upload', '.form-item-favicon-path', 1);
    filestyle("#edit-webclip-upload", '.form-item-files-webclip-upload', '.form-item-webclip-path');
    filestyle("#edit-bg-upload", '.form-item-files-bg-upload', '.form-item-bg-path');


    $(document).bind('keydown', function (e) {
        var
            $open1 = $('#dk_container_edit-choose-bg.dk_open'),
            $focused1 = $('#dk_container_edit-choose-bg.dk_focus'),
            $dk1 = null;

        if ($open1.length) {
            $dk1 = $open1;
        } else if ($focused1.length && !$open1.length) {
            $dk1 = $focused1;
        }

        if ((e.keyCode == 13) && $dk1) {
            changebackground($('#dk_container_edit-choose-bg .dk_option_current a').attr('data-dk-dropdown-value'));
        }

        var
            $open2 = $('#dk_container_edit-ht-type.dk_open'),
            $focused2 = $('#dk_container_edit-ht-type.dk_focus'),
            $dk2 = null;

        if ($open2.length) {
            $dk2 = $open2;
        } else if ($focused2.length && !$open2.length) {
            $dk2 = $focused2;
        }

        if ((e.keyCode == 13) && $dk2) {
            changetopbl($('#dk_container_edit-ht-type .dk_option_current a').attr('data-dk-dropdown-value'));
        }
    });

    /* Custom node display */
    shareEnable();
    $('#edit-node-enable').bind('change', function () {
        if ($(this).is(':checked')) {
            $('#md-nodes .md-listleft li').show();
        } else {
            $('#md-nodes .md-listleft li:not(:first)').hide();
        }
    });
    $('#edit-nodetitle-enable').bind('change', function () {
        if ($(this).is(':checked')) {
            $('#node-custom-typo').slideDown();
        } else {
            $('#node-custom-typo').slideUp();
        }
    });
    $('#edit-node-enable, #edit-nodetitle-enable').trigger('change');


    /* Functions
     --------------------------------------------------------------------------*/
    function toggleBounce() {

        if (marker.getAnimation() != null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    function changebackground(bg) {
        switch (bg) {
            case '0':
                $('#design-bg-pattern, #design-bg-custom').hide();
                break;
            case '1':
                $('#design-bg-pattern').show();
                $('#design-bg-custom').hide();
                break;
            case '2':
                $('#design-bg-custom').show();
                $('#design-bg-pattern').hide();
                break;
            default:
                $('#design-bg-pattern, #design-bg-custom').hide();
        }
    }

    function changetopbl(bg) {
        switch (bg) {
            case '1':
                $('.form-item-ht-text').show();
                break;
            default:
                $('.form-item-ht-text').hide();
        }
    }

    function filestyle(file, filewrap, path, inputtext) {
        inputtext = typeof inputtext !== 'undefined' ? inputtext : 0;

        $(path).find('.form-text').after($(file));
        $(filewrap).remove();

        var self = $(file);
        var text = $('<div class="filetext"><span></span>Upload a file</div>');

        self.wrap('<div class="filewrapper btn-upload">').after(text).css({"opacity": "0"}).bind("change", function () {
            if (inputtext == 1) {
                $(path).find('.description').before('<div>File: ' + self.val().replace("C:\\fakepath\\", "") + ' selected</div>');
            } else {
                $(path).find('.form-text').val(self.val().replace("C:\\fakepath\\", ""));
            }
        });
    }

    function fakeselect($select, $block, $optionnumber) {
        var $block_html = '<div class="' + $block + 'wrap clearfix">';
        var $tmpval = 0;
        for ($i = 0; $i <= $optionnumber; $i++) {
            $tmpval = $($select + " option:eq(" + $i + ")").val();
            if ($tmpval) {
                $block_html += '<div id="' + $block + $tmpval + '" class="slitem"></div>';
            }
        }
        $block_html += '</div>';

        $($select).parent().append($block_html);

        var $tmpselect = $($select + " option[selected]").val();
        $('#' + $block + $tmpselect).addClass('selected');

        $('.' + $block + 'wrap .slitem').each(function () {
            $(this).click(function () {
                $('.' + $block + 'wrap .selected').removeClass('selected');
                $(this).addClass('selected');
                $($select + " option[selected]").removeAttr("selected");
                tmpindex = $(this).attr('id').replace($block, "")
                $($select + " option[value=" + tmpindex + "]").attr("selected", "selected");
            });
        });
        $($select).hide();
    }

    function changeimgsize(id, maxw, maxh) {
        $(id + " .imgwidth").after('<div class="slider-width"></div>');
        $(id + " .imgheight").after('<div class="slider-height"></div>');
        $(id + " .constrain").after('<div class="button" style="width: 34px; margin: 5px 0 0">reset</div>');
        resetwidth = imgwidth = $(id + " .slider-img:first").width();
        resetheight = imgheight = $(id + " .slider-img:first").height();
        var ratio = 0;
        $(id + " .constrain").change(function () {
            if ($(this).is(':checked')) {
                imgwidth = $(id + " .imgwidth").val();
                imgheight = $(id + " .imgheight").val();
            }
        });
        $(id + " .slider-width").slider({
            range: "min",
            value: imgwidth,
            min: 10,
            max: maxw,
            step: 1,
            slide: function (event, ui) {
                if ($(id + " .constrain:checked").length > 0) {
                    ratio = ui.value / imgwidth;
                    newheight = jqROund(imgheight * ratio);
                    if (newheight > maxh) {
                        return false;
                    } else {
                        $(id + " .slider-height").slider("value", newheight);
                        $(id + " .slider-img").height(newheight);
                        $(id + " .imgheight").val(newheight);
                    }
                }
                $(id + " .imgwidth").val(ui.value);
                $(id + " .slider-img").width(ui.value);
            }
        });

        $(id + " .slider-height").slider({
            range: "min",
            value: imgheight,
            min: 10,
            max: maxh,
            step: 1,
            slide: function (event, ui) {
                if ($(id + " .constrain:checked").length > 0) {
                    ratio = ui.value / imgheight;
                    newwidth = jqROund(imgwidth * ratio);
                    if (newwidth > maxw) {
                        return false;
                    } else {
                        $(id + " .slider-width").slider("value", newwidth);
                        $(id + " .slider-img").width(newwidth);
                        $(id + " .imgwidth").val(newwidth);
                    }
                }
                $(id + " .imgheight").val(ui.value);
                $(id + " .slider-img").height(ui.value);
            }
        });

        $(id + " .button").click(function () {
            imgwidth = resetwidth;
            imgheight = resetheight;
            $(id + " .imgwidth").val(resetwidth);
            $(id + " .slider-width").slider("value", resetwidth);
            $(id + " .imgheight").val(resetheight);
            $(id + " .slider-height").slider("value", resetheight);
            $(id + " .slider-img").css({
                'width': resetwidth,
                'height': resetheight
            });
            return false;
        })
    }

    function inputtoslide(id, minv, maxv) {
        sliderclass = id.replace("#", "") + 'inputtoslide';
        $(id).before('<div class="' + sliderclass + ' inputtoslide"></div>').after(' px');
        $(id).parent().addClass('input-slide');
        $("." + sliderclass).slider({
            value: $(id).val(),
            range: "min",
            min: minv,
            max: maxv,
            step: 1,
            slide: function (event, ui) {
                $(id).val(ui.value);
            }
        });
        $(id).focusout(function () {
            $(this).prev().slider('value', $(id).val());
        });
    }

    function perContentType(item) {
        var custom_checkbox = $('#edit-' + item + '-enable');
        var div = $('#div-' + item + '-collapse');

        custom_checkbox.change(
            function () {
                if (custom_checkbox.attr('checked')) {
                    div.slideDown();
                }
                else if (div.css('display') != 'none') {
                    div.slideUp();
                }
            }
        );
        if (!custom_checkbox.attr('checked')) {
            div.hide();
        }
    }

    function shareEnable() {
        var custom_checkbox = $('.node-share-checkbox');
        custom_checkbox.change(
            function () {
                div = $(this).parent().next();
                if ($(this).attr('checked')) {
                    div.slideDown();
                }
                else if (div.css('display') != 'none') {
                    div.slideUp();
                }
            }
        );

        custom_checkbox.each(function () {
            div = $(this).parent().next();
            if (!$(this).attr('checked')) {
                div.hide();
            } else {
                div.show();
            }
        });
    }

    function jqROund(a) {
        return Math.round(a);
    }

    $(window).resize(function () {
        listcontentw = $(".md-wrap").width() - 300;
        $(".md-listcontent").width(listcontentw);
    });

});

