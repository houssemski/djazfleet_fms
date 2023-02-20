/**
* Theme: Adminto Admin Template
* Author: Coderthemes
* Module/App: Main Js
*/


!function($) {
    "use strict";

    var Navbar = function() {};

    /*
     * ADD SLIMSCROLL TO THE TOP NAV DROPDOWNS
     * ---------------------------------------
     */
    $(".scrollarea").slimscroll({
        height: '100%',
        size: "5px",
        color: '#000',
        allowPageScroll: true,
        alwaysVisible: true
    });

    $(".notification-list").slimscroll({
        position: 'left',
        height: '100%',
        size: "3px",
        color: '#000',
        allowPageScroll: true,
        alwaysVisible: true
    });


    //navbar - topbar
    Navbar.prototype.init = function () {
      //toggle
      $('.navbar-toggle').on('click', function (event) {
        $(this).toggleClass('open');
        $('#navigation').slideToggle(400);
        $('.cart, .search').removeClass('open');
      });

      $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.button-toggle-nav').on('click', function (e) {

            e.preventDefault();

            $('.side-menu-fixed').toggle(
                'fast',
                function() {
                $(this).toggleClass('slide-menu');

            }
            );
            if ($('.side-menu-fixed').hasClass('slide-menu')){
                $('.wrapper').css('margin-left', '220px');
            }else{
                $('.wrapper').css('margin-left', '0px');
            }


        });

      $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
       // if ($(window).width() < 992) {
          e.preventDefault();

          if ($(this).parent('li').hasClass('has-submenu')){
              if ($(this).parent('li').hasClass('open')) {

                  $('.submenu').removeClass('open').css('display', 'none');
                  $('.has-submenu').removeClass('open');
              }else {
                  $(this).parent('li').toggleClass('open').find('.submenu:first').toggle('slow', function() {
                      $(this).toggleClass('open');
                  });
              }
          }
      });

        $('.navigation-menu li.dropdown-submenu a[href="#"]').on('click', function (e) {
            // if ($(window).width() < 992) {
            e.preventDefault();

            if ($(this).parent('li').hasClass('dropdown-submenu')){
                if ($(this).parent('li').hasClass('open')) {
                    $('.dropdown-menu').removeClass('open').css('display', 'none');
                    $('.dropdown-submenu').removeClass('open');
                }else {
                    $(this).parent('li').toggleClass('open').find('.dropdown-menu:first').toggle('slow', function() {
                        $(this).toggleClass('open');
                    });
                }

            }
        });




      /*$(".right-bar-toggle").click(function(){
        $(".right-bar").toggle();
        $('.wrapper').toggleClass('right-bar-enabled');
      });*/
    },
    //init
    $.Navbar = new Navbar, $.Navbar.Constructor = Navbar
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Navbar.init()
}(window.jQuery);

