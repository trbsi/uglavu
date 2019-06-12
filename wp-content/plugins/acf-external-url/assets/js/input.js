(function($){
	
	
	/**
	*  initialize_field
	*
	*  This function will initialize the $field.
	*
	*  @date	30/11/17
	*  @since	5.6.5
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function initialize_field( $field ) {
		$field.on('change', function() {
			setTimeout(function () {
			    var url = $('#external_url').val();
			    console.log(url);
			    getOgTags(url);
			}, 100);

		});		
	}
	
	function getOgTags(url)
	{
		$('#og_spinner').show();

		$.ajax({
			url : "/wp-admin/admin-ajax.php",
			type: "POST",
			data : {external_url: url, action: 'scrape_fb_og_tags'},
			success: function(response, textStatus, jqXHR)
			{
				if (response.success !== undefined && false === response.success) {
					alert(response.data.message);
					$('#og_image').prop('src', '');
					$('#og_url').text('');
					$('#external_url').val('');
				} else {
					response = JSON.parse(response);
					console.log(response);
					wp.data.dispatch( 'core/editor' ).editPost( { title: response['og:title'] } );

					//set to inputs
					$('#og_tags_title_input').val(response['og:title']);
					$('#og_tags_image_input').val(response['og:image']);
					$('#og_tags_url_input').val(response['og:url']);

					//set for preview
					$('#og_image').prop('src', response['og:image']);
					$('#og_url').prop('href', response['og:url']);
					$('#og_url').text(response['og:title']);
					$('#fb_og').show();
					$('.editor-post-title__input').text(response['og:title']);
				}
				$('#og_spinner').hide();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR);
				$('#og_spinner').hide();
			}
		});
	}
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  ready & append (ACF5)
		*
		*  These two events are called when a field element is ready for initizliation.
		*  - ready: on page load similar to $(document).ready()
		*  - append: on new DOM elements appended via repeater field or other AJAX calls
		*
		*  @param	n/a
		*  @return	n/a
		*/
		
		acf.add_action('ready_field/type=external_url', initialize_field);
		acf.add_action('append_field/type=external_url', initialize_field);
		
		
	} else {
		
		/*
		*  acf/setup_fields (ACF4)
		*
		*  These single event is called when a field element is ready for initizliation.
		*
		*  @param	event		an event object. This can be ignored
		*  @param	element		An element which contains the new HTML
		*  @return	n/a
		*/
		
		$(document).on('acf/setup_fields', function(e, postbox){
			
			// find all relevant fields
			$(postbox).find('.field[data-field_type="external_url"]').each(function(){
				
				// initialize
				initialize_field( $(this) );
				
			});
		
		});
	
	}	

})(jQuery);
