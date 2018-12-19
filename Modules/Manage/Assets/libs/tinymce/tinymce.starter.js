var editor_config = {
    path_absolute: url(),
    selector: '.tinyEditor',
    menubar: false,
    remove_trailing_brs: false,
    // theme: 'modern',
    content_css: url() + 'modules/manage/css/tinyMCE.min.css',
    directionality: 'rtl',
    language: 'fa',
    theme_advanced_toolbar_align: 'right',
    plugins: "link,table,textcolor,image,directionality,fullscreen,codesample,code,autoresize",
    directionality: "rtl",
//	plugins: [
//		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
//		"searchreplace wordcount visualblocks visualchars code fullscreen",
//		"insertdatetime media nonbreaking save table contextmenu directionality",
//		"emoticons template paste textcolor colorpicker textpattern"
//	],
    toolbar: [
        'insertfile undo redo | bold italic underline strikethrough | copy cut paste removeformat | link unlink inserttable | codesample image fullscreen | code ',
        'alignleft aligncenter alignright alignjustify | bullist numlist | ltr rtl  | forecolor backcolor forecolorpicker backcolorpicker fontsizeselect | table'
//		    , 'outdent indent'
    ],

    relative_urls: false,

    theme_advanced_buttons1: "link,unlink",

    init_instance_callback : function(e) {
        e.theme.resizeTo('100%', 500);
    },

    setup: function (e) {
        e.on('change', function () {
            var function_name = $("#" + this.id).attr('onchange');
            window[function_name]();
        });
        e.on('FullscreenStateChanged', function () {
            console.log(e);
            if( $('.mce-fullscreen').length ){
                e.theme.resizeTo('100%', calculateTinyHeight());
            } else {
                e.theme.resizeTo('100%', 500);
            }
        });
    },

    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

        // var cmsURL = editor_config.path_absolute + 'manage/filemanager?field_name=' + field_name;
        // if (type == 'image') {
        // 	cmsURL = cmsURL + "&type=Images";
        // } else {
        // 	cmsURL = cmsURL + "&type=Files";
        // }
        var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }

};

function calculateTinyHeight() {
    var height = $(window).height() - $('.mce-toolbar-grp').height() - $('.mce-statusbar').height();

    return height;
}

var mini_config = {
    path_absolute: url(),
    selector: '.tinyMini',
    menubar: false,
//                  theme: 'modern',
    content_css: url() + 'modules/manage/css/tinyMCE.min.css',
    directionality: 'rtl',
    language: 'fa',
    plugins: "link,textcolor,image,fullscreen,",
    toolbar: [
        'bold italic underline strikethrough | removeformat | link unlink | alignleft aligncenter alignright alignjustify | fullscreen',
    ],

    relative_urls: false,

    theme_advanced_buttons1: "link,unlink",


    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + '/filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }

};

tinymce.init(editor_config);
tinymce.init(mini_config);