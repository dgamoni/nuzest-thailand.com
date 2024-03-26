"use strict";
(function ($, config) {

    function loadFaqs(query) {
		var ajax_url = document.location.origin + "/wp-admin/admin-ajax.php?action=search_faq";
        $.post(ajax_url, query).success(function (result) {
            $('#faq_content').html(result);
            //applySnippetHeights();
        });
    }

    $(document).ready(function () {
        var searchParams = {
            taxonomies: {}
        };
		
		if($('#faqs_products_cat').length > 0){	
			$('.main-topic').css('display', 'none');
		}
		else{
			$('#faq_content').css('display', 'none');
		}
		
        function updateSearchTaxonomies(type, selectedCats) {
            selectedCats.each(function () {
				searchParams['taxonomies'][type] = [];
                searchParams['taxonomies'][type].push($(this).val());	
            });
        }

       $('#faqs_products_cat input[type=radio]').on('change',function () {
            // Get master category
            var taxonomyType = $(this).data('taxonomy-type');
            // get selected categories under this taxonomy
            var selectedCats = $('input[data-taxonomy-type=' + taxonomyType + ']:checked');
            //updateSelectedCatPrompt(selectedCats, cat, taxonomyType);
            updateSearchTaxonomies(taxonomyType, selectedCats);
			
            loadFaqs(searchParams);
        });
    });

})(jQuery, window.ajax_object);
