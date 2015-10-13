/**
 * Mobile Dropdown Menu
 *
 * Creates a native select box from list elements on a mobile device
 *
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {
    'use strict';

    'use strict';

    // Global variables
    var $window = $(window);

    // Sidebar navigation select for mobile, list for desktop
    function initSelectNav() {

        if ($window.width() < 768) {
            var $nav = $('#cat-nav');

            $nav.each( function () {

                var $select = $(document.createElement('select')).insertBefore($(this));

                $('> li a', this).each( function () {
                    var option =
                        $(document.createElement('option'))
                            .appendTo($select)
                            .val(this.href)
                            .html($(this).html());
                });

                $select
                    .wrap('<label class="cat-nav dropdown"></label>')
                    .on('change', function () {
                        window.location = this.value;
                    });

                $select
                    .find('option[value="' + window.location + '"]')
                    .prop('selected', true);

                $(this).remove();
            });

        } else {

            var $dropDown = $('.cat-nav.dropdown');

            $dropDown.each( function () {
                var $list = $(document.createElement('ul'));

                $list.attr('id', 'cat-nav').insertBefore($(this));

                $('option').each( function () {
                    var href = $(this).val();

                    $(document.createElement('li'))
                        .appendTo($list)
                        .html('<span><a href="' + href + '">' + $(this).html() + '</a></span>');
                });

                $(this).remove();
            });
        }
    }

    // init function also for window resizing
    $window.on('load resize', function () {
        initSelectNav();
    });


})(jQuery);