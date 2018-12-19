let notif;
// Chart.js Global Font
if(typeof Chart !== 'undefined'){
    Chart.defaults.global.defaultFontFamily = "Vazir";
}

jQuery(function ($) {
	notif = new Notification();
	// activates bootstrap sliders
    $('[data-ui-slider]').bootstrapSlider();



	/*
	 * Fixing the bootstrap bug for dropdown menus inside a responsive table
	 * */
	$(window).on('resize', fixDropdownInTable);

    fixDropdownInTable();

	function fixDropdownInTable() {
        let windowWidth = $(window).outerWidth(true);

        if ($('.table-type').length) {
            if (windowWidth < 1024) {

                $('.table-type').removeClass('table-static').addClass('table-responsive');
                let table  = $('.table-responsive');
                let tableB = table.offset().top + table.outerHeight();

                $('.table-responsive .dropdown').on('shown.bs.dropdown', function () {
                    let that      = $(this);
                    let menu      = that.find('.dropdown-menu');
                    let dropdownB = menu.offset().top + menu.outerHeight();
                    if (dropdownB >= tableB) {
                        menu.css('position', 'static');
                    }
                }).on('hidden.bs.dropdown', function () {
                    $(this).find('.dropdown-menu').css('position', 'absolute');
                });

            }
            else {
                $('.table-type').removeClass('table-responsive').addClass('table-static');
                let docHeight     = $(document).outerHeight(true);
                let contentHeight = $('.content-wrapper').outerHeight();

                $('.table-static .dropdown').on('shown.bs.dropdown', function () {
                    let that      = $(this);
                    let menu      = that.find('.dropdown-menu').removeAttr('style');
                    let dropdownB = menu.offset().top + menu.outerHeight();
                    if (dropdownB >= docHeight) {
                        $('.content-wrapper').outerHeight(contentHeight + dropdownB - docHeight + 20);
                    }
                }).on('hidden.bs.dropdown', function () {
                    $('.content-wrapper').outerHeight(contentHeight);
                });
            }
        }
    }



	/*
	 * Notification Bar
	 * use "notif.show(text,class)"
	 * both parameters should be passed as string.
	 * class accepts these values ['warning','info' ,'danger', 'success']
	 *
	 * */
	$('.notification-close').on('click', function () {
		notif.hide();
	});



	/*
	 * Prevent some buttons and links from their defaults
	 * */
	$('.nav-wrapper a.prevented').on('click', function (e) {
		e.preventDefault();
	});



	/*
	 * Show Active theme
	 * */
	$('.theme-label').click(function () {
		$('.checked').removeClass('checked');
		$(this).addClass('checked');
	});



	/*
	* Notifications panel
	* */
	$('.notifications-pane').on('click', '.notification-item', function (e) {
        e.preventDefault();
        let item = $(this);
        let link = item.attr('href');
        let id = item.data('id');
        let calling_url = 'manage/notifications/{id}/mark'.replace('{id}', id);

        if (!item.hasClass('read')) {
            $.ajax({
                type   : 'GET',
                url    : url(calling_url),
                success: function (response) {
                    $('.notification-item[data-id=' + id + ']').addClass('read');
                    reloadNotificationIcon();
                }
            });
        }
        window.open(link, '_blank');
    })
        .on('click', '.js_markAll', function () {

            $.ajax({
                type: 'GET',
                url: url('manage/notifications/markall'),
                success: function (response) {
                    $('.notifications-pane .notification-item').addClass('read');
                    reloadNotificationIcon();
                }
            });
        });

        $(document).on({
            click: function(event) {
                console.log("clicked");
                event.preventDefault();
                $('[data-toggle-state=offsidebar-open]').first().trigger('click');
                if ($('body').hasClass('offsidebar-open')) {
                    $('a[aria-controls="app-notifications"]').trigger('click');
                }
            }
        }, 'ul.navbar-nav li.notification a')

        function reloadNotificationIcon() {
            $.ajax({
                type: 'GET',
                url: url('manage/notifications/reload'),
                success: function (response) {
                    $('ul.navbar-nav').children('li.notificaion').html(response);
                }
            });
        }

        setInterval(reloadNotificationIcon, 30000);

}); //End Of siaf!



