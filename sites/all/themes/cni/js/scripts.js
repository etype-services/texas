(function ($) {

    Drupal.behaviors.bonesSuperfish = {

        attach: function (context, settings) {

            $('#user-menu ul.menu', context).superfish({
                delay: 400,
                animation: {height: 'show'},
                speed: 500,
                easing: 'easeOutBounce',
                autoArrows: false,
                dropShadows: false /* Needed for IE */
            });

        }
    }

    $(function () {

        $('.postscript-wrapper img').hover(function () {
            $(this).animate({
                backgroundColor: "#ff7800", opacity: "1.0"
            }, 'fast');
        }, function () {
            $(this).animate({
                backgroundColor: "#555", opacity: "0.9"
            }, 'normal');
        });

    });


})(jQuery);

(function ($) {
    Drupal.behaviors.superfish = {
        attach: function (context) {
            var obj = $('#block-superfish-1 ul li.sf-depth-1:first-child a');
            obj.click(function (e) {
                var text = $(this).text();
                e.preventDefault();
                $('#block-superfish-1 ul li.sf-depth-1:not(:first-child)').toggle();
                if (text == 'Show Menu') {
                    $(this).text('Hide Menu');
                } else {
                    $(this).text('Show Menu');
                }
            });

            $(window).resize(function () {
                var w = $(window).width();
                if (w > 767) {
                    $('#block-superfish-1 ul li.sf-depth-1:not(:first-child)').css("display", "list-item").show();
                } else {
                    $('#block-superfish-1 ul li.sf-depth-1:first-child a').text('Show Menu');
                    $('#block-superfish-1 ul li.sf-depth-1:not(:first-child)').hide();
                    $('#block-superfish-1 ul li.sf-depth-1 ul').hide();
                }
            });
        }
    };
})(jQuery);
