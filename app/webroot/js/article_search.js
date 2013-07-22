$(function() {
	$('#search_results').tablesorter({
		widgets: ['zebra']
	});
	
	$('#articles_search_results').hide();
	$('#article_result_ajax').hide();
	
	$("#title_text").autocomplete({
      source: function( request, response ) {
    	var data = {
    		'data' : {
    			'ArticleSearch' : {
	    			'title_text' : request.term,
	    			'limit' : 10
	    		}
    		}
    	};
    	
        $.ajax({
          type: 'POST',
          url: document.URL + 'articles/search',
          dataType: "json",
          data: data,
          success: function( data ) {
            response( $.map( data.articles, function( item ) {
              return {
                label: item.Article.title,
                value: item.Article.title
              }
            }));
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
    	 $('#title_text').val(ui.item.label);
    	 $('#search_submit').click();
      },
      open: function() {
        
      },
      close: function() {
    	 
      }
    });
	
	$('#search_submit').click(function() {
		var formData = $('#article_search_form').serialize();
	
		$('#article_result_ajax').show();
		$.ajax({
            type: 'POST',
            url: document.URL + '/articles/search',
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
				   for (var i = 0; i < article['Page'].length; i++) {
					   var link = '<a href="' + document.URL  + '/article_pages/view/' + article['Page'][i]['id'] + '" ' +
				   		'class="tooltip_selector" ' +
				   		'title="' + article['Article']['title'] + ' - ' + i + '" ' +
				   		'data-geo="" ' +
						'data-id= "' + article['Page'][i]['id'] + '">' + article['Page'][i]['filename'] + '</a><br /><br />';
					   article_page_text += link;
				   }
				   
				   html_rows += "<tr>" +
				   		"<td><a href='" + document.URL + "articles/view/" + article['Article']['id'] + "' style='color : #d82323'>" + article['Article']['title'] + "</a></td>" +
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
               $('#articles_search_results').show();
               $('html,body').animate({scrollTop: $('#article_result_count').offset().top});
               
               $("#search_results").trigger("update");
               $("#search_results").trigger("applyWidgets");
               
               $('#article_result_count').text(data.articles.length);
               $('#article_result_ajax').hide();
               
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
           				return '<img class="tooltip_thumbnail" alt="' + title + '" src="' + document.URL + '/article_pages/view_thumbnail/' + id + '">';
           			}
           		},
           		position: { my: "right-15 top-100", at: "left top", collision: "flip" }
           	});
            },
            error: function(message){
                console.log(message);
            }
        });
		
		return false;
	});
	
	$('#search_reset').click(function() {
		$("#publication_selection option:selected").removeAttr("selected");
		$("#author_selection option:selected").removeAttr("selected");
		$("#year_selection option:selected").removeAttr("selected");
		$("#subject_selection option:selected").removeAttr("selected");
		$("#title_text").val('');
		$("#search_text").val('');
		$('#articles_search_results').hide();
	});
	
	/*
	$("#tutorial-modal").dialog({
      width: 1000,
      height: 647,
      modal: true,
      autoOpen: false
    });
	
	$('#search_tutorial').click(function() {
		$("#tutorial-modal").dialog( "open" );
	});
	
    $('#slides').slidesjs({
        width: 850,
        height: 647
    });
    */
});
