"use strict";
(function ($, config) {

    function loadBlog(query) {
        $('#searchIcon').hide();
        $('#loadingProgress').show();
        $('#loadingContent').show();

        $('#blog-load-area .content').html("");
		var ajax_url = document.location.origin + "/wp-admin/admin-ajax.php?action=search_blog";
        $.post(ajax_url, query).success(function (result) {
			console.log(query);
            $('#blog-load-area .content').html(result);
            applySnippetHeights();
        }).always(function () {
            $('#searchIcon').show();
            $('#loadingProgress').hide();
            $('#loadingContent').hide();
        });
    }

    $(document).ready(function () {
		var str = $( "#posts_num" ).text();
        var keywordTrigger;

        var searchParams = {
            url: $('.permalink-value').val(),
            keyword: "",
            order:"",
			perpage: str,
            taxonomies: {}
        };

        $(window).load(function(){

            $('#searchIcon').show();
            $('#loadingProgress').hide();
            $('#loadingContent').hide();
            applySnippetHeights();

        });

        function updateSearchTaxonomies(type, selectedCats) {
            searchParams['taxonomies'][type] = [];
            selectedCats.each(function () {
                searchParams['taxonomies'][type].push($(this).val());
            });
        }

        function updateSelectedCatPrompt(selectedCats, cat, taxonomy) {
            var prompt = '';
            if (selectedCats.length === 1) {
                prompt = $('label[for=' + cat + ']').html();
            } else if (selectedCats.length > 1) {
                prompt = 'Multiple';
            }else{
                prompt = $('#selected-' + taxonomy).data("default-text");
            }

            $('#selected-' + taxonomy).html(prompt);
        }

        $('.blog-search-inputs input[type=checkbox]').on('change',function () {
            // Get master category
            var taxonomyType = $(this).data('taxonomy-type');
            // Get selected category
            var cat = $(this).val();
            // get selected categories under this taxonomy
            var selectedCats = $('input[data-taxonomy-type=' + taxonomyType + ']:checked');
            //
            updateSelectedCatPrompt(selectedCats, cat, taxonomyType);
            updateSearchTaxonomies(taxonomyType, selectedCats);
            loadBlog(searchParams);
        });

        $('.blog-search-inputs input[type=radio]').on('change',function () {
            // Get master category
            var taxonomyType = $(this).attr('name');
            // Get selected category
            var order = $(this).attr('id');
            // get selected categories under this taxonomy
            var selectedCats = [order];
            //
            updateSelectedCatPrompt(selectedCats, order, taxonomyType);
            searchParams.order = $(this).val();
            loadBlog(searchParams);
        });

        $('.blog-search-inputs input').keyup(function () {
            if (keywordTrigger) {
                clearTimeout(keywordTrigger);
            }
            var el = $(this);
            keywordTrigger = setTimeout(function () {
                searchParams.keyword = el.val();
                loadBlog(searchParams);
            }, 750);
        });

        $('#blog').on('click', '.page-numbers', function (e) {
            e.preventDefault();
            e.stopPropagation();

            searchParams.page = $(this).attr('href').replace($('.permalink-value').val(), "").replace('?paged=', "").replace('&action=search_blog', "");

			loadBlog(searchParams);
			applySnippetHeights();
			$("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    });

})(jQuery, window.ajax_object);
