/*
    Project Name : Webmaker
    Author Company : SpecThemes
    Project Date: 5 June, 2017
    Template Developer: vsafaryan50@gmail.com
*/


/*
==============================================
TABLE OF CONTENT
==============================================

1. Owl Carousels
2. CountUp
3. Slider
4. Navbar
5. Youtube Video Section
6. Video Modal
7. Preloader
8. Scroll To Top
9. Pie Chart
10. WOW
11. Tabs
12. Input Number, Shopping Cart
13. iziModal
14. Justified Gallery
15. Magnific Popup
16. CountDowns
17. Fullscreen
18. Shop Cart
19. Ripple Effect

==============================================
[END] TABLE OF CONTENT
==============================================
*/

"use strict";



$(document).ready(function() {


/*------------------------------------
    1. Owl Carousel
--------------------------------------*/  


/*---------------------
Testmonials carousel
-----------------------*/
  $('#testmonials-carousel').owlCarousel({
    loop: false,
    responsiveClass: true,
    nav:true,
    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],       
    responsive: {
      0: {
        items: 1,
        nav: false,
        dots: true,
        margin: 10,
      },
      600: {
        items: 1,
        nav: false,
        dots: true,        
        margin: 15,
      },
      1000: {
        items: 1,
        dots: false,
        margin: 40,
      }
    }
  })  



/*---------------------
Blog Grid
-----------------------*/
  $('#blog-grid-simple').owlCarousel({
    loop: false,
    responsiveClass: true,
    nav:false,
    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],       
    autoplay: true,
    smartSpeed: 950,
    autoplayTimeout: 1800,  
    responsiveClass: true,
    autoplayHoverPause:false,    
    responsive: {
      0: {
        items: 1,
        nav: false,
        dots: true,
        margin: 10,
      },
      600: {
        items: 2,
        nav: false,
        dots: true,        
        margin: 0,
      },
      1000: {
        items: 3,
        dots: true,
        margin: 0,
      }
    }
  })   



/*---------------------
Team Carousel
-----------------------*/
  $('#team-block').owlCarousel({
    dots: true,
    loop: false,
    nav: false,    
    responsiveClass: true,
    smartSpeed: 950,
    responsive: {
      0: {
        items: 1,
        margin: 15,
        dots: false,
      },
      600: {
        items: 1,
        margin: 0,
        dots: false,
      },
      1000: {
        items: 2,
        margin: 0,
      }
    }
  })


/*---------------------
Testmonials Carousel 1
-----------------------*/
  $('#testmonials-modern').owlCarousel({
    loop: false,
    nav: false,    
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        margin: 15,
        dots: false,
      },
      600: {
        items: 1,
        margin: 20,
        dots: false,
      },
      1000: {
        items: 2,
        margin: 0,
      }
    }
  })


/*---------------------
Testmonials Carousel 2
-----------------------*/
  $('#testmonials-parallax').owlCarousel({
    dots: false,
    loop: false,
    nav: false,   
    smartSpeed: 950, 
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        margin: 15,
        dots: false,
      },
      600: {
        items: 1,
        margin: 0,
        dots: false,
      },
      1000: {
        items: 1,
        margin: 0,
      }
    }
  })



/*---------------------
Clients carousel
-----------------------*/
  $('#clients').owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    autoplay: true,
    smartSpeed: 950,
    autoplayTimeout: 2000,  
    responsiveClass: true,
    autoplayHoverPause:false,
    responsive: {
      0: {
        items: 2,
        margin: 50,
      },
      600: {
        items: 4,
        margin: 80,
      },
      1000: {
        items: 6,
        margin: 80,
      }
    }
  })



/*---------------------
Clients carousel
-----------------------*/
  $('.projects_4col').owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    autoplay: true,
    smartSpeed: 500,
    autoplayTimeout: 5000,  
    responsiveClass: true,
    autoplayHoverPause:false,
    responsive: {
      0: {
        items: 1,
        margin: 0,
      },
      600: {
        items: 2,
        margin: 0,
      },
      1000: {
        items: 4,
        margin: 0,
      }
    }
  })  