/*
 * Notification Bar Object
 * */
function Notification(element = $('#page-notification')) {
	let thisNotif            = this;
	thisNotif.availableTypes = ['warning', 'info', 'danger', 'success'];

	thisNotif.reset = function () {
		thisNotif.element   = element;
		thisNotif.alertType = 'warning';
		thisNotif.text      = '';
		thisNotif.element.removeClass('alert-' + thisNotif.type);
	};
	thisNotif.show  = function (text = thisNotif.text, type = thisNotif.alertType) {
		thisNotif.text = text;
		thisNotif.element.find('.notification-text').text(text);
		if ($.inArray(type, this.availableTypes) > -1) {
			thisNotif.type = type;
			thisNotif.element.addClass('alert-' + type);
		}
		thisNotif.element.css('top', 0);

		setTimeout(thisNotif.hide, 5000);
	};
	thisNotif.hide  = function () {
		thisNotif.element.css("top", "-100%");
		thisNotif.reset();
	};
	thisNotif.reset();
}
function notify(text, type) {
	notif.show(text, type)
}




/*
 * Caching Color Theme
 *
 * */
function saveTheme(name) {
	$.ajax({
		url  : url('manage/account/save/theme/' + name),
		cache: false
	}).done(function (html) {
		if (html == '1') {
			$('#btnThemeSaved').click();
		}
		else {
			$('#btnThemeNotSaved').click();
		}
	});
}



