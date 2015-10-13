/**
 * Mail Disguise
 *
 * Using almost blank email links in CMS or templates and render them in browser afterwards
 *
 *
 * Mothership GmbH
 *
 *
 */

;( function ($) {
    'use strict';

    // Disguise email address
    $( function () {
        $('.shrug').each(function () {

            var e = $(this).attr('rel').replace('mail','@domain.com');

            this.href = 'mailto:' + e;
            $(this).text(e).removeAttr('rel');
        });

    });

})(jQuery);