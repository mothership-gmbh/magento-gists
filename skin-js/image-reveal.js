/**
 * Image Reveal
 *
 * A very lightweight jQuery plugin to lazy load images
 * It's reduced to the minimal function of showing images.
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {

    $.fn.reveal = function(threshold, callback) {

        var $window = $(window),
            th = threshold || 0,
            retina = window.devicePixelRatio > 1,
            attr = retina? "data-src-retina" : "data-src",
            images = this,
            loaded;

        this.one("reveal", function() {
            var source = this.getAttribute(attr);
            source = source || this.getAttribute("data-src");
            if (source) {
                this.setAttribute("src", source);
                if (typeof callback === "function") callback.call(this);
            }
        });

        function reveal() {
            var isInView = images.filter(function() {
                var $el = $(this);
                if ($el.is(":hidden")) return;

                var wt = $window.scrollTop(),
                    wb = wt + $window.height(),
                    et = $el.offset().top,
                    eb = et + $el.height();

                return eb >= wt - th && et <= wb + th;
            });

            loaded = isInView.trigger("reveal");
            images = images.not(loaded);
        }

        $window.on("scroll.reveal resize.reveal lookup.reveal", reveal);

        reveal();

        return this;

    };

})(window.jQuery);