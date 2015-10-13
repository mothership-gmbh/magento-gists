/**
 * 	mageZoom v1.2 - jQuery plugin for MAGENTO, zoom and popup for product images on details page, touch friendly
 *
 * 	Mothership GmbH
 *	based on a script by Jack Moore - http://www.jacklmoore.com/zoom
 *
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *
 */

;( function ($) {

    var defaults = {
        url: false,
        srcImg: '#image',
        target: false,
        duration: 300,
        overlay: '#ffffff',
        callback: false
    };

    // core zoom function
    $.zoom = function(target, source, img) {

        var targetHeight,
            targetWidth,
            sourceHeight,
            sourceWidth,
            xRatio,
            yRatio,
            offset,
            position = $(target).css('position'),
            $source = $(source);

        target.style.position = /(absolute|fixed)/.test(position) ? position : 'relative';
        target.style.overflow = 'hidden';

        img.style.width = img.style.height = '';

        $(img)
            .attr({
                id: 'zoom-image'
            })
            .css({
                position: 'absolute',
                top: 0,
                left: 0,
                opacity: 0,
                width: img.width,
                height: img.height,
                maxWidth: 'none',
                maxHeight: 'none'
            })
            .appendTo(target);

        return {

            init: function() {
                targetWidth = $(target).outerWidth();
                targetHeight = $(target).outerHeight();

                if (source === target) {
                    sourceWidth = targetWidth;
                    sourceHeight = targetHeight;
                } else {
                    sourceWidth = $source.outerWidth();
                    sourceHeight = $source.outerHeight();
                }

                xRatio = (img.width - targetWidth) / sourceWidth;
                yRatio = (img.height - targetHeight) / sourceHeight;

                offset = $source.offset();
            },
            move: function (e) {
                var left = (e.pageX - offset.left),
                    top = (e.pageY - offset.top);

                top = Math.max(Math.min(top, sourceHeight), 0);
                left = Math.max(Math.min(left, sourceWidth), 0);

                img.style.left = (left * -xRatio) + 'px';
                img.style.top = (top * -yRatio) + 'px';
            }
        };
    };

    // plugin
    $.fn.mageZoom = function (options) {

        return this.each( function () {

            var settings = $.extend({}, defaults, options || {}),
                target = settings.target || this,
                source = this,
                $source = $(source),
                img = document.createElement('img'),
                $img = $(img),
                mousemove = 'mousemove.zoom',
                touched = false,
                $urlElement,
                activeThumbnail = $('.more-views li');

            if (!settings.url) {
                $urlElement = $source.find('img');
                if ($urlElement[0]) {
                    settings.url = $urlElement.attr('data-large');
                }
                if (!settings.url) {
                    return;
                }
            }

            ( function () {
                var position = target.style.position;
                var overflow = target.style.overflow;

                $source.one('zoom.destroy', function () {
                    $source.off(".zoom");
                    target.style.position = position;
                    target.style.overflow = overflow;
                    $img.remove();
                });

            }());

            img.onload = function () {

                var zoom = $.zoom(target, source, img),
                    popupTrigger = $('#product-image'),
                    thumbnail = $('.more-views img');

                function start(e) {
                    zoom.init();
                    zoom.move(e);

                    $img.stop()
                        .fadeTo(settings.duration, 1);
                }

                function stop() {
                    $img.stop()
                        .fadeTo(settings.duration, 0);
                }

                function changeImages() {
                    var changeImgSrc = $(this).attr('data-rel'),
                        largeImgSrc = $(this).attr('data-large'),
                        productImg = $(defaults.srcImg),
                        zoomImg = $('#zoom-image');

                    productImg.attr('src', changeImgSrc);
                    productImg.attr('data-large', largeImgSrc);
                    zoomImg.attr('src', largeImgSrc);

                    activeThumbnail.removeClass('active');
                    $(this).parent().addClass('active');
                }

                function popup() {
                    var popDiv = document.createElement('div'),
                        popImg = document.createElement('img'),
                        closeBtn = document.createElement('i'),
                        bigImgSrc = $(defaults.srcImg).attr('data-large');

                    // remove all popups in cache
                    $('.popup').remove();

                    $(popDiv)
                        .addClass('popup')
                        .css({
                            position: 'fixed',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            opacity: 0,
                            background: defaults.overlay
                        }).appendTo('body').fadeTo(settings.duration, 1);

                    $(popImg)
                        .attr('src', bigImgSrc)
                        .appendTo(popDiv);

                    $(closeBtn)
                        .addClass('icon-x')
                        .appendTo(popDiv);
                }

                // deactivate zoom and popup for mobile phones
                if ($(window).width() >= 768) {

                    zoom.init();

                    // zoom events
                    $source
                        // mouse events
                        .on('mouseenter.zoom', start)
                        .on('mouseleave.zoom', stop)
                        .on(mousemove, zoom.move)
                        // touch events
                        .on('touchstart.zoom', function (e) {
                            e.preventDefault();
                            if (touched) {
                                touched = false;
                                stop();
                            } else {
                                touched = true;
                                start( e.originalEvent.touches[0] || e.originalEvent.changedTouches[0] );
                            }
                        })
                        .on('touchmove.zoom', function (e) {
                            e.preventDefault();
                            zoom.move( e.originalEvent.touches[0] || e.originalEvent.changedTouches[0] );
                        });

                    // possible callback
                    if ($.isFunction(settings.callback)) {
                        settings.callback.call(img);
                    }

                    // popup
                    $('body').on('click', '.popup', function () {
                        $(this).fadeOut('fast', function () {
                            $(this).remove();
                        });
                    });

                    popupTrigger.on('click', popup);
                }

                // change image on click on thumbnail
                thumbnail.on('click', changeImages);

            };

            activeThumbnail.first().addClass('active');
            img.src = settings.url;

        });

    };

})(jQuery);
