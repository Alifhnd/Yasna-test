/**
 * Settings Search
 * -------------------------
 * Created by Negar Jamalifard
 * n.jamalifard@gmail.com
 * On 2018-08-14
 */


$(document).ready(function () {
    $(".search-setting-js").keyup(function () {

        let filter = $(this).val().trim().toPersianCharacter();

        $('.js_setting-category').each(function () {

            $('.js_category-tags label a').each(function () {
                let badge = $(this).closest('.badge-custom');
                checkBadges($(this).text(), filter, badge);
            });

            if (!filter.length) {
                $(this).removeClass('hasResult').slideDown();
                return;
            }

            if ($(this).find('.js_category-tags label.active').length) {
                $(this).addClass('hasResult').slideDown();
            } else {
                $(this).removeClass('hasResult').slideUp();
            }
        });

        if(filter.length && !$('.js_setting-category.hasResult').length){
            $('.js_no-result').slideDown();
        }else {
            $('.js_no-result').slideUp();
        }
    });


    /**
     * Checks badges contents
     * and mark active badges
     *
     * @param searchTarget
     * @param badge
     */
    function checkBadges(searchTarget, filter, badge) {
        if (!filter.length) {
            badge.removeClass('active');
            return;
        }
        if (searchTarget.search(new RegExp(filter, "i")) < 0) {
            badge.removeClass('active');
        } else {
            badge.addClass('active');
        }
    }
});

String.prototype.replaceAll = function(search, replacement) {
    let target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

String.prototype.toPersianCharacter =  function () {
    let string = this;
    let obj = {
        'ك' :'ک',
        'دِ': 'د',
        'بِ': 'ب',
        'زِ': 'ز',
        'ذِ': 'ذ',
        'شِ': 'ش',
        'سِ': 'س',
        'ى' :'ی',
        'ي' :'ی',
    };

    Object.keys(obj).forEach(function(key) {
        string = string.replaceAll(key, obj[key]);
    });
    return string
};
