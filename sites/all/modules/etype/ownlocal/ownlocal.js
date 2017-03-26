function ownlocal_insert_business_list(returned_businesses) {
    (function ($) {
        list = $("#ownlocal-business-list ul");
        list.empty();
        $(returned_businesses).each(function (index, biz) {
            var new_item = $("#ownlocal-business-list-template li").clone();
            var info = new_item.find('.ownlocal-business-popup-info');
            var info_html = '';
            var website;

            new_item.find('.ownlocal-business-link').attr('href', biz.link).text(biz.name);
            list.append(new_item);
            info.find('h4 a').attr('href', biz.link).text(biz.name);

            if (biz.address) {
                info_html += "<div class='biz-address'>" + biz.address + "<br/>";
            }
            if (biz.address2) {
                info_html += biz.address2 + "<br/>";
            }
            info_html += biz.city + ", " + biz.state + "</div>";

            if (biz.website) {
                website = biz.website.replace('http://', '');
                info_html += " <div><a class='customer-site' target='_blank' href='http://" + website + "'>WEBSITE</a></div>";
            }

            info.find('p').html(info_html);

            attach_link(biz, info);
            new_item.hover(get_image);
        });
    }(jQuery));
}

function attach_link(biz, element) {
    (function ($) {
        var link = $('<a class="image-link" target="_blank">');
        var image_url, link_href;
        if (biz.ad_full_image) {
            link_href = biz.ad_url;
            image_url = biz.ad_full_image;
        }
        else {
            link_href = biz.link;
            image_url = biz.image;
        }

        link.attr('href', link_href);
        link.data('ad-image', image_url);
        element.append(link);
    }(jQuery));
}

function get_image(e) {
    var link = $(this).find('div a.image-link');
    var image_url = link.data("ad-image");

    if (image_url) {
        link.html('<img src="' + image_url + '">');
    }
}

//On document load...
(function ($) {
    // Make the search field text disappear when clicked:
    var search_field = $('#ownlocal-custom-search-field');

    search_field.data('default_text', search_field.val());
    search_field.focus(function () {
        if ($(this).data('default_text') == $(this).val())
            $(this).val('');
    })
    search_field.blur(function () {
        if ('' == $(this).val())
            $(this).val($(this).data('default_text'));
    })

    // Activate the Dropdown
    $('#ownlocal-dropdown').click('.dropdown-button a', function () {
        $('#ownlocal-dropdown .dropdown-container').toggleClass('active');
    });
    $('#ownlocal-dropdown').mouseleave('.dropdown-container', function () {
        $(this).removeClass('active');
    });
    $('#ownlocal-dropdown').click('li', function () {
        $('#ownlocal-dropdown .dropdown-container').addClass('active');
    });
})(jQuery);