/*
* Clock Widget
* */
function showClock()
{
    // DEFINE CANVAS AND ITS CONTEXT.
    var canvas = document.getElementById('analogClock');
    var ctx = canvas.getContext('2d');
    var date = new Date;
    var angle;
    var secHandLength = 60;
    // CLEAR EVERYTHING ON THE CANVAS. RE-DRAW NEW ELEMENTS EVERY SECOND.
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    OUTER_DIAL1();
    OUTER_DIAL2();
    CENTER_DIAL();
    MARK_THE_HOURS();
    MARK_THE_SECONDS();
    SHOW_SECONDS();
    SHOW_MINUTES();
    SHOW_HOURS();
    function OUTER_DIAL1()
    {
        ctx.beginPath();
        ctx.arc(canvas.width / 2, canvas.height / 2, secHandLength + 10, 0, Math.PI * 2);
        ctx.strokeStyle = '#92949C';
        ctx.stroke();
    }

    function OUTER_DIAL2()
    {
        ctx.beginPath();
        ctx.arc(canvas.width / 2, canvas.height / 2, secHandLength + 7, 0, Math.PI * 2);
        ctx.strokeStyle = '#929BAC';
        ctx.stroke();
    }

    function CENTER_DIAL()
    {
        ctx.beginPath();
        ctx.arc(canvas.width / 2, canvas.height / 2, 2, 0, Math.PI * 2);
        ctx.lineWidth = 3;
        ctx.fillStyle = '#353535';
        ctx.strokeStyle = '#0C3D4A';
        ctx.stroke();
    }
    function MARK_THE_HOURS()
    {
        for (var i = 0; i < 12; i++)
        {

            angle = (i - 3) * (Math.PI * 2) / 12;       // THE ANGLE TO MARK.
            ctx.lineWidth = 1;            // HAND WIDTH.
            ctx.beginPath();
            var x1 = (canvas.width / 2) + Math.cos(angle) * (secHandLength);
            var y1 = (canvas.height / 2) + Math.sin(angle) * (secHandLength);
            var x2 = (canvas.width / 2) + Math.cos(angle) * (secHandLength - (secHandLength / 7));
            var y2 = (canvas.height / 2) + Math.sin(angle) * (secHandLength - (secHandLength / 7));
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.strokeStyle = '#466B76';
            ctx.stroke();

        }

    }
    function MARK_THE_SECONDS()
    {
        for (var i = 0; i < 60; i++) {
            angle = (i - 3) * (Math.PI * 2) / 60;       // THE ANGLE TO MARK.
            ctx.lineWidth = 1;            // HAND WIDTH.
            ctx.beginPath();
            var x1 = (canvas.width / 2) + Math.cos(angle) * (secHandLength);
            var y1 = (canvas.height / 2) + Math.sin(angle) * (secHandLength);
            var x2 = (canvas.width / 2) + Math.cos(angle) * (secHandLength - (secHandLength / 30));
            var y2 = (canvas.height / 2) + Math.sin(angle) * (secHandLength - (secHandLength / 30));
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.strokeStyle = '#C4D1D5';
            ctx.stroke();
        }
    }
    function SHOW_SECONDS()
    {
        var sec = date.getSeconds();
        angle = ((Math.PI * 2) * (sec / 60)) - ((Math.PI * 2) / 4);
        ctx.lineWidth = 0.5;              // HAND WIDTH.
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);                    // START FROM CENTER OF THE CLOCK.
        ctx.lineTo((canvas.width / 2 + Math.cos(angle) * secHandLength),    // DRAW THE LENGTH.
            canvas.height / 2 + Math.sin(angle) * secHandLength);
        // DRAW THE TAIL OF THE SECONDS HAND.
        ctx.moveTo(canvas.width / 2, canvas.height / 2);       // START FROM CENTER OF THE CLOCK.
        ctx.lineTo((canvas.width / 2 - Math.cos(angle) * 20),      // DRAW THE LENGTH.
            canvas.height / 2 - Math.sin(angle) * 20);
        ctx.strokeStyle = '#586A73';        // COLOR OF THE HAND.
        ctx.stroke();

    }
    function SHOW_MINUTES()
    {
        var min = date.getMinutes();
        angle = ((Math.PI * 2) * (min / 60)) - ((Math.PI * 2) / 4);
        ctx.lineWidth = 1.5;              // HAND WIDTH.
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);       // START FROM CENTER OF THE CLOCK.
        ctx.lineTo((canvas.width / 2 + Math.cos(angle) * secHandLength / 1.1),      // DRAW THE LENGTH.
            canvas.height / 2 + Math.sin(angle) * secHandLength / 1.1);
        ctx.strokeStyle = '#999';  // COLOR OF THE HAND.
        ctx.stroke();
    }
    function SHOW_HOURS()
    {
        var hour = date.getHours();
        var min = date.getMinutes();
        angle = ((Math.PI * 2) * ((hour * 5 + (min / 60) * 5) / 60)) - ((Math.PI * 2) / 4);
        ctx.lineWidth = 1.5;              // HAND WIDTH.
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);     // START FROM CENTER OF THE CLOCK.
        ctx.lineTo((canvas.width / 2 + Math.cos(angle) * secHandLength / 1.5),      // DRAW THE LENGTH.
            canvas.height / 2 + Math.sin(angle) * secHandLength / 1.5);
        ctx.strokeStyle = '#000';   // COLOR OF THE HAND.
        ctx.stroke();
    }

}



/**
 * Converts all color codes to RGB
 *
 * @param colorCode
 * @return {string}
 */