/*---------------------
Single Item Autoplay Carousel
-----------------------*/
  $('.carousel-single-item-autoplay').owlCarousel({
    dots: false,
    loop: true,
    nav: false,   
    responsiveClass: true,
    autoplay: true,
    smartSpeed: 950,
    autoplayTimeout: 6000,  
    autoplayHoverPause: true,   
    responsive: {
      0: {
        items: 1,
        margin: 30,
      },
      600: {
        items: 1,
        margin: 0,
      },
      1000: {
        items: 1,
        margin: 0,
      }
    }
  })

/*---------------------
Single Item Carousel
-----------------------*/
  $('.carousel-single-item').owlCarousel({
    dots: false,
    loop: false,
    nav: false,   
    smartSpeed: 950, 
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        margin: 30,
      },
      600: {
        items: 1,
        margin: 0,
      },
      1000: {
        items: 1,
        margin: 0,
      }
    }
  })  


/*---------------------
Gallery Carousel
-----------------------*/
  $('.gallery-carousel').owlCarousel({
    center:true,
    stagePadding: 20,
    smartSpeed: 1100,   
    URLhashListener:true,
    startPosition: 'URLHash',
    autoplay:true,
    autoplayTimeout: 3500,
    loop: true,
    nav: false,    
    responsiveClass: true,
    dots: false,
    responsive: {
      0: {
        items: 1,
        margin: 15,
      },
      600: {
        items: 1,
        margin: 15,
      },
      1000: {
        items: 2,
        margin: 30,
      }
    }
  })    




/*---------------------
Customiable Carousel
-----------------------*/
  var owl_carousel = $("div.customizable-carousel");
  if(owl_carousel.length > 0) {  
     owl_carousel.each(function () {
      var $this = $(this),
          $items = ($this.data('items')) ? $this.data('items') : 1,
          $loop = ($this.attr('data-loop')) ? $this.data('loop') : true,
          $navdots = ($this.data('nav-dots')) ? $this.data('nav-dots') : false,
          $navarrows = ($this.data('nav-arrows')) ? $this.data('nav-arrows') : false,
          $autoplay = ($this.attr('data-autoplay')) ? $this.data('autoplay') : false,
          $autospeed = ($this.attr('data-autospeed')) ? $this.data('autospeed') : 3500,
          $smartspeed = ($this.attr('data-smartspeed')) ? $this.data('smartspeed') : 950,
          $autohgt = ($this.data('autoheight')) ? $this.data('autoheight') : false,
          $space = ($this.attr('data-space')) ? $this.data('space') : 15;    
     
          $(this).owlCarousel({
              loop: $loop,
              items: $items,
              responsive: {
                0:{items: $this.data('xs-items') ? $this.data('xs-items') : 1},
                600:{items: $this.data('sm-items') ? $this.data('sm-items') : 2},
                1000:{items: $this.data('md-items') ? $this.data('md-items') : 3},
                1000:{items: $items}
              },
              dots: $navdots,
              autoplayTimeout:$autospeed,
              smartSpeed: $smartspeed,
              autoHeight:$autohgt,
              margin:$space,
              nav: $navarrows,
              navText:["<i class='ti-angle-left'></i>","<i class='ti-angle-right'></i>"],
              autoplay: $autoplay,
              autoplayHoverPause: true   
          }); 
     }); 
  }




/*------------------------------------
    2. CountUp
--------------------------------------*/  
  $('.countup').counterUp({
      delay: 25,
      time: 2500
  });



