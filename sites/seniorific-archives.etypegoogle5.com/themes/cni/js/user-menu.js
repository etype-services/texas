(function ($) {
    Drupal.behaviors.usermenu = {
        attach: function (context) {
            $('#block-system-user-menu ul li').each(function(index) {
                if ($(this).text() == 'Log In') {
                    $(this).hide();
                }
            })
        }
    };
})(jQuery);