/**
 * Dashboard Widgets
 * -------------------------
 * Created by Negar Jamalifard
 * n.jamalifard@gmail.com
 * On 2018-10-09
 */


$(document).ready(function () {


    /**
     * Resets widgets height on widgets resize
     */
    $(document).on('resizestop','.grid-stack' ,function (event, ui) {
        setWidgetHeight(event.target);
    });



    /**
     * Resets Widgets size on window resize
     */
    $(window).on('resize', function () {
        setAllWidgetsHeight();
    });



    /**
     * Save widgets on resize nad drag
     */
    $(document).on('resizestop dragstop','.grid-stack', function (event, ui) {
        let data = getWidgetGridOrder();
        dashboardWidgetCache(data);
    });



    /**
     * Close widget Repository when
     * sidebar is hidden or collapsed
     */
    $('#lnkSidebarCollapse').on('click',function () {
        if( $('body').hasClass('aside-collapsed')){
            closeDashboardRepository();
        }
    });



    /**
     * Get Widgets Grid Data
     *
     * @return {string}
     */
    function getWidgetGridOrder () {
        let serializedData = _.map($('.grid-stack > .grid-stack-item:visible:not(.grid-stack-placeholder)'), function (el) {
            el = $(el);
            let node = el.data('_gridstack_node');

            return {
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height,
                id: node.id
            };
        });

        return JSON.stringify(serializedData, null, '    ');
    }

});


/**
 * Init Gridstack plugin
 *
 * @param serializedData
 */
function initWidgetGrid(serializedData) {
    $('.grid-stack').gridstack({
        width                 : 6,
        cellHeight            : 5,
        minHeight             : 100,
        handle                : '.panel-heading',
        alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
        resizable             : {
            handles: 'w, e'
        },
    });


    if(serializedData){
        GridStackUI.Utils.sort(serializedData)
    }
}



/**
 * Set all widgets Height
 */
function setAllWidgetsHeight() {
    let gridStack = $('.grid-stack');
    gridStack.find('.grid-stack-item').each(function () {
        setWidgetHeight(this);
    })
}



/**
 * Sets widgets Height
 *
 * @param element
 */
function setWidgetHeight(element) {

    let gridStack = $('.grid-stack');

    var cellHeight = 5;
    var margin     = 20;

    var grid  = gridStack.data('gridstack');
    var width = $(element).attr('data-gs-width');

    if ($(element).find('.inner-content').length) {

        var contentHeight = $(element).find('.inner-content').outerHeight();

        var rows = Math.floor(contentHeight / (cellHeight + margin) - 1);

        var height = rows + 3;

        grid.resize(element, width, height);
    }

}



/**
 * Sets widgets height with delay
 *
 * @param element
 */
function setWidgetHeightWithDelay(element) {
    setTimeout(function () {
        setWidgetHeight(element);
    }, 800)
}



/**
 * Caching Dashboard Widget (panels order)
 * Gets panels order
 *
 * @param order {string}
 */
function dashboardWidgetCache(order) {
    $.ajax({
        url  : url('manage/account/save/widgets/' + order),
        cache: false
    }).done(function (html) {
        if (html == '1') {
            $('#btnWidgetsSaved').click();
        }
        else {
            $('#btnWidgetsNotSaved').click();
        }
    });

}



/**
 * Show Widgets Repository
 */
function openDashboardRepository()
{
    let id = "column-repository" ;
    let $div = $("#column-repository") ;
    let $parent = $div.parent();

    if($('body').hasClass('aside-collapsed')){
        $('body').removeClass('aside-collapsed')
    }

    if($(window).outerWidth() < 768 && !$('body').hasClass('aside-toggled')){
        $('body').addClass('aside-toggled')
    }

    $parent.slideDown('fast');
    if($parent.attr('data-content') == 'no') {
        divReload(id);
        $parent.attr('data-content' , '');
    }
}



/**
 * Closes Widgets Repository
 */
function closeDashboardRepository()
{
    let id = "column-repository" ;
    let $div = $("#column-repository") ;
    let $parent = $div.parent();

    $parent.slideUp('fast');
}



/**
 * Show Combo list
 * @param el
 */
function viewCombolist(el) {
    let $this = $(el),
        comboContainer = $('.combo-container');

    $this.addClass('noDisplay');
    comboContainer.removeClass('noDisplay');

    $('.refresh-widget-button').addClass('noDisplay');
    $('.remove-widget-button').removeClass('noDisplay');
}



/**
 * End Widget Setting
 */
function endWidgetSetting() {

    $('.remove-widget-button').addClass('noDisplay');
    $('.refresh-widget-button').removeClass('noDisplay');

    $(".start-setting-btn").removeClass('noDisplay');
    $('.combo-container').addClass('noDisplay');
}



/**
 * Remove Widget
 *
 * @param el
 */
function RemoveDashboradWidget(el) {
    var $this = $(el),
        widget = $this.parents('.grid-stack-item'),
        widgetId = widget.attr("id");

    $.ajax({
        url: url('manage/account/save/widgets-remove/'+ widgetId),
        cache: false
    }).done(function (response) {
        if(response){
            divReload('widgetSettingContainer');
            $('#btnWidgetsSaved').click();
            widget.slideUp().remove();
        }
    })
}



/**
 * Collapse Dashboard
 * @param item
 */
function dashboardCollapse(item) {
    let id              = item.attr('id');
    let parent_id       = item.parent().attr('id');
    let body_id         = id + '-body';
    let $body           = $("#" + body_id);
    let $panel          = $("#" + id + '-panel');
    let $refresh_button = $("#" + id + "-refresh");
    let original_color  = $panel.attr('data-color');


    if (parent_id == 'column-repository') {
        $body.slideUp('fast');
        $panel.addClass('panel-default').removeClass('panel-' + original_color);
        // $refresh_button.hide();
    }
    else {
        $body.slideDown();
        $panel.removeClass('panel-default').addClass('panel-' + original_color);
        // $refresh_button.show();
        if ($body.attr('data-content') == 'no') {
            divReload(body_id);
            $body.attr('data-content', '')
        }
    }

}

