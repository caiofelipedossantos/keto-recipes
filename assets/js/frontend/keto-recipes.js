(function( $ ) {
	'use strict';
	
	$('.keto-browse-select').click(function(e){
	    $(this).toggleClass('keto-active');
	    e.stopPropagation();
	});
	
	$('.keto-browse-select-block').click(function(e){
	    e.stopPropagation();
	});
	
	$('#search-input').click(function(e) { 
      e.stopPropagation();
    })
	
	$(document).click(function(e) {
	    $('.keto-browse-select').removeClass('keto-active');
	    e.stopPropagation();
	});
	
	$('.keto-browse-search-button').click(function(e){
	    $('.keto-recipe-form').submit();
	});
	
	$(document).on('submit', '.keto-recipe-form', function (e) {
	    e.preventDefault();
        var $form = $(this);
        var $input = $form.find('input[name="keto_search_s"]');
        var query = $input.val();
        var categories = [];
        var cuisines = [];
        var flags = [];
        var orderby = $form.find('.keto-sortby-select').val();
        var $content = $('#keto-recipe-container');
        
        $('input:checkbox[name="categories[]"]:checked').each(function(){
            categories.push($(this).val());
        });
        
        $('input:checkbox[name="cuisines[]"]:checked').each(function(){
            cuisines.push($(this).val());
        });
        
        $('input:checkbox[name="flags[]"]:checked').each(function(){
            flags.push($(this).val());
        });
    
        $.ajax({
            type: 'post',
            url: ketoAjax.ajaxurl,
            data: {
                action: 'keto_load_search_results',
                query: query,
                categories: categories,
                cuisines: cuisines,
                flags: flags,
                orderBy: orderby
            },
            beforeSend: function () {
                $input.prop('disabled', true);
                $content.addClass('loading');
            },
            success: function (response) {
                $input.prop('disabled', false);
                $content.removeClass('loading');
                $content.html(response);
            }
        });
    
        return false;
    });
    
})( jQuery );
