/**
 * TFS js
 *
 * contains the core functionalities to be used
 * inside TFS
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance! 
 */
jQuery(document).ready(function($){

  	//Color picker
  	$('.tfs-color').wpColorPicker();
	
	var $group = $('.group'),
		$navtabs = $('.nav-tab-wrapper a'),
		active_tab = '';

	// Hides all the .group sections to start
	$group.hide();

	// Find if a selected tab is saved in localStorage
	if ( typeof(localStorage) != 'undefined' ) {
		active_tab = localStorage.getItem('active_tab');
	}

	// If active tab is saved and exists, load it's .group
	if ( active_tab != '' && $(active_tab).length ) {
		$(active_tab).fadeIn();
		$(active_tab + '-tab').addClass('nav-tab-active');
	} else {
		$('.group:first').fadeIn();
		$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
	}

	// Bind tabs clicks
	$navtabs.click(function(e) {

		e.preventDefault();

		// Remove active class from all tabs
		$navtabs.removeClass('nav-tab-active');

		$(this).addClass('nav-tab-active').blur();

		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem('active_tab', $(this).attr('href') );
		}

		var selected = $(this).attr('href');

		$group.hide();
		$(selected).fadeIn();

	});

	/** AJAX Save Options */
	$('#tfs-save').live('click',function() {
		var nonce = $('#security').val();
		$('.ajax-loading-img-bottom').fadeIn();
		
		//get serialized data from all our option fields			
		var serializedReturn = $('#tfs-form :input[name][name!="security"][name!="tfs-reset"]').serialize();
		var data = {
			type: 'save',
			action: 'tfs_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};
					
		$.post(ajaxurl, data, function(response) {
			var success = $('#msg-success');
			var fail = $('#msg-fail');
			var loading = $('.ajax-loading-img-bottom');
			loading.fadeOut();  
			if ( response == 1 ) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
		});
		return false; 
	});   
	
	
	/* AJAX Options Reset */	
	$('#tfs-reset').click(function() {
		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");
		
		//ajax reset
		if ( answer ){
			var nonce = $('#security').val();
			$('.ajax-loading-img-bottom').fadeIn();
							
			var data = {
				type: 'reset',
				action: 'tfs_ajax_post_action',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
				var success = $('#msg-success');
				var fail = $('#msg-fail');
				var loading = $('.ajax-loading-img-bottom');
				loading.fadeOut();  
							
				if ( response == 1 ) {
					window.setTimeout(function(){
						location.reload(true);                        
					}, 2000);
					success.fadeIn();

				} else { 
					fail.fadeIn();
				}
			});
		}
		return false;
	});

	// /**
	//   * Media Uploader
	//   * Dependencies 	 : jquery, wp media uploader
	//   * Feature added by : Smartik - http://smartik.ws/
	//   * Date 			 : 05.28.2013
	//   */
	function tfs_add_file( event, selector ) {
	
		var upload = $(".uploaded-file"), frame;
		var $el = $(this);

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),

			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: $el.data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: false
			}
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			frame.close();
			selector.find('.upload').val(attachment.attributes.url);
			if ( attachment.attributes.type == 'image' ) {
				selector.find('.screenshot').empty().hide().append('<img class="tfs-option-image" src="' + attachment.attributes.url + '">').slideDown('fast');
			}
			selector.find('.media_upload_button').unbind();
			selector.find('.remove-image').show().removeClass('hide');//show "Remove" button
			selector.find('.tfs-background-properties').slideDown();
			tfs_file_bindings();
		});

		// Finally, open the modal.
		frame.open();
	}
    
	function tfs_remove_file(selector) {
		selector.find('.remove-image').hide().addClass('hide');//hide "Remove" button
		selector.find('.upload').val('');
		selector.find('.tfs-background-properties').hide();
		selector.find('.screenshot').slideUp();
		selector.find('.remove-file').unbind();
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( $('.section-upload .upload-notice').length > 0 ) {
			$('.media_upload_button').remove();
		}
		tfs_file_bindings();
	}
	
	function tfs_file_bindings() {
		$('.remove-image, .remove-file').on('click', function() {
			tfs_remove_file( $(this).parents('.section-upload, .section-media, .slide_body') );
        });
        
        $('.media_upload_button').unbind('click').click( function( event ) {
        	tfs_add_file(event, $(this).parents('.section-upload, .section-media, .slide_body'));
        });
    }
    
    tfs_file_bindings();

}); //end doc ready