/*------------------------------------
    3. Slider
--------------------------------------*/ 
  
  /*---------------------
  Main Slider
  -----------------------*/
  if($(".swiper-main-slider").length !== 0) { 
      //Slider Animated Caption 
      var swiper = new Swiper('.swiper-container', {
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
          },        
          pagination: '.swiper-pagination',
          paginationClickable: true,
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev',
          spaceBetween: 0,
          loop: true,
          simulateTouch: true,
          autoplay: 7000,
          speed: 1000,
          onSlideChangeEnd: function(swiper) {
              $('.swiper-slide').each(function() {
                  if ($(this).index() === swiper.activeIndex) {
                      // Fadein in active slide
                      $(this).find('.slider-content').fadeIn(300);
                  } else {
                      // Fadeout in inactive slides
                      $(this).find('.slider-content').fadeOut(300);
                  }
              });
          }
      });
  }

  /*---------------------
  Main Slider Fade Effect
  -----------------------*/
  if($(".swiper-main-slider-fade").length !== 0) { 
      //Slider Animated Caption 
      var swiper = new Swiper('.swiper-container', {
          effect: 'fade',
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
          },        
          pagination: '.swiper-pagination',
          paginationClickable: true,
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev',
          spaceBetween: 0,
          loop: true,
          simulateTouch: false,
          autoplay: 7000,
          speed: 1000,
          onSlideChangeEnd: function(swiper) {
              $('.swiper-slide').each(function() {
                  if ($(this).index() === swiper.activeIndex) {
                      // Fadein in active slide
                      $(this).find('.slider-content').fadeIn(300);
                  } else {
                      // Fadeout in inactive slides
                      $(this).find('.slider-content').fadeOut(300);
                  }
              });
          }
      });
  }  

  /*---------------------
  Parallax Slider
  -----------------------*/
  if($("#swiper-parallax").length !== 0) { 
    var swiper = new Swiper('.swiper-container', {
      parallax: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
      },        
      pagination: '.swiper-pagination',
      paginationClickable: true,
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
      spaceBetween: 0,
      loop: false,
      simulateTouch: true,
      autoplay: false,
      speed: 1000,
    });
  }

    /*---------------------
  Revolution Slider
  -----------------------*/
  if($("#rev_slider_24_1").length !== 0) {
    var tpj=jQuery;
    var revapi24;
    tpj(document).ready(function() {
      if(tpj("#rev_slider_24_1").revolution == undefined){
        revslider_showDoubleJqueryError("#rev_slider_24_1");
      }else{
        revapi24 = tpj("#rev_slider_24_1").show().revolution({
          sliderType:"standard",
          jsFileLocation:"revolution/js/",
          sliderLayout:"fullscreen",
          dottedOverlay:"none",
          delay:9000,
          navigation: {
            keyboardNavigation:"off",
            keyboard_direction: "horizontal",
            mouseScrollNavigation:"off",
            mouseScrollReverse:"default",
            onHoverStop:"off",
            bullets: {
              enable:true,
              hide_onmobile:false,
              style:"bullet-bar",
              hide_onleave:false,
              direction:"horizontal",
              h_align:"center",
              v_align:"bottom",
              h_offset:0,
              v_offset:50,
              space:5,
              tmp:''
            }
          },
          responsiveLevels:[1240,1024,778,480],
          visibilityLevels:[1240,1024,778,480],
          gridwidth:[1240,1024,778,480],
          gridheight:[868,768,960,720],
          lazyType:"none",
          shadow:0,
          spinner:"off",
          stopLoop:"off",
          stopAfterLoops:-1,
          stopAtSlide:-1,
          shuffle:"off",
          autoHeight:"off",
          fullScreenAutoWidth:"off",
          fullScreenAlignForce:"off",
          fullScreenOffsetContainer: "",
          fullScreenOffset: "60px",
          hideThumbsOnMobile:"off",
          hideSliderAtLimit:0,
          hideCaptionAtLimit:0,
          hideAllCaptionAtLilmit:0,
          debugMode:false,
          fallbacks: {
            simplifyAll:"off",
            nextSlideOnWindowFocus:"off",
            disableFocusListener:false,
          }
        });
      }

              if(revapi24) revapi24.revSliderSlicey();
    }); /*ready*/
  }

    

