	/* ===== FAQ SECTION ===== */
    $('.contact .search-box input').typeahead({
    	source: getFAQSearchItems, //reuse ajax search from faq page
    	updater: onContactFAQSearchSelect
    });

    //jump to faq page on select, pass query title
    function onContactFAQSearchSelect(label) {
    	document.location = '/faqs?q='  + label;
    }
	
    if ($('.search-box input')) {
    	$('.search-box input').typeahead({
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
    }
    
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
		var ajaxurl = document.location.origin + "/wp-admin/admin-ajax.php?action=search_faq";
        $.ajax({
            url: theme_js_vars.ajaxurl,
            data: {
                'action': 'ajax_get_faqs'
            },
            cache: true,
            success: function (data) {
                faqResponseCache = data;
                doFAQSearch(req, resp);
            },
            error: function (errorThrown) {
                resp(null);
            }
        });
    }

    function doFAQSearch(req, resp) {
        var res = [];
        _.each(faqResponseCache, function (item) {
            if (containsIgnoreCase(item.title, req)) {
                res.push(item.title);
            }
        });
        resp(res);
    }

    //jump to section on select
    function onFAQSearchSelect(label) {
        //find item from label
        var el = $('.faq-list h4:contains("' + label + '")');
        if (el) {
			if($('#faqs_products_cat').length > 0){		
				$('#faq_content').html("<h4>" +label+ "</h4>" + $(el).next().text());
			}
			else{
				//scroll position need to account for whichever header's visible
				var scrollPos = $(el).offset().top - $('#mobileNav:visible').outerHeight() - $('#topNav:visible').outerHeight();
				//open item and scroll to it
				$(el).click();
				$('html, body').animate({
					scrollTop: scrollPos
				}, 2000);
			}
        }
        return label;
    }
	/* ===== FAQ SECTION END===== */