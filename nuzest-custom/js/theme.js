jQuery(document).ready(function ( $ ) {


	/*
		UTILITIES & SETUP
		========================================================
	*/


	// lone links in intro sections get turned into buttons
	// (makes it easy to add these via the cms without needing admin to style)
	$('.intro-sec.primary-intro p')
	.filter(function() {
		var $childNodes = $(this).contents();

		return $childNodes
				 .not($childNodes.filter('a').first())
				 .not(function() {
					 return this.nodeType === 3 && $.trim(this.nodeValue) === '';
				 }).length === 0;
	})
	.find('a').addClass('btn btn-primary');


	//feature banners start hidden to prevent ugly content before sliders kick in
	$("#feature-banner").animate({
		opacity: 1
	},400);

	/*
		Set .active on CLICK
		========================================================
		Allows us to toggle .active on any element
		Can be used to affect siblings, for example	to toggle
		the visibility of a sibling by targeting with CSS
		eg: .element.active + .element
	*/

	var setActive = $(".activeToggle");
	setActive.on('click', function(e) {
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



	/*
		Set .drawOnView.active when first visible
		========================================================
		This function should look for .drawOnView, and set
		.active when this element is scrolled into view.
		This is to allow animations to be set to begin when
		an element is first visible in the viewport
	*/

	var navBarHeight,
		drawIn = $('.drawOnView');

	if ( $('#topNav:visible') ) {
		navBarHeight = $('#topNav:visible').outerHeight();
	} else {
		navBarHeight = $('#mobileNav').outerHeight();
	}

	function drawOnView() {
		drawIn.each(function() {
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


	/*
		Scroll listener
		========================================================
		Poll the browser on scroll for the viewport Y position,
		then fire relevant functions
	*/

	var scrollY,
		windowHeight;

	// if statement to ensure we only do this when needed
	if ( drawIn || buyNow ) {
		$(document).on('scroll', function() {
			scrollY = $(this).scrollTop();
			windowHeight = $(window).innerHeight();
			// run any animations that have appeared in view
			if ( drawIn ) { drawOnView(); }

			// update position of fixed element '.bnFixed'
			if ( buyNow ) { fixBuyNow(); }
		});
	}



	// Move shop to the far right of the main menu
	$('.nz-menu-shop').appendTo('#menu-main-menu');


	// Initiate Bootstrap Tooltip
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});





	/*
		Scroll top button
		========================================================
		Show a button to allow user to quickly return to the
		top of the page
	*/

	// Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn('800');
		} else {
			$('.scrollToTop').fadeOut('800');
		}
	});

	// Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});



	/**
	 * Snippets height - consistent heights for snippets inside container.
	 */

	var calculateSnippetHeights,
		applySnippetHeights,
		throttledApply;

	calculateSnippetHeights = function() {
		var $snippets = $(this).find('.snippet'),
			heights = [],
			tallest;

		$snippets.css('height', 'auto');

		heights = $snippets.map(function() { return $(this).innerHeight(); });
		tallest = Math.max.apply(null, heights);


		$snippets.addClass('active').css('height', tallest + 'px');

	};

	applySnippetHeights = function() {
		// match .container and .container-fluid
		$('.snippets > [class^="container"] > .row:not(.section-header)').each(calculateSnippetHeights);
	};

	// throttled resize event for recalculating snippet height
	throttledApply = _.throttle(applySnippetHeights, 100);
	$(window).resize(throttledApply);

	// initial run on page load
	setTimeout(function(){
		applySnippetHeights();
	}, 700);

	// expose for Angular app
	window.applySnippetHeights = applySnippetHeights;



	/*
		MENU SEARCH
		========================================================
	*/

	var $desktopSearchForm = $('#menuSearchForm'),
		$desktopSearchField = $desktopSearchForm.find('input[type="text"]'),
		$desktopSearchButton = $('#menuSearchButton');


	$desktopSearchForm.submit(function(e) {
		if ($desktopSearchField.val() === '') {
			e.preventDefault();

			$('.menu-search-box').removeClass('open');
		}
	});

	$desktopSearchButton.click(function(e) {
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

	$(document).on('click', function(e) {
		// if click is anywhere outside search box, close search
		if ((!$(e.target).closest('.menu-search-box').length) &&
			($('.menu-search-box').hasClass('open'))) {

			$('.menu-search-box').removeClass('open');
		}
	});


	/*
		MOBILE SEARCH
		========================================================
	*/

	var $mobileSearchContainer = $('.mobileSearch'),
		$mobileSearchForm = $('#mobileSearchForm');

	// If the user clicks outside the search form, close it. Bound/unbound
	// when the form opens/closes.
	var mobileSearchClickDocumentHandler = function(e) {
		// check the click was outside the form
		if (!$(e.target).closest($mobileSearchContainer).length) {
			// close the form
			$('.mobileSearch .menuSearchButton').trigger('click');
		}
	};

	// open/close mobile search form
	$mobileSearchContainer.on('click', '.menuSearchButton', function(e) {
		e.preventDefault();

		// open/close search form
		$mobileSearchForm.toggleClass('open');

		// styling to contain open/closed search form
		$(this).closest('.navbar').toggleClass('search-open');

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

	// check there's a value to search for before submitting, otherwise close
	// the search form
	$mobileSearchForm.on('submit', function(e) {
		if ($(this).find('.form-control').val()) return true;

		e.preventDefault();

		// close the form
		$('.mobileSearch .menuSearchButton').trigger('click');
	});

	// if user hits escape when in search form, close it
	$('.form-control', $mobileSearchForm).keyup(function(e) {
		var key = e.keyCode || e.which;

		if (!($mobileSearchForm.hasClass('open'))) return false;

		// "esc" key code
		if (key == 27) {
			// close the form
			$('.mobileSearch .menuSearchButton').trigger('click');
		}
	});




	/*
		MODAL WINDOWS
		========================================================
	*/

	// Region Select Modal
	$('.region-select').click(function(e){
		e.preventDefault();
		$('#regionSelect').modal('toggle');
	});

	// Contact Us Modal
	$('#contactFormBtn').click(function(e){
		e.preventDefault();
		$('#contactForm').modal('toggle');
	});

	// Media Coverage Modal
	$('.mediaToggle').click(function(e){
		e.preventDefault();
		var $mediaContent = $(this).siblings('.mediaContent').html();
		//var $mediaHeading = $(this).siblings('.info').children('.title').html();
		$('#viewMedia .modal-body').html( $mediaContent );
		//$('#viewMedia .modal-header h5').html( $mediaHeading );
		$('#viewMedia').modal('toggle');
	});

	// Author Profile Modals

	var showBio = $('a[data-show-modal="bio"]'),
		loadingBio = false;

	showBio.click(function(e){
		e.preventDefault();

		if (typeof theme_js_vars.ajaxurl !== 'undefined') {

			var $link = $(this),
				$theModal = $('#generalModal'),
				appendTo = $theModal.find('#modalContent'),
				thisID = $(this).data('profile-id');

			if (loadingBio) return;
			loadingBio = true;

			// visual state to show loading
			$link.addClass('loading');

			$.ajax({
				url: theme_js_vars.ajaxurl,
				data: {
					'action':'ajax_get_profile',
					'id' : thisID
				},
				success:function(data) {
					appendTo.html(data);
					$theModal.modal('toggle');
					$link.removeClass('loading');
					loadingBio = false;
				},
				error: function(errorThrown) {
					appendTo.html('Sorry, there was an error loading the profile.');
					$theModal.modal('toggle');
					$link.removeClass('loading');
					loadingBio = false;
				}
			});

		}
	});





	/*
		HOME
		========================================================
	*/

    if ($("#feature-banner.royalSlider .rsContent").length) {
        $("#feature-banner.royalSlider").royalSlider({
            keyboardNavEnabled: true,
            loop: true,
            controlNavigation: 'bullets',
            controlsInside: true,
            arrowsNav: false,
            addActiveClass: true,
            autoPlay: {
                enabled: true,
                delay: 6000
            },
            imageScaleMode: 'none',
        });
    }

    if ($(".testimonial-slider.royalSlider .rsContent").length) {
        $(".testimonial-slider.royalSlider").royalSlider({
            keyboardNavEnabled: false,
            loop: true,
            controlNavigation: 'bullets',
            controlsInside: true,
            arrowsNav: false,
            addActiveClass: true,
            autoPlay: {
                enabled: true,
                delay: 4000
            },
            imageScaleMode: 'none',
            transitionType: 'fade'
        });
    }



	/*
		ABOUT
		========================================================
	*/

	// Our Story Slider
	// http://dimsemenov.com/plugins/royal-slider/documentation/
	$('.story-slider.royalSlider').royalSlider({
		sliderDrag: false,
		arrowsNav: false,
		autoHeight: true,
		fadeinLoadedSlide: false,
		controlNavigation: 'none',
		imageScaleMode: 'none',
		imageAlignCenter: false,
		loop: false,
		loopRewind: true,
		usePreloader: false,
		autoPlay: {
			enabled: false
		}
	});

	// custom Royal Slider navigation for Story
	$('#story .slide-nav').on('click', 'a', function(e) {
		e.preventDefault();

		// update slide
		$('.story-slider.royalSlider').royalSlider('goTo', $(this).index());

		// update button active state
		$(this).siblings().removeClass('btn-active');
		$(this).addClass('btn-active');
	});


	// Testimonial slider
	// http://dimsemenov.com/plugins/royal-slider/documentation/
	$(".quote-slider.royalSlider").royalSlider({
		sliderDrag: false,
		autoHeight: true,
		loop: true,
		controlNavigation: 'bullets',
		arrowsNav: true,
		arrowsNavAutoHide: false,
		controlsInside: false,
		addActiveClass: true,
		autoPlay: {
			enabled: true,
			delay: 4000
		},
		imageScaleMode: 'none',
		numImagesToPreload: 5,
	});



	/*
		CONTACT PAGE
		========================================================
	*/

	$('.location .expand').click(function(){
		$(this).siblings('.details').slideToggle('slow');
	});

	//search faq's from contact page
	var contactFaqSearchInput = $('.page.contact .search-box input');
	contactFaqSearchInput.typeahead({
		source: getFAQSearchItems, //reuse ajax search from faq page
		updater: onContactFAQSearchSelect
	});

	//jump to faq page on select, pass query title
	function onContactFAQSearchSelect(label) {
		document.location = '/faq?q='  + label;
	}


	/*
		BLOG & RECIPE PAGE SLIDERS
		========================================================
	*/

	$("#feature-banner.feature-banner-blog .royalSlider").royalSlider({
		keyboardNavEnabled: true,
		loop: true,
		controlNavigation: 'bullets',
		controlsInside: false,
		arrowsNav: false,
		addActiveClass: true,
		autoPlay: {
			enabled: true,
			delay: 6000
		},
		imageScaleMode: 'none',
		transitionType: 'fade'
	});

	// Shop slider
	$(".woocommerce .royalSlider").royalSlider({
		keyboardNavEnabled: true,
		loop: true,
		controlNavigation: 'bullets',
		controlsInside: false,
		arrowsNav: false,
		addActiveClass: true,
		autoPlay: {
			enabled: true,
			delay: 6000
		},
		imageScaleMode: 'none',
		transitionType: 'fade'
	});

	/*
		BLOG
		========================================================
	*/

	//blog page image only blocks need custom class added for alignment
	$('.single-post .post-body p').each(function(i){
		if ( ($(this).find('img').length) &&     // If there's an image
			(!$.trim($(this).text()).length))   // and there's no text
		{
			$(this).addClass('imgOnly');         // Add a special CSS class
		}
	});




	/*
		FAQ
		========================================================
	*/

	var faqSearchInput = $('.page.faqs .search-box input');
	if (faqSearchInput) {
		faqSearchInput.typeahead({
			source: getFAQSearchItems,
			updater: onFAQSearchSelect
		});

		//if sent query in url param, open it
		var query = new RegExp('[\?&]' + 'q' + '=([^&#]*)').exec(window.location.href);
		if (query) {
			setTimeout(function() {
				onFAQSearchSelect(decodeURIComponent(query[1]));
			}, 0);
		}
	};

	//extend jquery contains for case insensitive use in search
	$.expr[':'].containsIgnoreCase = jQuery.expr.createPseudo(function(arg) {
		return function( elem ) {
			return containsIgnoreCase(jQuery(elem).text(), arg);
		};
	});

	function containsIgnoreCase(string, arg) {
		return string.toUpperCase().indexOf(arg.toUpperCase()) >= 0;
	}

	//find header results based on search
	var faqResponseCache = null;
	var throttledFAQRequest = _.throttle(loadFAQResponse, 500, {trailing: false});
	function getFAQSearchItems(req, resp) {
		var term = req;
		if (faqResponseCache) {
			doFAQSearch(req, resp);
		} else {
			throttledFAQRequest(req, resp)
		}
	}

	function loadFAQResponse(req, resp) {
		$.ajax({
			url: theme_js_vars.ajaxurl,
			data: {
				'action':'ajax_get_faqs'
			},
			cache: true,
			success:function(data) {
				faqResponseCache = data;
				doFAQSearch(req, resp);
			},
			error: function(errorThrown) {
				resp(null);
			}
		});
	}

	function doFAQSearch(req, resp) {
		var res = [];
		_.each(faqResponseCache, function(item) {
			if (containsIgnoreCase(item.title, req)) {
				res.push(item.title);
			}
		});
		resp(res);
	}

	//jump to section on select
	function onFAQSearchSelect(label) {
		//find item from label
		var el = $('.faq-list h3:contains("' + label + '")');
		if (el) {
			//scroll position need to account for whichever header's visible
			var scrollPos = $(el).offset().top - $('#mobileNav:visible').outerHeight() - $('#topNav:visible').outerHeight();
			//open item and scroll to it
			$(el).click();
			$('html, body').animate({
				scrollTop: scrollPos
			}, 2000);
		}
		return label;
	}





	/*
		BLOG STICKY SIDEBAR
		========================================================
	*/

	function stickySidebar() {
		var sidebar 		= $('.author-wrapper');

		if ( sidebar.css('position') === 'fixed'){

			var container 		= $('.post-detail .container'),
				stopElem		= $('.post-navigation').offset().top,
				windowHeight	= $(document).height(),
				stopY 			= windowHeight - stopElem,
				ContLeft 		= container.offset().left,
				ContWidth 		= container.width(),
				sidebarHeight 	= sidebar.height(),

				// set position as per grid sizing
				colWidth 		= ContWidth / 12,
				sidebarWidth 	= colWidth * 3 - 40,
				sidebarLeft 	= (colWidth * 9) + ContLeft + 70;

			// set initial position & sizes
			sidebar.css('width', sidebarWidth + 'px');
			sidebar.css('left', sidebarLeft + 'px');

			//console.log(stopY + 'px');

			// use Bootstrap Affix to scroll with page
			sidebar.affix ({
				offset: {
					top: 156,
					bottom: function() {
						// set bottom value
						return (this.bottom = stopY)
					}
				}
			});

		} else {
			// set initial position & sizes
			sidebar.css('width', '100%');
			sidebar.css('left', 'auto');
		}
	};

	stickySidebar();
	$( window ).resize(stickySidebar);





	/*
		PRODUCT PAGES
		========================================================
	*/


	// fix position of buy now button/panel
	if ( $(".bnFixed").length != 0 ) {
		var buyNow = $(".bnFixed"),
			buyNowHeight = buyNow.innerHeight(),
			buyNowTop = buyNow.offset().top,
			buyNowY = buyNowTop + buyNowHeight;
	}

	function fixBuyNow() {

		if ( scrollY >= buyNowY - windowHeight ) {
			buyNow.addClass('affix');
			// make sure body has margin at bottom so we don't overlap elements
			$('body').css('margin-bottom', buyNowHeight);
		} else {
			buyNow.removeClass('affix');
			// remove the body margin
			$('body').css('margin-bottom', '0');
		}
	}

	// Product overview page scrolling effect with simply scroll.js
	$(".scroller").simplyScroll({
		customClass: 'vert',
		orientation: 'vertical',
		auto: true,
		anualMode: 'loop',
		frameRate: 15,
		speed: 1,
		pauseOnTouch: false
	});

	// Product detail pages quick list
	$(".quick-list li").click(function() {
		var toggle = $(this).hasClass('active');
		//close all active
		$(".quick-list li.active").removeClass('active').find('.detail').stop().slideUp();
		if (!toggle) {
			//open this one
			$(this).addClass('active').find('.detail').stop().slideDown({ duration: 500, easing: "swing" });
		}
	});

	$('a.quick-view-button').unbind('click');

	$(document).on( 'click', 'a.quick-view-button', function() {

		$.fn.prettyPhoto({
			social_tools: false,
			theme: 'pp_woocommerce pp_woocommerce_quick_view',
			opacity: 0.8,
			modal: false,
			horizontal_padding: 40,
			changepicturecallback: function() {
				$('.pp_content_container .variations_form').wc_variation_form();
				$('.pp_content_container .variations_form').trigger('wc_variation_form');
				$('.pp_content_container .variations_form .variations select').change();
				var container = $('.quick-view-content').closest('.pp_content_container');
				setTimeout(function(){
					$('.pp_content_container .variations_form').addClass("active");
					$('.pp_content_container .essb_links').addClass("active");
        		}, 400);
				
				$('body').trigger('quick-view-displayed');
			}
		});

		$.prettyPhoto.open( $(this).attr( 'href' ) );

		return false;
	});


	// Toggle ingredients lists
	$('.toggle-in').click(function(){
		var ingredientsPanel = $('#in-slide'),
			fill = $('.in-backdrop'),
			initialPosition = '-100%';

		// open it
		$('body').addClass('modal-open');
		fill.stop().fadeIn( 450 );
		ingredientsPanel.stop().animate(
			{
				"right": 0
			}, 600
		);

		// close it
		$('.in-backdrop, #in-slide .close').click(function(){
			fill.stop().delay(100).fadeOut( 400 );
			ingredientsPanel.stop().animate(
				{
					"right": initialPosition
				}, 400, function() {
					$('body').removeClass('modal-open');
				}
			);
		});

	});

	// Tooltip effect on ingredients
	$('.panel').on('show.bs.collapse', function () {
		$('.panel .in').collapse('hide');
	});



	// Better Forms of Ingredients (GGS) & The Perfect Pea (CLP) //
	// now using Slick slider

	var newCarousel 	= $('[data-carousel]');

	$.each(newCarousel, function() {

		var sliderType 	= $(this).data('carousel');
		var slideOptions = {};

		//console.log('slider:' + sliderType);

		// product page usp
		if (sliderType === 'product-usp') {

			slideOptions = {
				centerMode: true,
				centerPadding: '20%',
				slidesToShow: 1,
				adaptiveHeight: true,
				arrows: false,
				swipeToSlide: true,
				autoplay: true,
				autoplaySpeed: 2250,
				pauseOnHover: true,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							centerMode: false,
							centerPadding: '0',
							slidesToShow: 1
						}
					}
				]
			};
		}

		// shop page product thumbnails
		else if (sliderType === 'product-thumbs') {
			slideOptions = {
				slidesToShow: 4,
				arrows: false
			};
		}

		// default
		else {
			slideOptions = {};
		}

		// init slick slider with options
		$(this).slick(slideOptions);

		if (sliderType === 'product-usp') {
			$(this).slick('slickPause');
		}
	});





	/*
		GOOD GREEN STUFF
		========================================================
	*/

	// Good Green Stuff section scroll
	$('.good-green-stuff .btn-square').click(function(){
		$('html, body').animate({
			scrollTop: $( $.attr(this, 'href') ).offset().top
		}, 500);
		return false;
	});


	/**
	 * Vitamins and minerals infographic.
	 *
	 * @todo: auto-cycle to next vitamin
	 */

	var vitamins = (function() {
		// cache DOM references
		var _$bubble =	$('.vitamins__bubble'),
			_$barNuZest = $('.barNuZest'),
			_$barOther = $('.barCompet'),
			_$barDetails = _$barNuZest.find('.barDetails'),
			_$percentVal = _$barDetails.find('.percent'),
			_$moreOf = _$barDetails.find('.moreOf');

		// Private

		var _swapBubble = function(data) {
			_$bubble.find('.more').html(data['nz-pct-more'] + '% more ' + data['title']);
			_$bubble.find('.heading').html(data.heading);
			_$bubble.find('.description').html(data.description);
		};

		var _swapGraph = function(data) {
			// get existing so we can animate in new val
			var currentVal = _$percentVal.text();

			// set bar heights
			_$barNuZest
				.css("height", data['nz-bar-value'] + '%')
				.attr('data-rel-value', data['nz-bar-value']);

			_$barOther
				.css("height", data['other-bar-value'] + '%')
				.attr('data-rel-value', data['other-bar-value']);

			// update value within NuZest bar
			$({ count: currentVal }).animate({ count: data['nz-pct-more'] }, {
				duration: 600,
				step: function() {
					// increase value each step
					_$percentVal.html(Math.floor(this.count) + '%');
				},
				complete: function() {
					// ensure final value is correct
					_$percentVal.html(Math.floor(this.count) + '%');
				}
			});

			// update vitamin type comparison
			_$moreOf.html('more ' + data['title']);
		};

		// Public

		var swap = function(data) {
			_swapBubble(data);
			_swapGraph(data);
		};

		return {
			swap: swap,
		};
	})();

	// clicks on menu links, swap infographic
	$('.vitamins__menu').on('click', 'a', function(e) {
		e.preventDefault();

		var data;

		// update current link
		$(this).closest('li')
			.siblings().removeClass('active')
			.end().addClass('active');

		// swap bubble and graph content
		data = {
			'title': 			$(this).data('title'),
			'heading': 			$(this).data('heading'),
			'description': 		$(this).data('description'),
			'nz-pct-more': 		$(this).data('nz-pct-more'),
			'nz-bar-value': 	$(this).data('nz-bar-value'),
			'other-bar-value': 	$(this).data('other-bar-value'),
		};

		vitamins.swap(data);
	});

	// start on first menu link when loading page
	$('.vitamins__menu a:first').trigger('click');

	// clicks on "?" shows the bubble
	$('.vitamins .bubble-link').on('click', function(e) {
		e.preventDefault();

		$('.vitamins__bubble').toggleClass('show');
		$('.vitamins .btmBar').toggleClass('mute');
	});

	// close vitamin bubble when "x" is clicked
	$('.vitamins__bubble .close').on('click', function(e) {
		e.preventDefault();

		$('.vitamins__bubble').toggleClass('show');
		$('.vitamins .btmBar').toggleClass('mute');
	});

	/**
	 * Previous/next vitamin arrows.
	 */

	var vitaminInDirection = function(direction) {
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
	$('.vitamins .rsArrowLeft').on('click', function(e) {
		e.preventDefault();

		vitaminInDirection('left');
	});

	$('.vitamins .rsArrowRight').on('click', function(e) {
		e.preventDefault();

		vitaminInDirection('right');
	});


	/*
		REGION SELECT MAP
		========================================================
	*/

		
	$('a.map-region').click(function(){
		$('.instructions').slideUp();
		var theRegion = $(this).attr('id');
		var regionRow = $('#zone-' + theRegion);
		if ( !$(regionRow).hasClass( 'active-row' )) {
			$('.active-row').removeClass( 'active-row' ).slideUp();
			regionRow.slideDown().addClass('active-row');
		};
	});

	$('h3.m-region').click(function(){
		if ($(this).hasClass('active-region')){
			$(this).removeClass('active-region');
			$(this).next().slideUp();
		}
		else{
			$(this).addClass('active-region');
			$(this).next().slideDown();
		};
	});
		

	
	
	/*
		COOKIES
		========================================================
	*/


	function setCookie(key,val,days) {
		var expires = new Date();
		expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); //30 days
		document.cookie = key + '=' + window.escape(val) + ';expires=' + expires.toUTCString();
	}

	function getCookie(key) {
		var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
		return (keyValue) ? window.unescape(keyValue[2]) : null;
	}

	// Region select modal

	$('#regionSelect a.region').on('click', function(evt) {
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
				regionReturnModal.find('.btn-confirm').on('click', function() {
					window.location = href;
				});
				//no button, stay on site and set cookie to current region
				regionReturnModal.find('.btn-reject').on('click', function() {
					var regions = $('#regionSelect a');
					var currentRegion = _.find(regions, function(region) {
						return new RegExp($(region).attr('href')).test(loc);
					});
					if (currentRegion) {
						setCookie('nz_region', $(currentRegion).attr('id'), 30);
					}
				});
			}
		}
	}

	/**
	 * Shop
	 */

	//only run on archive page
	if ($('.post-type-archive-product.woocommerce-page')) {
		$(".variation-images").on('mouseenter', function() {
			$(this).royalSlider({
				keyboardNavEnabled: false,
				loop: true,
				controlNavigation: 'none',
				controlsInside: true,
				arrowsNav: true,
				addActiveClass: true,
				autoScaleSlider: true,
				autoScaleSliderWidth: 350,
				autoScaleSliderHeight: 350,
				imageScaleMode: 'fill',
				transitionType: 'slide',
				autoPlay: {
					enabled: true,
					delay: 1000,
					pauseOnHover: false
				}
			});
			$(this).royalSlider('startAutoPlay');
		});

		$(".variation-images").on('mouseleave', function() {
			$(this).royalSlider('stopAutoPlay');
		});
	}

	//only run these functions on wc product pages...
	if ( $('.single-product.woocommerce-page') ) {

		// swap thumbnail to main image on click

		$('.carousel--product-thumbs .carousel__slide').on('click', function(event) {
		  event.preventDefault();

		  var thumb =  $(this).find('img').attr('src');

		  $('.images__main-image img').attr('src', thumb);

		});

		//hook into wc variation price update event
		$('.single_variation_wrap').on('show_variation', function(event, variation) {
			//show variation price in place of normal price
			if (variation.price_html != '') {
				$('.summary p.price').html(variation.price_html);
			}

			//update variation description
			$('#variation_description')
				.html($('#variation-' + variation.variation_id).html())
				.appendTo('div[itemprop="offers"]');
		});

		// add styling class to size controls
		$('#pa_size').closest('.row').addClass('size');

		// rejig layout to place social links in row with buy button
		var buyButton = $('.single_add_to_cart_button');
		var locationWrapper = buyButton.parent();
		var socialLinks = $('.summary .essb_links');
		if (buyButton.length && socialLinks.length && locationWrapper.length) {
			var buyWrapper = $('<div class="row add-to-cart"></div>');
			buyButton.appendTo(buyWrapper).wrap('<div class="col-lg-5 buy-button"></div>');
			socialLinks.appendTo(buyWrapper).wrap('<div class="col-lg-7 social-links"></div>');
			buyWrapper.appendTo(locationWrapper);
		}

		// copy portions of the product summary into a mobile only block to appear
		// ABOVE the product image - which is normally the first element in the page
		// $('.summary :first-child')
	}



	// re-draw MailChimp for Wordpress field

	$('#_mc4wp_subscribe_woocommerce_checkout_field').each(function() {

		var wrapper = $(this);
		var inputField = $('input', wrapper);
		var inputID = inputField.attr('id');
		var labelField = $('label', wrapper);

		// move the input field out of the label
		// and hide the actual input
		inputField.prependTo(wrapper);
		inputField.css('visibility','hidden');

		// add the right "for" to the label
		labelField.attr('for', inputID);

		// add the checkbox class to the wrapper
		wrapper.addClass('checkbox');

	});

});


//quantity stepper functions
function incQuantityStepper(name) {
	var input = jQuery("[name='" + name +"']");
	if (input) {
		var max = input.attr('max') || 9999;
		var step = input.attr('step') || 1;
		var val = input.val() || 0;
		var newVal = +val + +step;
		if (newVal <= max) {
			input.attr('value',newVal);
			jQuery(".woocommerce-cart input[name='update_cart']").prop('disabled',false);
		}
	}
}
function decQuantityStepper(name) {
	var input = jQuery("[name='" + name +"']");
	if (input) {
		var min = input.attr('min') || 0;
		var step = input.attr('step') || 1;
		var val = input.val() || 0;
		var newVal = +val - +step;
		if (newVal >= min) {
                        input.attr('value',newVal);
                        jQuery(".woocommerce-cart input[name='update_cart']").prop('disabled',false);
		}
	}
}