/*------------------------------------
    4. Navbar
--------------------------------------*/    

  /*---------------------
  Fixed Nav
  -----------------------*/
  $("#navigation1").navigation();
  $("#navigation1").fixed();

  /*---------------------
  Transparent Nav Options
  -----------------------*/
  if ($("#nav-transparent").length !== 0) {
    if ($(window).width() > 991){
      $("#nav-transparent #main_logo").css("display" , "none"); 
    }
    else{
      $("#nav-transparent #light_logo").css("display" , "none"); 
    }
    $(window).scroll(function(){
      var scroll = $(window).scrollTop();
      if ($(window).width() > 991){
        if (scroll > 30) {
          $(".navigation-fixed-wrapper").addClass("nav-white-bg");  
          $("#nav-transparent #main_logo").css("display" , "inline-block"); 
          $("#nav-transparent #light_logo").css("display" , "none"); 
        }
        else{
          $(".navigation-fixed-wrapper").removeClass("nav-white-bg"); 
          $("#nav-transparent #light_logo").css("display" , "inline-block");
          $("#nav-transparent #main_logo").css("display" , "none"); 
        }
      }
    })  
  }

  /*---------------------
  Nav Slide Effect
  -----------------------*/  
  $("#navigation2").navigation({
    effect: "slide"
  });
  
  /*---------------------
  Nav Zoom Effect
  -----------------------*/
  $("#navigation3").navigation({
    animationOnShow: "zoom-in",
    animationOnHide: "zoom-out"
  });
  
  /*---------------------
  Overlay Nav
  -----------------------*/    
  $("#navigation4").navigation({
    overlayColor: "rgba(0,0,0,0.6)"
  });

  /*---------------------
  Affix Nav
  -----------------------*/
  $("#navigation4").fixed({
    offset: 20
  });
  
  /*---------------------
  Hidden Nav
  -----------------------*/  
  $("#navigation5").navigation({
    hidden: true
  });

  if ($("#navigation-push").length !== 0) {
    if ($(window).width() > 991){
      $("#navigation-push").find($(".nav-menus-wrapper").addClass("nav-menus-wrapper-open"));
      $("#navigation-push").find($(".nav-menus-wrapper-close-button").hide());
      $("#navigation-push").find($(".small-size-header").hide());
    }
    else{
      $("#navigation5 #main_logo").clone().appendTo(".small-size-header-logo");
      $("#main_logo").css("display", "none");
      $("#navigation-push").find($(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open"));  
    } 
  }

  /*---------------------
  Button Nav
  -----------------------*/
  $(".btn-show").on('click', function(){ 
    $("#navigation5").data("navigation").toggleOffcanvas();
  });
  
  $("#navigation6").navigation({
    offCanvasSide: "right"
  });

  /*---------------------
  Simple Nav
  -----------------------*/  
  $("#navigation7").navigation();


/*------------------------------------
    5. Youtube Video Section
--------------------------------------*/ 
  if($(".video-section").length !== 0) {
    $('.player').mb_YTPlayer();
  }

  if($(".main-video-section").length !== 0) {
    $('#main-video-play').mb_YTPlayer();
  } 


/*------------------------------------
    6. Video Modal
--------------------------------------*/ 
  $('.modal').on('hidden.bs.modal', function() {
    var $this = $(this).find('iframe'),
      tempSrc = $this.attr('src');
    $this.attr('src', "");
    $this.attr('src', tempSrc);
  });


/*------------------------------------
    7. Preloader
--------------------------------------*/ 
  $('#preloader').fadeOut('normall', function() {
      $(this).remove();
  });


/*------------------------------------
    8. Scroll To Top
--------------------------------------*/ 
  $(window).scroll(function(){
      if($(this).scrollTop() > 500) {
          $(".scroll-to-top").fadeIn(400);
          
      } else {
          $(".scroll-to-top").fadeOut(400);
      }
  });

  $(".scroll-to-top").on('click', function(event){
      event.preventDefault();
      $("html, body").animate({scrollTop: 0},600);
  });



/*------------------------------------
    9. Pie Chart
--------------------------------------*/  
  if ($('.chart').length > 0) {
      var $pieChart = $('.chart');
      $pieChart.each(function () {
          var $elem = $(this),
              pieChartSize = $elem.attr('data-size') || "120",
              pieChartAnimate = $elem.attr('data-animate') || "2100",
              pieChartWidth = $elem.attr('data-width') || "6",
              pieChartColor = $elem.attr('data-color') || "#2e52c2",
              pieChartTrackColor = $elem.attr('data-trackcolor') || "rgba(0,0,0,0.1)";
          $elem.find('span, i').css({
              'width': pieChartSize + 'px',
              'height': pieChartSize + 'px',
              'line-height': pieChartSize + 'px'
          });
          $elem.appear(function () {
              $elem.easyPieChart({
                  size: Number(pieChartSize),
                  animate: Number(pieChartAnimate),
                  trackColor: pieChartTrackColor,
                  lineWidth: Number(pieChartWidth),
                  barColor: pieChartColor,
                  scaleColor: false,
                  lineCap: 'round',
                  onStep: function (from, to, percent) {
                      $elem.find('span.percent').text(Math.round(percent));
                  }
              });
          });
      });
  };
      

/*------------------------------------
    10. WOW
--------------------------------------*/ 
  new WOW().init();

});


