/**
 * Responsive Images
 *
 * Allows to use special images for different device widths
 *
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {
    'use strict';

    // responsive slider images
    function responsiveImages() {

        var s = 320, // images for devices with max 320px in width
            m = 321, // images for devices from 321px in width
            l = 1025,// images for devices above 1025px in width
            wWidth = $(window).width(),
            dataImage;

        // use image data source in dependence of window width
        switch (true) {
            case (wWidth <= s):
                dataImage = 'data-s';
                break;
            case (wWidth >= m && wWidth < l):
                dataImage = 'data-m';
                break;
            case (wWidth >= l):
                dataImage = 'data-l';
                break;
            default:
                dataImage = 'src';
        }

        // switch image source
        $($('#image-container img')).each( function () {

            var swapImage = $(this).attr(dataImage);

            $(this).attr('src', swapImage);
        });

    }
    $(window).on('load resize', function () {
        responsiveImages();
    });

})(jQuery);