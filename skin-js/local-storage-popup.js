/**
 * Local Storage Popup
 * 
 * Poping up after three page views and sets an entry in the user's local storage
 * for 24 hours.
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {
    'use strict';
    
    // make sure storage and cookies are available
    if(typeof (Storage) !== "undefined" && navigator.cookieEnabled) {

        var $body = $('body'),
            $window = $(window),
            $popup = $('#popup'),
            windowWidth = $window.innerWidth(),
            windowHeight = $window.innerHeight(),
            popupWidth = $popup.outerWidth(),
            popupHeight = $popup.outerHeight(),
            posX = (windowWidth / 2) - (popupWidth / 2),
            posY = (windowHeight / 2) - (popupHeight / 2);

        try {
            // add key pageViews and count each page load, after three pages visited -> show popup
            if (((localStorage.pageViews = (+ localStorage.pageViews || 0) + 1) === 3) && $body.innerWidth() > 767) {

                // set a time to live from current time stamp (+24h)
                localStorage.setItem("ttl", (new Date().getTime() + 86400000));

                // show popup
                $('<div id="popup-overlay" class="overlay"></div>')
                    .hide()
                    .appendTo($body)
                    .fadeIn('fast');

                $popup
                    .css({
                        left: posX,
                        top: posY
                    })
                    .appendTo($body)
                    .stop()
                    .fadeIn('fast');

                // once the popup is done we should time out the local storage to show popup again after 24 hours
            } else if (localStorage.ttl < new Date().getTime()) {
                // clear the storage
                localStorage.clear();
            }

            // handle exception
        } catch (e) {
            return false;
        }

        // Close the newsletter overlay if click on the close button
        $body.on('click', '#popup-close, .overlay', function () {

            $('.overlay').fadeOut(300, function () {
                $(this).remove();
            });

            $popup.fadeOut(300, function () {
                $(this).remove();
            });

        });
    }

})(window.jQuery);