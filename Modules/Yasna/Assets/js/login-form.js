/*
 *----------------------------------------------------------------------
 * Login Page js functions
 * ---------------------------------------------------------------------
 * */

 jQuery(function($){

     var tabs = $('.js-tabs-control'),
         tabsLeft = tabs.offset().left,
         tab = $('.js-tabs-control .login-tabs__tab'),
         input = $('.form-input input'),
         loginForm = $('.login-content form'),
         loginInputs = loginForm.find('.form-input input');

    //onload functions
     moveUnderline();
     changeForm();
     makeInputGreen(input);


    //changes content according to the selected tab
     tab.on('click',function (e) {
         e.preventDefault();
         var $this = $(this),
             href = $this.children('a').attr('href');

         $('.js-tabs-control .active').removeClass('active');
         $this.addClass('active');

         moveUnderline();
         changeForm();
     });


     // Toggle password view
     $('.js-toggle-visibility').on('click',function (e) {
         e.preventDefault();
         var $this = $(this),
             id = "#" + $this.data('passinput'),
             passInput = $(id),
             passHidden = ( passInput.attr('type') === 'password' );


        if(passHidden){
            passInput.attr('type','text');
            $this.children('i.fa')
                .removeClass('fa-eye')
                .addClass('fa-eye-slash');
            passHidden = !passHidden;
        }else{
            passInput.attr('type','password');
            $this.children('i.fa')
                .removeClass('fa-eye-slash')
                .addClass('fa-eye');
            passHidden = !passHidden;
        }
     });

     //changes input class if filled
     input.on('input', function () {
         var $this = $(this);
         makeInputGreen($this);
     });

     // make input green when filled
     function makeInputGreen(el) {
         if( el.val().length ){
             el.addClass('form-input--filled')
         }else{
             el.removeClass('form-input--filled');
         }
     }


     //Moves the tab's underline, under the active tab
     function moveUnderline() {

         var lineLeft = tabs.children('.active').offset().left - tabsLeft;

         $('.login-tabs-underline').css({
             left: lineLeft
         });
     }
     //shows relared form
     function changeForm() {
         var activeTab = tabs.children('.active'),
             tabTarget = activeTab.data('target');

         $('div[class$="-content"]').hide();
         $('.'+ tabTarget +'-content').fadeIn();
     }

 }); //End Of siaf!

/*
*-------------------------------------------------------
* Form resetting
*-------------------------------------------------------
*/
jQuery(function($){

    // Disable scrolling on input number
    $(':input[type=number]').on('mousewheel', function(e){
        e.preventDefault();
    });

}); //End Of siaf!

/*
*-------------------------------------------------------
* Password stregth check
*-------------------------------------------------------
*/

 jQuery(function($){

     "use strict";
     var lang = $('html').attr('lang'),
         options = {};
     options.ui = {
         container: "#pwd-container",
         //showVerdictsInsideProgressBar: false,
         viewports: {
             progress: ".pw-progress",
             verdict: ".pw-verdict"
         },
         colorClasses: ["danger", "danger", "warning", "warning", "success", "success"],
         progressBarExtraCssClasses: "progress-bar-striped active"
     };
     options.common = {
         onKeyUp: function () {
             translateToFa();
         }

     };

     // $('#reg-password').pwstrength(options);


         function translateToFa (){
             if(lang==="fa") {
                 var verdictContainer = $('#pwd-container .password-verdict'),
                     text = verdictContainer.text(),
                     translation;


                 switch (text) {
                     case "Very Weak":
                         translation = "بسیار ضعیف";
                         break;
                     case "Weak":
                         translation = "ضعیف";
                         break;
                     case "Normal":
                         translation = "متوسط";
                         break;
                     case "Medium":
                         translation = "خوب";
                         break;
                     case "Strong":
                         translation = "قوی";
                         break;
                     case "Very Strong":
                         translation = "بسیار قوی";
                         break;
                     default:
                         translation = "";


                 }
                 verdictContainer.text(translation);
             }else{
                 return
             }
         }



 }); //End Of siaf!