/*------------------------------------
    11. Tabs
--------------------------------------*/ 
  $('.tabs_animate').tabslet({
    mouseevent: 'click',
    attribute: 'href',
    animation: true
  });


/*------------------------------------
    12. Input Number, Shopping Cart
--------------------------------------*/ 
  /*---------------------
  Input Number
  -----------------------*/
  jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
  jQuery('.quantity').each(function() {
    var spinner = jQuery(this),
      input = spinner.find('input[type="number"]'),
      btnUp = spinner.find('.quantity-up'),
      btnDown = spinner.find('.quantity-down'),
      min = input.attr('min'),
      max = input.attr('max');

    btnUp.on("click", function() {
      var oldValue = parseFloat(input.val());
      if (oldValue >= max) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue + 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });

    btnDown.on("click", function() {
      var oldValue = parseFloat(input.val());
      if (oldValue <= min) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue - 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });

  });


  /*---------------------
  Shopping Cart
  -----------------------*/
  $('.close-box').on("click", function () {
    $(this).parentsUntil('.row').slideToggle();
    return false;
  });



/*------------------------------------
    13. Modal
--------------------------------------*/ 
  $(".izimodal").iziModal({
      width: 800,
      top: null,
      bottom: null,
      borderBottom: false,
      padding: 0,
      radius: 3,
      zindex: 999999,
      iframe: false,
      iframeHeight: 400,
      iframeURL: null,
      focusInput: false,
      group: '',
      loop: false,
      arrowKeys: true,
      navigateCaption: true,
      navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
      history: false,
      restoreDefaultContent: true,
      autoOpen: 0, // Boolean, Number
      bodyOverflow: false,
      fullscreen: false,
      openFullscreen: false,
      closeOnEscape: true,
      closeButton: true,
      appendTo: 'body', // or false
      appendToOverlay: 'body', // or false
      overlay: true,
      overlayClose: true,
      overlayColor: 'rgba(0, 0, 0, .7)',
      timeout: false,
      timeoutProgressbar: false,
      pauseOnHover: false,
      timeoutProgressbarColor: 'rgba(255,255,255,0)',
      transitionIn: 'comingIn',
      transitionOut: 'comingOut',
      transitionInOverlay: 'fadeIn',
      transitionOutOverlay: 'fadeOut',
      onFullscreen: function(){},
      onResize: function(){},
      onOpening: function(){},
      onOpened: function(){},
      onClosing: function(){},
      onClosed: function(){},
      afterRender: function(){}
  });
  $(document).on('click', '.trigger', function (event) {
      event.preventDefault();
      $('.izimodal').iziModal('setZindex', 99999999);
      $('.izimodal').iziModal('open', { zindex: 99999999 });
      $('.izimodal').iziModal('open');
  });





