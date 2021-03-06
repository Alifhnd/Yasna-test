/**
 * Tickets Js File
 * -------------------------
 * Created by Negar Jamalifard
 * n.jamalifard@gmail.com
 * On 2018-08-04
 */

$.fn.scrollToView = function (extra, duration) {
    var item = $(this);

    if (!$.isNumeric(duration)) {
        duration = 1000;
    }

    if (!$.isNumeric(extra)) {
        extra = 0;
    }

    $('html, body').animate({
        scrollTop: item.offset().top + extra
    }, duration);
};

let timers = {
    ticketTypeChange: new Timer(),
    flagChange      : new Timer(),
    markAsNew       : new Timer(),
    reopen          : new Timer(),
    close           : new Timer(),
};

jQuery(function ($) {

    $(document).on({
        click: function (event) {
            event.preventDefault();
            let that   = $(this);
            let hashid = that.data('key');

            timers.ticketTypeChange.delay(function () {
                $.ajax({
                    url       : urls.ticketTypeChange,
                    type      : 'post',
                    data      : generateAjaxData({ticket_type: hashid}),
                    dataType  : 'json',
                    beforeSend: function () {
                        makeTimelineLoading();
                    },
                    complete  : function () {
                        makeTimelineReady();
                    },
                    success   : function (rs) {
                        $.notify(rs.message, {status: 'success', pos: 'bottom-left'});
                        setTimeout(function () {
                            eval(rs.callback)
                        }, 1000)
                    }
                })
            }, 0.5);
        }
    }, '.ticket-type-selector')

    $(document).on({
        click: function (event) {
            event.preventDefault();
            let that   = $(this);
            let hashid = that.data('key');

            timers.flagChange.delay(function () {
                $.ajax({
                    url       : urls.flagChange,
                    type      : 'post',
                    data      : generateAjaxData({flag: hashid}),
                    dataType  : 'json',
                    beforeSend: function () {
                        makeTimelineLoading();
                    },
                    complete  : function () {
                        makeTimelineReady();
                    },
                    success   : function (rs) {
                        $.notify(rs.message, {status: 'success', pos: 'bottom-left'});
                        setTimeout(function () {
                            eval(rs.callback)
                        }, 1000)
                    }
                })
            }, 0.5);
        }
    }, '.flag-selector');

    $(document).on({
        click: function (event) {
            timers.markAsNew.delay(function () {
                $.ajax({
                    url       : urls.markAsNew,
                    type      : 'post',
                    data      : generateAjaxData(),
                    dataType  : 'json',
                    beforeSend: function () {
                        makeTimelineLoading();
                    },
                    complete  : function () {
                        makeTimelineReady();
                    },
                    success   : function (rs) {
                        $.notify(rs.message, {status: 'success', pos: 'bottom-left'});
                        setTimeout(function () {
                            eval(rs.callback)
                        }, 1000)
                    }
                })
            }, 0.5);
        }
    }, '#btn-mark-as-new');

    $(document).on({
        click: function (event) {
            timers.reopen.delay(function () {
                $.ajax({
                    url       : urls.reopen,
                    type      : 'post',
                    data      : generateAjaxData(),
                    dataType  : 'json',
                    beforeSend: function () {
                        makeTimelineLoading();
                    },
                    complete  : function () {
                        makeTimelineReady();
                    },
                    success   : function (rs) {
                        $.notify(rs.message, {status: 'success', pos: 'bottom-left'});
                        setTimeout(function () {
                            eval(rs.callback)
                        }, 1000)
                    }
                })
            }, 0.5);
        }
    }, '#btn-reopen');

    $(document).on({
        click: function (event) {
            timers.close.delay(function () {
                $.ajax({
                    url       : urls.close,
                    type      : 'post',
                    data      : generateAjaxData(),
                    dataType  : 'json',
                    beforeSend: function () {
                        makeTimelineLoading();
                    },
                    complete  : function () {
                        makeTimelineReady();
                    },
                    success   : function (rs) {
                        $.notify(rs.message, {status: 'success', pos: 'bottom-left'});
                        setTimeout(function () {
                            eval(rs.callback)
                        }, 1000)
                    }
                })
            }, 0.5);
        }
    }, '#btn-close');


}); //End Of siaf!


function goToCommentBox() {
    $('#timeline_comment_box').scrollToView()
}

function getModelKey() {
    return model_key;
}

function getToken() {
    return $('meta[name=csrf-token]').attr('content');
}

function ajaxNeeds() {
    return {
        _token: getToken(),
        hashid: getModelKey(),
    }
}

function generateAjaxData(data) {
    return $.extend(data, ajaxNeeds());
}

function reloadTimeline() {
    divReload('timeline');
}

function makeTimelineLoading() {
    $('.tickets-timeline').addClass('loading');
}

function makeTimelineReady() {
    $('.tickets-timeline').removeClass('loading');
}


function initReplyEditor() {
    var tickets_tinymce_editor = {
        path_absolute : url(),
        selector      : '.tickets_tinymce_editor',
        menubar       : false,
        content_css   : url() + 'modules/manage/css/tinyMCE.min.css',
        directionality: 'rtl',
        language      : 'fa',
        plugins       : "link,textcolor,image,fullscreen,directionality",
        toolbar       : [
            'bold italic underline strikethrough | link unlink | alignleft aligncenter alignright alignjustify| ltr rtl | fullscreen '
        ],

        relative_urls: false,

        theme_advanced_buttons1: "link,unlink",

    };

    tinymce.init(tickets_tinymce_editor);
}
