$(function() {
	$(".tooltip_selector").tooltip({
		items: "img, [data-geo], [title]",
		content: function() {
			var element = $( this );
			
			title = '';
			if ( element.is( "[title]" ) ) {
				title = element.attr( "title" );
			}
			
			if ( element.is( "[data-id]" ) ) {
				var id = element.data('id');
				return '<img class="tooltip_thumbnail" alt="' + title + '" src="/article_pages/view_thumbnail/' + id + '">';
			}
		},
		position: { my: "right-15 center", at: "left bottom" }
	});
	
	//$('#search_results').tablesorter().tablesorterPager({container: $("#pager")}); 
	$('#search_results').tablesorter();
	
	$('#search_submit').click(function() {
		var data = $('#article_search_form').serialize();
		console.dir(data);
		$.ajax("/articles/search", function(data) {
		   console.log(data);
		});
		return false;
	});
	
	$('#search_reset').click(function() {
		$("#publication_selection option:selected").removeAttr("selected");
		$("#author_selection option:selected").removeAttr("selected");
		$("#year_selection option:selected").removeAttr("selected");
		$("#subject_selection option:selected").removeAttr("selected");
		$("#search_text").val('');
	});
});