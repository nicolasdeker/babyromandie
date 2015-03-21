( function($) {
    var searchTimer;
    $( '#content_search' ).keypress( function(e) {
        var query = $(this).val();

        if ( 13 == e.which ) {
            slider_ajax_search( query );
            return false;
        }

        if ( searchTimer )
        	clearTimeout( searchTimer );

        searchTimer = setTimeout( function(){
            slider_ajax_search( query );
        }, 400 );
    } );

    /**
     * Search posts and return relevant matches
     */
    function slider_ajax_search( query ) {
        var spinner = $( '#slider-spinner' ),
		    nonce = $( '#slider_nonce' ).val(),
            data = {
				action: 'search_content',
				query: query,
				nonce: nonce
			},
			disabled = $( '#add_to_slider, #slider-select' );

        spinner.show();
        $.post( ajaxurl, data, function( response ) {
            if( response ) {
                $( '#content_search_results' ).html( response.data );
                if ( response.success )
                	disabled.removeAttr( 'disabled' );
                else
                    disabled.attr( 'disabled', 'disabled' );
            } else {
                alert( response.data );
            }
            spinner.hide();
        }, 'json' );
    }

    /**
     * Add slide to slider
     */
	$( '#slider-form' ).submit( function(e) {
		e.preventDefault();
		var el = $(this),
			spinner = $( '#slider-spinner' ),
		    count = el.data( 'count' ),
		    nonce = $( '#slider_nonce' ).val(),
		    post_id = $( '#search-results option:selected' ).val(),
			data = {
				action: 'add_delete_slide',
				post_id: post_id,
	            a_or_d: 'add',
				nonce: nonce,
				count: count,
			};

		if ( ! post_id ) {
		 	alert( 'Please select a Post/Page.' );
		 	return false;
		}

        spinner.show();
		$.post( ajaxurl, data, function( response ) {
            spinner.hide();
			if ( response.success ) {
                $( '#admin-slides' ).append( response.data );
                el
                	.removeData( 'count' )
                	.attr( 'data-count', count + 1 );
			} else {
	            alert( response.data );
	        }
		}, 'json' );
	} );

    var file_frame;
	$( '#admin-slides' )
		.on( 'click', '.delete-slide', function(e) {
			e.preventDefault();
			var el = $(this),
				spinner = $( '#slider-spinner' ),
				post_id = el.data( 'slide' ),
				nonce = $( '#slider_nonce' ).val(),
				data = {
					action: 'add_delete_slide',
					a_or_d: 'delete',
					post_id: post_id,
					nonce: nonce
				};

			spinner.show();
			$.post( ajaxurl, data, function( response ) {
				$( '#slide_' + post_id ).remove();
				reset_slides();
				spinner.hide();
			} );
		} )
		.on( 'click', '.edit-slide', function(e) {
			e.preventDefault();
			var el = $(this),
				post_id = el.data( 'slide' ),
				slide = el.parents( '.slide' ),
				title = slide.find( '.item-title' ).text(),
				excerpt = slide.find( '.item-excerpt' ).text(),
				link = slide.find( '.item-link' ).text(),
				button = slide.find( '.item-button' ).text(),
				edit_slide;

			edit_slide = '<div id="edit_' + post_id + '" class="slide editing">' +
				'<strong>Title:</strong> <input type="text" size="40" name="title" value="' + title + '" /><br />' +
				'<strong>Text:</strong> <textarea type="text" name="excerpt" rows="5" cols="">' + excerpt + '</textarea><br />' +
				'<strong>Link:</strong> <input type="text" size="40" name="link" value="' + link + '" /><br />' +
				'<strong>Button:</strong> <input type="text" size="40" name="button" value="' + button + '" /><br />' +
				'<div class="buttons"><button id="cancel" class="button" data-slide="' + post_id + '">Cancel</button><button id="save_changes" class="button button-primary" data-slide="' + post_id + '">Save Changes</button></div>' +
				'</div>';
			$( '#slide_' + post_id )
				.hide()
				.after( edit_slide );
		} )
		.on( 'click', '#save_changes', function() {
			var slide_id = $(this).data( 'slide' );
				spinner = $( '#slider-spinner' ),
				nonce = $( '#slider_nonce' ).val(),
				edit_slide = $( '#edit_' + slide_id ),
				new_title = edit_slide.find( 'input[name="title"]' ).val(),
				new_excerpt = edit_slide.find( 'textarea[name="excerpt"]' ).val(),
				new_link = edit_slide.find( 'input[name="link"]' ).val(),
				new_button = edit_slide.find( 'input[name="button"]' ).val(),
				data = {
					action: 'edit_slide',
					a_or_d: 'edit',
					slide_id: slide_id,
					new_title: new_title,
					new_excerpt: new_excerpt,
					new_link: new_link,
					new_button: new_button,
					nonce: nonce
				};

			spinner.show();
			$.post( ajaxurl, data, function( response ) {
				if ( response.success ) {
					$( '#slide_' + slide_id ).replaceWith( response.data );
					edit_slide.remove();
					spinner.hide();
				}
			}, 'json' );
		} )
		.on( 'click', '#cancel', function() {
			var slide = $(this).data( 'slide' );
			$( '#slide_' + slide ).show();
			$( '#edit_' + slide ).remove();
		} )
		.sortable( {
			handle: '.icon',
			placeholder: "sortable-placeholder",
			update: function( event, ui ) {
				var el = $(this),
					slide_order = el.sortable( 'toArray' ),
					spinner = $( '#slider-spinner' ),
					nonce = $( '#slider_nonce' ).val(),
					data = {
						action: 'slide_order',
						slide_order: slide_order,
						nonce: nonce
					};

				spinner.show();
				$.post( ajaxurl, data, function( response ) {
					reset_slides();
					spinner.hide();
				} );
			},
		} );

	/**
	 * Reset the slide number after reordering or deleting
	 */
	function reset_slides() {
		var count = 0,
			id;
		$( '#admin-slides' ).find( '.slide' ).each( function() {
			count = ( 0 <= $(this).attr( 'id' ).indexOf( 'edit' ) ) ? count - 1 : count;
			id = ( 0 <= $(this).attr( 'id' ).indexOf( 'edit' ) ) ? 'edit_' : 'slide_';
			$(this)
				.attr( 'id', id + count )
				.find( '.edit-slide, .delete-slide, .buttons button' )
					.removeData( 'slide' )
					.attr( 'data-slide', count );
			count++;
		} );
	}
} )(jQuery);