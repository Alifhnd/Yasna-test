$(document).ready(function () {
    function callAjax(url, data) {
        data._token = getToken();

        $.ajax({
            url     : url,
            type    : 'POST',
            data    : data,
            dataType: 'JSON',
            success : function (rs) {
                eval(rs.callback);
            }
        })
    }


    function getToken() {
        return $('meta[name=csrf_token]').attr('content');
    }

    $(document).on({
        click: function () {
            let that       = $(this);
            let url        = that.data('url');
            let user       = that.data('user');
            let department = that.data('department');
            let data       = {
                user: user,
                id  : department,
            };

            that.closest('.modal-body').addClass('loading');

            callAjax(url, data);
        }
    }, '.btn-add-member');

    $(document).on({
        click: function () {
            let that       = $(this);
            let modal_body = that.closest('.modal-body');
            let url        = that.data('url');
            let user       = that.data('user');
            let department = that.data('department');
            let data       = {
                user: user,
                id  : department,
            };

            modal_body.addClass('loading');

            callAjax(url, data);
        }
    }, '.btn-remove-member');

    $(document).on({
        click: function () {
            $('.add-member-panel').slideToggle()
        }
    }, '.add-member-panel-opener');
})
;
