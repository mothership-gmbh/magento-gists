/**
 * Truncate
 *
 * Set a max text length and show a read more button
 *
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {

    'use strict';

    $.fn.truncate = function(options) {

        var defaults = {
            length: 300,
            minTrail: 20,
            moreText: 'more',
            lessText: 'less',
            ellipsisText: '...',
            moreAni: '',
            lessAni: ''
        };

        return this.each( function () {

            var settings = $.extend(defaults, options),
                obj      = $(this),
                body     = obj.html();

            if(body.length > settings.length + settings.minTrail) {

                var splitLocation = body.indexOf(' ', settings.length);

                if(splitLocation !== -1) {

                    // truncate tip
                    var str1 = body.substring(0, splitLocation),
                        str2 = body.substring(splitLocation, body.length - 1);

                    obj.html(str1 + '<span class="truncate-ellipsis">' + settings.ellipsisText +
                    '</span>' + '<span class="truncate-more">' + str2 + '</span>');
                    obj.find('.truncate-more').css('display', 'none');

                    // insert more link
                    obj.append(
                        '<div class="clearfix">' +
                        '<a href="javascript:void(0);" class="truncate-more-link">' + settings.moreText + '</a>' +
                        '</div>'
                    );

                    // set onclick event for more/less link
                    var moreLink    = $('.truncate-more-link', obj),
                        moreContent = $('.truncate-more', obj),
                        ellipsis    = $('.truncate-ellipsis', obj);

                    moreLink.on('click', function (e) {
                        e.preventDefault();

                        $(this).toggleClass('active');

                        if($(this).hasClass('active')) {

                            moreContent.fadeIn(settings.moreAni);
                            moreLink.html(settings.lessText);
                            ellipsis.css('display', 'none');

                        } else {

                            moreContent.fadeOut(settings.lessAni);
                            moreLink.html(settings.moreText);
                            ellipsis.css('display', 'inline');

                        }
                    });
                }
            }

        });
    };
})(jQuery);