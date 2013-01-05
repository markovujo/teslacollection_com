$(function() {
	$('#search_results').tablesorter({
		widgets: ['zebra']
	});
	
	$('#articles_search_results').hide();
	
	$('#search_submit').click(function() {
		var formData = $('#article_search_form').serialize();
		
		$.ajax({
            type: 'POST',
            url: '/articles/search',
            data: formData,
            dataType: 'json',
            success: function(data) {
               $("#search_results").find("tr:gt(0)").remove();
               
               var i=0;
               var html_rows = '';
               
			   $.each(data.articles, function(index, article) {
				   var subjects = Array();
				   for (var i = 0; i < article['Subject'].length; i++) {
					   subjects.push(article['Subject'][i]['name']);
				   }
				   var subject_text = subjects.join(', ');
				   
				   var article_page_text = '';
				   for (var i = 0; i < article['ArticlePage'].length; i++) {
					   var link = '<a href="article_pages/view/' + article['ArticlePage'][i]['id'] + '" ' +
				   		'class="tooltip_selector" ' +
				   		'title="' + article['ArticlePage'][i]['title'] + '" ' +
				   		'data-geo="" ' +
						'data-id= "' + article['ArticlePage'][i]['id'] + '">' + article['ArticlePage'][i]['filename'] + '</a><br/>';
					   article_page_text += link;
				   }
				   
				   html_rows += "<tr>" +
				   		"<td><a href='' style='color : #d82323'>" + article['Article']['title'] + "</a></td>" +
				   		"<td>" + article['Article']['volume'] + "</td>" +
				   		"<td>" + article['Article']['page'] + "</td>" +
				   		"<td>" + article['Publication']['name'] + "</td>" +
				   		"<td>" + article['Author']['name'] + "</td>" +
				   		"<td>" + article['Article']['date'] + "</td>" +
				   		"<td>" + subjects + "</td>" +
				   		"<td>" + article['Article']['range_text'] + "</td>" +
				   		"<td>" + article_page_text + "</td>" +
				   	"</tr>";
			   });

               $("#search_results").append(html_rows); 
               $("#search_results").trigger("update");
               $("#search_results").trigger("applyWidgets");
               
               $('#article_result_count').text(data.articles.length);
               $('#articles_search_results').show();
               
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
           		position: { my: "right-15 top-100", at: "left top", collision: "flip" }
           	});
            },
            error: function(message){
                alert(message);
            }
        });
		
		return false;
	});
	
	$('#search_reset').click(function() {
		$("#publication_selection option:selected").removeAttr("selected");
		$("#author_selection option:selected").removeAttr("selected");
		$("#year_selection option:selected").removeAttr("selected");
		$("#subject_selection option:selected").removeAttr("selected");
		$("#search_text").val('');
		$('#articles_search_results').hide();
	});
});