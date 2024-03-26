jQuery(document).ready(function ($) {
	
	/* ===== PAGE LOADING ANIMATION ===== */
	$(window).load(function () {
        $('.page-loading').css('opacity',0);
        setTimeout(function(){
            $('.page-loading').hide();
        }, 1000);
    }); // .Page Loading Animation
	
	$('table.variations select').select2();
		
	
	/* ===== Notice Bar =====*/
	function setCookieWCD(key, val, days) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); //10 days
        document.cookie = key + '=' + window.escape(val) + ';expires=' + expires.toUTCString();
    }
	
	window.onload = function () {
		$('.woocommerce-store-notice__dismiss-link').click(function () {
			$('.navbar').css("margin-top" , "0");
			$('body').removeClass('woocommerce-demo-store');
		});
		
		if ( getCookie('store_notice') === "hidden"){
			$('body').removeClass('woocommerce-demo-store');
		}
	};
	
	/* ===== To overwrite bootstrap menu | Owen ===== */
	$('.navbar .dropdown > a').click(function(){
		location.href = this.href;
	});
	/* ===== To overwrite bootstrap menu end ===== */
	
	/*
     Set .drawOnView.active when first visible
     ========================================================
     This function should look for .drawOnView, and set .active when this element is scrolled into view.
     This is to allow animations to be set to begin when an element is first visible in the viewport
     */
	/* ===== GGS animation | Owen ===== */
    var navBarHeight,
        drawIn = $('.drawOnView');

    if ($('#topNav:visible')) {
        navBarHeight = $('#topNav:visible').outerHeight();
    } else {
        navBarHeight = $('#mainNav').outerHeight();
    }

    function drawOnView() {
        drawIn.each(function () {
            var thisPos = $(this).offset().top - navBarHeight - (windowHeight / 2);
            if (scrollY >= thisPos) {
                $(this).addClass('active');
                $('[data-carousel]').slick('slickPlay');
            }
            if (scrollY < thisPos) {
                $(this).removeClass('active');
            }
        });
    }
	/* ===== Mobile menu end ===== */
	
	/* ===== SCROLL LISTENER - Poll the browser on scroll for the viewport Y position, then fire relevant functions ===== */
    var scrollY,
        windowHeight;
    // if statement to ensure we only do this when needed
    if (drawIn || buyNow) {
        $(document).on('scroll', function () {
            scrollY = $(this).scrollTop();
            windowHeight = $(window).innerHeight();
            // run any animations that have appeared in view
            if (drawIn) {
                drawOnView();
            }

            // update position of fixed element '.bnFixed'
            if (buyNow) {
                fixBuyNow();
            }
        });
    } 
	/* ===== END Scroll Listener ===== */
	
	/* ===== Mega menu | Owen - 06/11/18 =====*/
	$("#menu-main-menu > .nz-mega-menu").each(function(){
		$(this).find(".dropdown-menu > .nav-item > .dropdown-menu > .nav-item").hover(
			
			function() {
				$(this).find(".meganav-prod-img").clone().appendTo($(".default_menu_img"));
				$(this).find(".default_menu_img .meganav-prod-img").css("display", "block");
				$(".default_menu_img .meganav-prod-img").eq(0).css("display", "none");
			},
			function() {
				$(".default_menu_img .meganav-prod-img").eq(1).remove();
				$(".default_menu_img .meganav-prod-img").eq(0).css("display", "block");
			}
		);
	});
	
	$("#menu-main-menu > .nz-mega-menu > .dropdown-menu").each(function(){
		$(this).wrapInner('<div class="container"></div>');
	});
	/* ===== Mega menu end =====*/
	
	/* ===== MENU SEARCH ===== */
    var $desktopSearchForm = $('#menuSearchForm'),
        $desktopSearchField = $desktopSearchForm.find('input[type="text"]'),
        $desktopSearchButton = $('#menuSearchButton');

    $desktopSearchForm.submit(function (e) {
        if ($desktopSearchField.val() === '') {
            e.preventDefault();

            $('.menu-search-box').removeClass('open');
        }
    });

    $desktopSearchButton.click(function (e) {
        e.preventDefault();

        // if search form is open, submit the form
        if ($('.menu-search-box').hasClass('open')) {
            $desktopSearchForm.trigger('submit');

            // otherwise open the search form
        } else {
            $('.menu-search-box').addClass('open');
            $desktopSearchField.trigger('focus');
        }
    });

    $(document).on('click', function (e) {
        // if click is anywhere outside search box, close search
        if ((!$(e.target).closest('.menu-search-box').length) && ($('.menu-search-box').hasClass('open'))) {
            $('.menu-search-box').removeClass('open');
        }
    }); 
	/* ===== END Menu Search ===== */
	
	/* ===== MOBILE SEARCH ===== */
    var $mobileSearchContainer = $('.mobileSearch'),
        $mobileSearchForm = $('#mobileSearchForm');

    // If the user clicks outside the search form, close it. Bound/unbound
    // when the form opens/closes.
    var mobileSearchClickDocumentHandler = function (e) {
        // check the click was outside the form
        if (!$(e.target).closest($mobileSearchContainer).length) {
            // close the form
            $('.mobileSearch .menuSearchButton').trigger('click');
        }
    };

    // open/close mobile search form
    $mobileSearchContainer.on('click', '.menuSearchButton', function (e) {
        e.preventDefault();

        // open/close search form
        $mobileSearchForm.toggleClass('open');

        // styling to contain open/closed search form
        $(this).closest('.navbar').toggleClass('search-open');
        $('.navbar-collapse').removeClass('in');

        // showing the form
        if ($mobileSearchForm.hasClass('open')) {
            $('.form-control', $mobileSearchForm).trigger('focus');
            $(document).on('click touchend', mobileSearchClickDocumentHandler);

            // hiding it
        } else {
            $('.form-control', $mobileSearchForm).trigger('blur');
            $(document).off('click touchend', mobileSearchClickDocumentHandler);
        }
    });

    // check there's a value to search for before submitting, otherwise close the search form
    $mobileSearchForm.on('submit', function (e) {
        if ($(this).find('.form-control').val()) return true;
        e.preventDefault();
        // close the form
        $('.mobileSearch .menuSearchButton').trigger('click');
    });

    // if user hits escape when in search form, close it
    $('.form-control', $mobileSearchForm).keyup(function (e) {
        var key = e.keyCode || e.which;
        if (!($mobileSearchForm.hasClass('open'))) return false;
        // "esc" key code
        if (key == 27) {
            // close the form
            $('.mobileSearch .menuSearchButton').trigger('click');
        }
    });
	/* ===== MOBILE SEARCH END===== */
	
    /* ===== BOOTSTRAP TOOLTIP ===== */
	$('[data-toggle="tooltip"]').tooltip();
	/* ===== END Bootstrap Tooltip ===== */
	
	/* ===== SCROLL TO TOP BUTTON
     Show a button to allow user to quickly return to the
     top of the page
     */

    // Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn('800');
        } else {
            $('.scrollToTop').fadeOut('800');
        }
    });

    // Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
	/* ===== END croll top button ===== */
	
	
	/* ===== POST SNIPPETS HEIGHT
		 consistent heights for snippets inside container.
    */
    var calculateSnippetHeights,
        applySnippetHeights,
        throttledApply;

		calculateSnippetHeights = function () {
			var $snippets = $(this).find('.snippet'),
				heights = [],
				tallest;
			$snippets.css('height', 'auto');
			heights = $snippets.map(function () {
				return $(this).innerHeight();
        });
        tallest = Math.max.apply(null, heights);
        $snippets.addClass('active').css('height', tallest + 'px');
    };
		applySnippetHeights = function () {
        // match .container and .container-fluid
        $('.snippets  .row:not(.section-header)').each(calculateSnippetHeights);
    };
    // throttled resize event for recalculating snippet height
    //throttledApply = _.throttle(applySnippetHeights, 100);
	throttledApply = applySnippetHeights;
	
    $(window).resize(throttledApply);
    $(window).load(throttledApply);
	
	$(window).load(function(){
        //if($(window).height()>767){
		if($(window).width()>767){
           applySnippetHeights();
      	}
    });

    // expose for Angular app
    window.applySnippetHeights = applySnippetHeights;
	
	
	/* Shop page version */
	var calculateProductHeights,
        applyProductHeights,
        shopThrottledApply;

		calculateProductHeights = function () {
			var $products = $(this).find('.product'),
				productHeights = [],
				productTallest;
			$products.css('height', 'auto');
			productHeights = $products.map(function () {
				return $(this).innerHeight();
        });
        productTallest = Math.max.apply(null, productHeights);
        $products.addClass('active').css('height', productTallest + 'px');
    };
		applyProductHeights = function () {
        $('.products').each(calculateProductHeights);
    };
	shopThrottledApply = applyProductHeights;
	
    $(window).resize(shopThrottledApply);
    $(window).load(shopThrottledApply);
	
	$(window).load(function(){
		if($(window).width()>767){
           applyProductHeights();
      	}
    });

    // expose for Angular app
    window.applyProductHeights = applyProductHeights;
	
	
	
	/* ===== END Post Snippets Height ===== */
	
	
	
	/* ===== CUSTOM VC ELEMENTS
		 Sticky Buy Now panel : Affix position of buy now button/panel
    */
	/* STICKY BUY NOW STRIP : Affix position of buy now button/panel */
    if ($(".bnFixed").length !== 0) {
        var buyNow = $(".bnFixed"),
            buyNowHeight = buyNow.innerHeight(),
            buyNowTop = buyNow.offset().top,
            buyNowY = buyNowTop + buyNowHeight;
    }

    function fixBuyNow() {

        if (scrollY >= buyNowY - windowHeight) {
            buyNow.addClass('affix');
            // make sure body has margin at bottom so we don't overlap elements
            $('body').css('margin-bottom', buyNowHeight);
        } else {
            buyNow.removeClass('affix');
            // remove the body margin
            $('body').css('margin-bottom', '0');
        }
    }
	/* ===== END Sticky Buy Now Strip ===== */
	  
	/* ===== GLOBAL LOCATIONS ===== */
	  $('.location .expand').click(function () {
        $(this).siblings('.details').slideToggle('slow');
    });
	/* ===== END Global Locations ===== */
	
	/* ===== FAQ BLOCK ===== */
	$(".topic-list").each(function(){
			var str = $(".faqs-content").text();
			var cat = $(this).find(".faqs-cat").text();
    		if(!str.includes(cat)){
				$(this).css("display", "none");
			}
	});
	
	$(".faqs-cat-input.faqs_v1").each(function(){
			var str = $(".faqs-content").text();
			var cat = $(this).find("label").text();
    		if(!str.includes(cat)){
				$(this).css("display", "none");
			}
	});
	
	$(".faq-item .quick-list").each(function(){
        var quickList = $(this);
        var cloneList = quickList.clone();
        cloneList.insertAfter(quickList);
        quickList.find('.faq-list-item:odd').remove();
        cloneList.find('.faq-list-item:even').remove();
    });
	
	$("#faq_content").on('click','.faq-list-item',function () {
		var toggle = $(this).hasClass('active');
		//close all active
		$(".quick-list li.active").removeClass('active').find('.detail').stop().slideUp();
		if (!toggle) {
			//open this one
			$(this).addClass('active').find('.detail').stop().slideDown({duration: 500, easing: "swing"});	
		}
	});
	
	$(".quick-list-pop li").click(function () {
        var toggle2 = $(this).hasClass('active');
        //close all active
        $(".quick-list-pop li.active").removeClass('active').find('.details').stop().slideUp();
        if (!toggle2) {
            //open this one
            $(this).addClass('active').find('.details').stop().slideDown({duration: 500, easing: "swing"});
        }
    });
	/* ===== END FAQ Block ===== */
	
	/* ===== UNIQUE SELLING POINTS LISTS ===== */
	$(".quick-list li").click(function () {
        var toggle = $(this).hasClass('active');
        //close all active
        $(".quick-list li.active").removeClass('active').find('.detail').stop().slideUp();
        if (!toggle) {
            //open this one
            $(this).addClass('active').find('.detail').stop().slideDown({duration: 500, easing: "swing"});
        }
    });
	/* ===== END USP Lists ===== */
	
	/* ===== TOGGLE INGREDIENTS LISTS ===== */
    $(".ingredients-list-container:not(:last)").remove();
    $('.ingredients-list-container').appendTo('body');
	
    $('.toggle-in').click(function () {
        var ingredientsPanel = $('.ingredients-list-container'),
            fill = $('.in-backdrop'),
            initialPosition = '-100%';
        // console.log(ingredientsPanel.length);
        ingredientsPanel.removeAttr('style');
        // open it
        $('body').addClass('modal-open');
        fill.stop().fadeIn(450);
        ingredientsPanel.stop().animate(
            {
                "right": 0
            }, 600
        );
        // close it
        $('.in-backdrop, .ingredients-list-container .close').click(function () {
            fill.stop().delay(100).fadeOut(400);
            ingredientsPanel.stop().animate(
                {
                    "right": initialPosition
                }, 400, function () {
                    $('body').removeClass('modal-open');
                }
            );
        });

    });

    $('.ingredients-list-container .essb_link_print').remove();
	/* ===== END Toggle Ingredients Lists ===== */

	
	/* ===== SCROLL TO BUTTON ===== */
    $('.btn-scrollto').click(function () {
        $('html, body').animate({
			scrollTop: $($.attr(this, 'href')).offset().top
		}, 500);
		return false;
	});
	/* ===== SCROLL TO BUTTON END===== */
	
	/* ===== BLOG STICKY SIDEBAR ===== */
     function stickySidebar() {
        var sidebar = $('.author-wrapper');
        if (sidebar.css('position') === 'fixed') {
            //var container = $('.post-detail.container'),
			var container = $('.container.wrap'),
                stopElem = $('.post-navigation').offset().top,
                windowHeight = $(document).height(),
                stopY = windowHeight - stopElem,
                ContLeft = container.offset().left,
                ContWidth = container.width(),

            // set position as per grid sizing
                colWidth = ContWidth / 12,
                sidebarWidth = colWidth * 3 - 40,
                sidebarLeft = (colWidth * 9) + ContLeft + 70;
            // set initial position & sizes
            sidebar.css('width', sidebarWidth + 'px');
            sidebar.css('left', sidebarLeft + 'px');
            // use Bootstrap Affix to scroll with page
			//alert(sidebar);
            sidebar.affix({
                offset: {
                    top: 196,
                    bottom: function () {
                        // set bottom value
                        return (this.bottom = stopY);
                    }
                }
            });

        } else {
            // set initial position & sizes
            sidebar.css('width', '100%');
            sidebar.css('left', 'auto');
        }

        sidebar.css('display', 'block');
    }
	$(document).ready(function () {
		stickySidebar();
		$(window).resize(stickySidebar);
	});
	
	/* ===== BLOG STICKY SIDEBAR END ===== */

	/*
     Set .active on CLICK
     ========================================================
     Allows us to toggle .active on any element
     Can be used to affect siblings, for example to toggle the visibility of a sibling by targeting with CSS
     eg: .element.active + .element
    */

    $(".navbar-toggle").on('click', function () {
        $(this).toggleClass('active');
    });

    var setActive = $(".activeToggle");
    setActive.on('click', function (e) {
        // check whether any sibling elements have active class
        if ($(this).siblings('.active')) {
            // remove class if they do
            $(this).siblings().removeClass('active');
        }
        // if it's an anchor prevent default for broader toggles
        if ($(this).attr('href')) {
            e.preventDefault();
        }
        // otherwise (default behavior) just toggle the active class
        $(this).toggleClass('active');
    });
    var searchElementList = $(".activeToggle li");
    searchElementList.on('click', function () {
        $(this).parents('.activeToggle').addClass('active');
    });
	
	/* ===== MEDIA WINDOWS ===== */
	$('.mediaToggle').click(function(e){
        e.preventDefault();
        var mediaContent = $(this).siblings('.mediaContent').html();
        //var mediaHeading = jQuery(this).siblings('.info').children('.title').html();
        $('#viewMedia .modal-body').html( mediaContent );
        //jQuery('#viewMedia .modal-header h5').html( mediaHeading );
        $('#viewMedia').modal('toggle');
    });
	/* ===== MEDIA WINDOWS END===== */
	
	/* ===== MODAL WINDOWS ===== */
    // Contact Us Modal
    $('#contactFormBtn').click(function (e) {
        e.preventDefault();
        $('#contactForm').modal('toggle');
    });

	/* modal close */
	$('.close').click(function () {
          $('body').removeClass('modal-open');
    });
    // Author Profile Modals

    if ($('.recipes').length) {
      $('.diet_types').each(function (i) {
        var postID = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            url: theme_js_vars.ajaxurl,
            data: {
                'action': 'ajax_get_diet_types',
                'postID': postID
            },
            success: function (data) {
              $this.html(data);
            },
            error: function (errorThrown) {
              $this.html('Sorry, there was an error loading diet types.');
            }
        });
      });
    }


    if ($('.blog').length) {
      $('.rev_slider .author-banner').each(function (i) {
        var postID = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            url: theme_js_vars.ajaxurl,
            data: {
                'action': 'ajax_get_author',
                'postID': postID
            },
            success: function (data) {
              $this.html(data);
            },
            error: function (errorThrown) {
              $this.html('Sorry, there was an error loading this content.');
            }
        });
      });
    }

    var showBio = $('a[data-show-modal="bio"]'),
        loadingBio = false;

    showBio.click(function (e) {
        e.preventDefault();

        if (typeof theme_js_vars.ajaxurl !== 'undefined') {
            var $link = $(this),
                $theModal = $('#generalModal'),
                appendTo = $theModal.find('#modalContent'),
                thisID = $(this).data('profile-id'),
                authorID = $(this).data('author-id');

            if (loadingBio) return;
            loadingBio = true;

            // visual state to show loading
            $link.addClass('loading');

            $.ajax({
                url: theme_js_vars.ajaxurl,
                data: {
                    'action': 'ajax_get_profile',
                    'id': thisID,
                    'authorID': authorID
                },
                success: function (data) {
                    appendTo.html(data);
                    $theModal.modal('toggle');
                    $link.removeClass('loading');
                    loadingBio = false;
                },
                error: function (errorThrown) {
                    appendTo.html('Sorry, there was an error loading the profile.');
                    $theModal.modal('toggle');
                    $link.removeClass('loading');
                    loadingBio = false;
                }
            });

        }
    });


	/* ===== INGREDIENTS LISTS PRINT/SAVE ===== */
    $(".print-ingredients").on('click', function () {
        //var stylesheetUrl = $(this).data('stylesheet-url');
        $('[media="all"]').attr('media','screen');
		var printcontent = document.getElementById("in-slide").innerHTML;
		document.body.innerHTML = printcontent;
		var sheet = document.createElement('style');
		sheet.innerHTML = "body{text-align:center;} div.in-content{text-align:center; text-align: -webkit-center;} div{font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;} div.text-center {font-size:20px; padding:50px} .no-print{display:none} table.in-group{width:80%; border:1px #ccc solid; padding:30px; margin-bottom:30px} table.in-group td:first-child{ text-align:left; } table.in-group td{ text-align:right; } div.in-group p a{ text-decoration: none; font-size: 30px; color: #333;}";
		document.body.appendChild(sheet);
        window.print();
		location.reload();

    });

    $('.share-ingredients').on('click',function(){
       $('.share').slideToggle();
    });
	/* ===== INGREDIENTS LISTS PRINT/SAVE END ===== */
	
	/* ===== Vitamins and minerals infographic.
      @todo: auto-cycle to next vitamin
     */
    var vitamins = (function () {
        // cache DOM references
        var _$bubble = $('.vitamins__bubble'),
            _$barNuZest = $('.barNuZest'),
            _$barOther = $('.barCompet'),
            _$barDetails = _$barNuZest.find('.barDetails'),
            _$percentVal = _$barDetails.find('.percent'),
            _$moreOf = _$barDetails.find('.moreOf');

        // Private

        var _swapBubble = function (data) {
            _$bubble.find('.more').html(data['nz-pct-more'] + '% more ' + data['title']);
            _$bubble.find('.heading').html(data.heading);
            _$bubble.find('.description').html(data.description);
        };

        var _swapGraph = function (data) {
            // get existing so we can animate in new val
            var currentVal = _$percentVal.text();

            // set bar heights
            _$barNuZest
                .css("height", data['nz-bar-value'] + '%')
                .attr('data-rel-value', data['nz-bar-value']);

            _$barOther
                .css("height", data['other-bar-value'] + '%')
                .attr('data-rel-value', data['other-bar-value']);

            // update value within Nuzest bar
            $({count: currentVal}).animate({count: data['nz-pct-more']}, {
                duration: 600,
                step: function () {
                    // increase value each step
                    _$percentVal.html(Math.floor(this.count) + '%');
                },
                complete: function () {
                    // ensure final value is correct
                    _$percentVal.html(Math.floor(this.count) + '%');
                }
            });

            // update vitamin type comparison
            _$moreOf.html('more ' + data['title']);
        };

        // Public

        var swap = function (data) {
            _swapBubble(data);
            _swapGraph(data);
        };

        return {
            swap: swap,
        };
    })();

    // clicks on menu links, swap infographic
    $('.vitamins__menu').on('click', 'a', function (e) {
        e.preventDefault();

        var data;

        // update current link
        $(this).closest('li')
            .siblings().removeClass('active')
            .end().addClass('active');

        // swap bubble and graph content
        data = {
            'title': $(this).data('title'),
            'heading': $(this).data('heading'),
            'description': $(this).data('description'),
            'nz-pct-more': $(this).data('nz-pct-more'),
            'nz-bar-value': $(this).data('nz-bar-value'),
            'other-bar-value': $(this).data('other-bar-value'),
        };

        vitamins.swap(data);
    });

    // start on first menu link when loading page
    $('.vitamins__menu a:first').trigger('click');

    // clicks on "?" shows the bubble
    $('.vitamins .bubble-link').on('click', function (e) {
        e.preventDefault();

        $('.vitamins__bubble').toggleClass('show');
        $('.vitamins .btmBar').toggleClass('mute');
    });

    // close vitamin bubble when "x" is clicked
    $('.vitamins__bubble .close').on('click', function (e) {
        e.preventDefault();

        $('.vitamins__bubble').toggleClass('show');
        $('.vitamins .btmBar').toggleClass('mute');
    });
	/* ===== Vitamins and minerals infographic ===== */
    
	/* ===== Previous/next vitamin arrows ===== */
    var vitaminInDirection = function (direction) {
        var $options = $('.vitamins__menu li'),
            $current = $options.filter('.active'),
            index = $current.index();
        if (direction === 'left') {
            if (index === 0) {
                index = ($options.length - 1);
            } else {
                index = index - 1;
            }
        } else if (direction === 'right') {
            if (index === ($options.length - 1)) {
                index = 0;
            } else {
                index = index + 1;
            }
        }
        $options.eq(index).find('a').trigger('click');
    };

    // "previous vitamin" arrow
    $('.vitamins .rsArrowLeft').on('click', function (e) {
        e.preventDefault();
        vitaminInDirection('left');
    });

    $('.vitamins .rsArrowRight').on('click', function (e) {
        e.preventDefault();
        vitaminInDirection('right');
    });
	/* ===== Previous/next vitamin arrows end ===== */
	
	/* ===== Woocommerce product thumbnail image slide | Owen 10/18 =====*/
	$( window ).load(function() {
			setTimeout(function(){
            	$( ".flex-control-nav" ).wrap( "<div class='thumbs_warp'></div>" );
				if($("div.woocommerce-product-gallery").hasClass("woocommerce-product-gallery--columns-") ||$("div.woocommerce-product-gallery").hasClass("woocommerce-product-gallery--columns-0")){
					$("div.woocommerce-product-gallery").addClass("woocommerce-product-gallery--columns-4");
				}
        	}, 2500);
	});
	$( "#pa_size, #pa_flavour" ).change(function() {
	  		if ($(window).width() > 1600) {
				var translatesDistance = "translate3d(-500px, 0px, 0px)";
				var translatesDistance_v = "translate3d(0px, -500px, 0px)";
			}
			else if($(window).width() > 1200) {
				translatesDistance = "translate3d(-380px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -500px, 0px)";
			}
			else if($(window).width() > 992) {
				translatesDistance = "translate3d(-320px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -480px, 0px)";
			}
			else if($(window).width() > 767) {
				translatesDistance = "translate3d(-275px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -360px, 0px)";
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(1) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(5) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(0px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(6) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(7) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(8) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(9) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(10) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform",translatesDistance);
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(1) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(5) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(0px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(6) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(7) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(8) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(9) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(10) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform",translatesDistance_v);
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
	});
		$(".product").click( function () {
			if ($(window).width() > 1600) {
				var translatesDistance = "translate3d(-500px, 0px, 0px)";
				var translatesDistance_v = "translate3d(0px, -500px, 0px)";
			}
			else if($(window).width() > 1200) {
				translatesDistance = "translate3d(-380px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -500px, 0px)";
			}
			else if($(window).width() > 992) {
				translatesDistance = "translate3d(-320px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -480px, 0px)";
			}
			else if($(window).width() > 767) {
				translatesDistance = "translate3d(-275px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -360px, 0px)";
			}
			else if($(window).width() > 490) {
				translatesDistance = "translate3d(-500px, 0px, 0px)";
				translatesDistance_v = "translate3d(0px, -500px, 0px)";
			}

			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(1) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(5) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(0px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(6) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(7) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(8) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(9) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(10) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform",translatesDistance);
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(1) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(5) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(0px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(6) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(7) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(8) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(9) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-1 ol.flex-control-nav li:nth-child(10) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform",translatesDistance_v);
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
		});
		$('.product').on({ 'touchstart' : function(){

		  	if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(1) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(2) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(0px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(3) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(4) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(5) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(-250px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(6) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(7) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(8) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(-500px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
			if($( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(9) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(10) img" ).hasClass( "flex-active" )||$( ".woocommerce-product-gallery--columns-4 ol.flex-control-nav li:nth-child(11) img" ).hasClass( "flex-active" )){
				$(".flex-control-nav").css("transform","translate3d(-750px, 0px, 0px)");
				$(".flex-control-nav").css("transition-duration","0.5s");
			}
		} 
	});
	/* ===== Woocommerce product thumbnail image slide end=====*/
	
	/* ===== Woocommerce clear cart | Owen 10/18 ===== */
	$( "<button type='submit' name='clear-cart' class='btn button' style='min-width:100px'><i class='glyphicon glyphicon-trash'></i></button>").insertAfter( ".coupon" );
	/* ===== Woocommerce clear cart end ===== */
	
	/* ===== Woocommerce product qty control | Owen 10/18 ===== */
	$( ".quick-view-button").on('click',function(){
		setTimeout( function() {
		$( "<a class='qty-decrease'>–</a>" ).insertBefore( ".input-text.qty" );
		$( "<a class='qty-increase'>+</a>" ).insertAfter( ".input-text.qty" );	
		$( ".pp_overlay").append("<script>$('.qty-decrease').on('click',function(){ var qty=$('.quantity .qty').val(); var currentVal = parseInt(qty); if (!isNaN(currentVal) && currentVal > 0) { $('.quantity .qty').val(currentVal - 1); } });</script>");
		$( ".pp_overlay").append("<script>$('.qty-increase').on('click',function(){ var qty=$('.quantity .qty').val(); var currentVal = parseInt(qty); if (!isNaN(currentVal) && currentVal > 0) { $('.quantity .qty').val(currentVal + 1); } });</script>");
		}, 3000 );

	});
	$( "<a class='qty-decrease'>–</a>" ).insertBefore( ".input-text.qty" );
	$( "<a class='qty-increase'>+</a>" ).insertAfter( ".input-text.qty" );
	
	$('.summary .qty-decrease').on('click',function(){
        var qty=$('.quantity .qty').val();
        var currentVal = parseInt(qty);
        if (!isNaN(currentVal) && currentVal > 0) {
            $('.quantity .qty').val(currentVal - 1);
        }
    });
    $('.summary .qty-increase').on('click',function(){
        var qty=$('.quantity .qty').val();
        var currentVal = parseInt(qty);
        if (!isNaN(currentVal) && currentVal > 0) {
            $('.quantity .qty').val(currentVal + 1);
        }
    });
	$( ".cart_item").each(function(){
		var cart_item = $(this).find('.product-quantity .quantity .qty');
		$(this).find('.qty-decrease').on('click',function(){
			var qty= cart_item.val();
			var currentVal = parseInt(qty);
			if (!isNaN(currentVal) && currentVal > 0) {
				cart_item.val(currentVal - 1);
			}
		});
		$(this).find('.qty-increase').on('click',function(){
			var qty= cart_item.val();
			var currentVal = parseInt(qty);
			if (!isNaN(currentVal) && currentVal > 0) {
				cart_item.val(currentVal + 1);
			}
		});
	});
	$(document).on("click",".qty-decrease,.qty-increase", function() {
        $('[name="update_cart"]').removeAttr('disabled');
    });
	$('[name="update_cart"]').on("click", function() {
		setTimeout( function() {
			location.reload();
		}, 1000 );
	});
	/* ===== Woocommerce product qty control end ===== */

    $(window).on('load',function(){
        $('.cookie_control#change_country').modal('show');
		$('.cookie_control#choose_country').modal('show');
    });
	
    $('.region-select').click(function (e) {
        e.preventDefault();
        $('#choose_country').modal('toggle');
    });
	
	
	/* ===== COOKIES ===== */
    function setCookie(key, val, days) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); //10 days
        document.cookie = key + '=' + window.escape(val) + ';expires=' + expires.toUTCString() + ';domain=' + window.location.hostname +';path=/';
    }
	function setCookie2(key, val) {
        var expires2 = new Date();
        expires2.setTime(expires2.getTime() + (24 * 60 * 60 * 1000)); //1 days
        document.cookie = key + '=' + window.escape(val) + ';expires=' + expires2.toUTCString() + ';domain=' + window.location.hostname + ';path=/';
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return (keyValue) ? window.unescape(keyValue[2]) : null;
    }

	$('#change_country .back-to-user-country').on('click', function () {
        var regionId = $(this).attr('id');
        setCookie('nz_region', regionId, 10);
		setCookie2('nz_region_pop', regionId);
    });
	$('#change_country .stay-web-country').on('click', function () {
        var regionId = $(this).attr('id');
        setCookie('nz_region', regionId, 10);
		setCookie2('nz_region_pop', regionId);
		sessionStorage.setItem("thissession", "yes");
    });
	$('#choose_country .countrylink').each(function () {
		$(this).on('click', function () {
			var regionId = $(this).attr('id');
			setCookie('nz_region', regionId, 10);
			setCookie2('nz_region_pop', regionId);
		});
    });
	$('#choose_country .stay-web-country').on('click', function () {
        var regionId = $(this).attr('id');
        setCookie('nz_region', regionId, 10);
		setCookie2('nz_region_pop', regionId);
    });
	
    // Region select modal

    $('#regionSelect a.region').on('click', function (evt) {
        //store selection on region click
        var regionId = $(this).attr('id');
        setCookie('nz_region', regionId, 30);
    });

    //read existing region cookie
    //if set, look up relevant link and forward if not in location already
    var region = getCookie('nz_region');
    if (region) {
        var link = $('#regionSelect a#' + region);
        if (link) {
            var href = $(link).attr('href');
            var loc = window.location.href;
            //check current url against cookie pref
            var isRegion = new RegExp(href).test(loc);
            if (!isRegion) {
                var name = $(link).find('.name').html();
                var regionReturnModal = $('#regionReturn');
                regionReturnModal.find('.prevRegion').html(name);
                regionReturnModal.modal('toggle');
                //yes button, forward to region site
                regionReturnModal.find('.btn-confirm').on('click', function () {
                    window.location = href;
                });
                //no button, stay on site and set cookie to current region
                regionReturnModal.find('.btn-reject').on('click', function () {
                    var regions = $('#regionSelect a');
                    var currentRegion = _.find(regions, function (region) {
                        return new RegExp($(region).attr('href')).test(loc);
                    });
                    if (currentRegion) {
                        setCookie('nz_region', $(currentRegion).attr('id'), 30);
                    }
                });
            }
        }
    }

}); 



/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
} )();