function colorCodeToRGB(colorCode){
    var c;
    var rgbaValidation = (/([R][G][B][A]?[(]\s*([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\s*,\s*([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\s*,\s*([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])(\s*,\s*((0\.[0-9]{1})|(1\.0)|(1)))?[)])/i.test(colorCode)) ;

    var hexValidation = (/^#([A-Fa-f0-9]{3}){1,2}$/.test(colorCode));

    if(hexValidation){
        c= colorCode.substring(1).split('');
        if(c.length === 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgb('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+')';

    }else if(rgbaValidation){

        return colorCode;
    }
    return colorCode;
}



/**
 * detects text color according to background color
 *
 * @param bgColor
 * @return {string}
 */
function autoTextColor(bgColor){

    var rgbString = colorCodeToRGB(bgColor);

    var matchColors = /rgb\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\)/;
    var rgb = matchColors.exec(rgbString);

    if (rgb === null) {
        return;
    }

    var o = Math.round(((parseInt(rgb[1]) * 299) +
        (parseInt(rgb[2]) * 587) +
        (parseInt(rgb[3]) * 114)) / 1000);

    return (o > 125) ? '#000' : '#fff';
}



/*
*  Pie Chart responsive
* */
function resizePieChart(chart) {
    if(chart.options.legend.display){
        let chartWidth = chart.chart.width;
        if(chartWidth < 768){
            chart.options.legend.position = "bottom";
        }else{
            chart.options.legend.position = "right";
        }
        chart.update();
    }
}

/*
*-------------------------------------------------------
* Vue-color Setup
*-------------------------------------------------------
*/

var Chrome = VueColor.Chrome;
Vue.component('colorpicker', {
    components: {
        'chrome-picker': Chrome,
    },
    template: `
<div class="input-group color-picker" ref="colorpicker">
	<input type="text" :name="name" :title="title" class="form-control" v-model="colorValue" @focus="showPicker()" @input="updateFromInput" />
	<span class="input-group-addon color-picker-container">
		<span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
		<chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker" />
	</span>
</div>`,
    props: ['color', 'name','title'],
    data() {
        return {
            colors: {
                hex: '#000000',
            },
            colorValue: '',
            displayPicker: false,
        }
    },
    mounted() {
        this.setColor(this.color || '#000000');
    },
    methods: {
        setColor(color) {
            this.updateColors(color);
            this.colorValue = color;
        },
        updateColors(color) {
            if(color.slice(0, 1) == '#') {
                this.colors = {
                    hex: color
                };
            }
            else if(color.slice(0, 4) == 'rgba') {
                var rgba = color.replace(/^rgba?\(|\s+|\)$/g,'').split(','),
                    hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
                this.colors = {
                    hex: hex,
                    a: rgba[3],
                }
            }
        },
        showPicker() {
            document.addEventListener('click', this.documentClick);
            this.displayPicker = true;
        },
        hidePicker() {
            document.removeEventListener('click', this.documentClick);
            this.displayPicker = false;
        },
        togglePicker() {
            this.displayPicker ? this.hidePicker() : this.showPicker();
        },
        updateFromInput() {
            this.updateColors(this.colorValue);
        },
        updateFromPicker(color) {
            this.colors = color;
            if(color.rgba.a == 1) {
                this.colorValue = color.hex;
            }
            else {
                this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
            }
        },
        documentClick(e) {
            var el = this.$refs.colorpicker,
                target = e.target;
            if(el !== target && !el.contains(target)) {
                this.hidePicker()
            }
        }
    },
    watch: {
        colorValue(val) {
            if(val) {
                this.updateColors(val);
                this.$emit('input', val);
            }
        }
    },
});

/*
*-------------------------------------------------------
* Vue pDatePicker Component
*-------------------------------------------------------
*/

// Init perisan date picker instance
function initPersianDatePicker(id){
    $(document).ready(function () {
        new Vue({
            el: '#'+id,
        });
    })
}

Vue.component('pdatepicker' , {
    props:{
        name: String,
        valueFrom: String,
        valueTo: String,
        placeholderFrom: String,
        placeholderTo: String,
        inputClass: String,
        pdateStyle: String,
        onkeyup: String,
        onblur: String,
        onfocus: String,
        pdateMax: Number,
        pdateMin: Number,
        id: {
            type: String,
            required: true
        },
        initialValue: {
            type: String,
            default: 'gregorian'
        },
        calendarType:{
            type: String,
            default: 'persian'
        },
        format:{
            type: String,
            default: 'LLLL'
        },
        onlyTimePicker:{
            type: Boolean,
            default: false
        },
        calendarSwitch:{
            type: Boolean,
            default: true
        },
        scroll:{
            type: Boolean,
            default: false
        },
        timePicker:{
            type: Boolean,
            default: false
        },
        range: {
            type: Boolean,
            default: false
        }

    },
    template: `<span v-bind:class="{'twin': range}">
                        <input type="text" :id="viewId" :class="inputClass" :name="'_' + name" :style="pdateStyle"
                        :onkeyup="onkeyup" :onblur="onblur" :onfocus="onfocus" :placeholder="placeholderFrom" autocomplete="off"/>
                        <input :id="altId" type="text" :name="name" :class="altClass" autocomplete="off"/>
                        <template v-if="range">
                            <input type="text" :id="'to_' + viewId"  :class="inputClass" :value="valueTo" :name="'_to_' + name" :style="pdateStyle"
                            :onkeyup="onkeyup" :onblur="onblur" :onfocus="onfocus" :placeholder="placeholderTo" autocomplete="off"/>
                            <input :id="'to_' + altId" :name="'to_' + name" type="text" :class="'to_' + altClass" autocomplete="off"/>
                        </template>
                </span>`,
    data: function () {
        return {
            altId: this.id + '-alt',
            altClass: this.id + '-alt noDisplay',
            viewId: this.id + '-view',
        }
    },
    mounted: function () {
        var vm = this;

        if(!vm.range){
            this.removeAltValue(vm.viewId, vm.altId);
            this.addValueAttr(vm.viewId, vm.valueFrom);

            $("#"+ vm.viewId).pDatepicker({
                initialValue: !!(vm.valueFrom && vm.valueFrom.length),
                initialValueType: vm.initialValue,
                calendarType: vm.calendarType,
                onlyTimePicker: vm.onlyTimePicker,
                observer: true,
                format: vm.format,
                altField: '#'+ vm.altId ,
                calendar:{
                    persian: {
                        leapYearMode: 'astronomical',
                        locale: 'fa',
                    },
                    gregorian: {
                        locale: "en",
                    }
                },
                toolbox:{
                    calendarSwitch:{
                        enabled: vm.calendarSwitch
                    }
                },
                navigator:{
                    scroll:{
                        enabled: vm.scroll
                    }
                },
                maxDate: vm.pdateMax,
                minDate: vm.pdateMin,
                timePicker: {
                    enabled: vm.timePicker,
                    meridiem: {
                        enabled: true
                    }
                }
            });
        }else{
            var to, from;

            this.addValueAttr(vm.viewId, vm.valueFrom);
            this.removeAltValue(vm.viewId, vm.altId);

            this.addValueAttr("to_" + vm.viewId, vm.valueTo);
            this.removeAltValue("to_" + vm.viewId, "to_" + vm.altId);


            to = $("#to_" + vm.viewId).persianDatepicker({
                initialValue: !!(vm.valueTo && vm.valueTo.length),
                initialValueType: vm.initialValue,
                calendarType: vm.calendarType,
                format: vm.format,
                altField: "#to_" + vm.altId,
                navigator:{
                    scroll:{
                        enabled: vm.scroll
                    }
                },
                timePicker: {
                    enabled: vm.timePicker,
                    meridiem: {
                        enabled: true
                    }
                },
                onSelect: function (unix) {
                    to.touched = true;
                    if (from && from.options && from.options.maxDate != unix) {
                        var cachedValue = from.getState().selected.unixDate;
                        from.options = {maxDate: unix};
                        if (from.touched) {
                            from.setDate(cachedValue);
                        }
                    }
                }
            });
            from = $("#" + vm.viewId).persianDatepicker({
                initialValue: !!(vm.valueFrom && vm.valueFrom.length),
                initialValueType: vm.initialValue,
                calendarType: vm.calendarType,
                format: vm.format,
                altField: '#'+ vm.altId,
                navigator:{
                    scroll:{
                        enabled: vm.scroll
                    }
                },
                timePicker: {
                    enabled: vm.timePicker,
                    meridiem: {
                        enabled: true
                    }
                },
                onSelect: function (unix) {
                    from.touched = true;
                    if (to && to.options && to.options.minDate != unix) {
                        var cachedValue = to.getState().selected.unixDate;
                        to.options = {minDate: unix};
                        if (to.touched) {
                            to.setDate(cachedValue);
                        }
                    }
                }
            });
        }

    },

    methods: {
        removeAltValue: function (sourceId, targetId) {

            $(document).on('change', "#"+ sourceId, function () {
                let value = $(this).val();
                if(!value.length){
                    $("#" + targetId).val('');
                }
            });

        },

        addValueAttr: function (id, value) {
            $("#" + id).attr('value', value);
        }
    }
});