/*------------------------------------
    14. Justified Gallery 
--------------------------------------*/ 
  if ($('.justified_gallery').length > 0) {
      $(".justified_gallery").justifiedGallery();
      var $justifiedgallery = $('.justified_gallery');
      $justifiedgallery.each(function () {
          var $element = $(this),
          rowHeight = $element.attr('data-rowHeight') || "200",
          margins = $element.attr('data-margins') || "10"             
          $element.appear(function () {
              $element.justifiedGallery({
                  rowHeight: Number(rowHeight),
                  margins: Number(margins),
              });
          });
      });
  };



/*------------------------------------
    15. Magnific Popup
--------------------------------------*/ 
  $('.image-popup-gallery').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    mainClass: 'mfp-fade',
    fixedContentPos: true,
    image: {
      verticalFit: true,
    },
    gallery: {
      tCounter: '',
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
    }  
  });


  $('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    mainClass: 'mfp-fade',
    fixedContentPos: true,
    image: {
      verticalFit: true,
    },
  });

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    closeOnContentClick: true,
    closeBtnInside: false,    
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
  });



/*------------------------------------
    16. CountDowns
--------------------------------------*/ 
    $('.countdown').countdown($('.countdown').attr("data-enddate")).on('update.countdown', function (event) {
        $(this).html(event.strftime('' + '<div class="row"><div class="col-md-3 col-sm-6 col-3"><div class="countdown-box">%-D<h6>Day%!d</h6></div></div>' + '<div class="col-md-3 col-sm-6 col-3"><div class="countdown-box">%H<h6>Hours</h6></div></div>' + '<div class="col-md-3 col-sm-6 col-3"><div class="countdown-box">%M<h6>Minutes</h6></div></div>' + '<div class="col-md-3 col-sm-6 col-3"><div class="countdown-box">%S<h6>Seconds</h6></div></div></div>'));
    });



/*------------------------------------
    17. Fullscreen
--------------------------------------*/ 
function fullScreenHeight() {
  var element = $(".full-height");
  var $minheight = $(window).height();
      if ($(".full-height").length > 0) {
          $(".full-height").css('min-height', $minheight);
      } else {
          element.css('min-height', $minheight);
      }
}

if ($(".full-height").length > 0) {
  fullScreenHeight();
}




/*------------------------------------
    18. Shop Cart
--------------------------------------*/ 
  $('.close-box').on("click", function () {
    $(this).parentsUntil('#1').slideToggle();
    return false;
  });



/*------------------------------------
    19. Ripple Effect
--------------------------------------*/  
  try {
    $('.erreor-box-404').ripples({
      resolution: 512,
      dropRadius: 20, //px
      perturbance: 0.04,
    });
    $('main').ripples({
      resolution: 512,
      dropRadius: 20, //px
      perturbance: 0.04,
      interactive: false
    });
  }
  catch (e) {
    $('.error').show().text(e);
  }

  $('.js-ripples-disable').on('click', function() {
    $('body, main').ripples('destroy');
    $(this).hide();
  });

  $('.js-ripples-play').on('click', function() {
    $('body, main').ripples('play');
  });

  $('.js-ripples-pause').on('click', function() {
    $('body, main').ripples('pause');
  });

  // Automatic drops
  setInterval(function() {
    var $el = $('main');
    var x = Math.random() * $el.outerWidth();
    var y = Math.random() * $el.outerHeight();
    var dropRadius = 20;
    var strength = 0.04 + Math.random() * 0.04;

    $el.ripples('drop', x, y, dropRadius, strength);
  }, 400);
