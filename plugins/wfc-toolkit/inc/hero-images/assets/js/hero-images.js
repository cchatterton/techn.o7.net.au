/**
 * Load media uploader on pages with our custom metabox
 */
 jQuery(document).ready(function($){

	'use strict';

	$('#wfc-heroimages-metabox h2').prepend('<img id="wfc_logo" src="'+wfc_heroimages_param.logourl+'">');

	// Instantiates the variable that holds the media library frame.
	var metaImageFrame;

	// Runs when the media button is clicked.
	$( 'body' ).click(function(e) {

		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if ( !btn || !$( btn ).attr( 'data-media-uploader-target' ) ) return;

		// Get the field target
		var field = $( btn ).data( 'media-uploader-target' );

		// Prevents the default action from occuring.
		e.preventDefault();

		// Sets up the media library frame
		metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
			title: meta_image.title,
			button: { text:  'Use this file' },
		});

		// Runs when an image is selected.
		metaImageFrame.on('select', function() {

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

			// Sends the attachment URL to our custom image input field.
			$(field).val(media_attachment.url);
			$(field + '-img').attr( 'src', media_attachment.url);
			

			var imageid = field.replace("#", "");
			setTimeout(function(){ 
				var theImage = document.getElementById(imageid + '-img');
				var realSize = realImgDimension(theImage);

				$(field + '-width').val(realSize.naturalWidth);
				$(field + '-height').val(realSize.naturalHeight);
				
				setImgDimensioninfo(imageid);	
				console.log('My width is: ', realSize.naturalWidth);
				console.log('My height is: ', realSize.naturalHeight);
			}, 500);
			


		});

		// Opens the media library frame.
		metaImageFrame.open();

	});

	// Runs when the media button is clicked.
	$( 'body' ).click(function(e) {
		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if ( !btn || !$( btn ).attr( 'data-media-preview-target' ) ) return;

		// Get the field target
		var field = $( btn ).data( 'media-preview-target' );

		// Prevents the default action from occuring.
		e.preventDefault();

		$(field + '-sub-cont').css('animation-name','showEnter');
        $(field).css('display','flex');

	});	


	$( 'div' ).click(function(e) {
		var target_id = $(this).attr('id');
		var isprevcont = $(this).attr( 'preview-cont' );
		if (isprevcont == 'true') {

			$('#' + $(this).attr('id') + '-sub-cont').css('animation-name','hideExit');
            setTimeout(function(){ 
                $('#'+target_id).css('display','none');
            }, 500);
		}
	});		


	function realImgDimension(img) {
	    var i = new Image();
	    i.src = img.src;
	    return {
	        naturalWidth: i.width, 
	        naturalHeight: i.height
	    };
	}


	setTimeout(function(){ setImgDimensioninfo('wfc-heroimages-small'); }, 300);	
	setTimeout(function(){ setImgDimensioninfo('wfc-heroimages-medium'); }, 600);
	setTimeout(function(){ setImgDimensioninfo('wfc-heroimages-large'); }, 900);
	function setImgDimensioninfo(elem_id){
		var dimension_width = $('#' + elem_id + '-width').val();
		var dimension_height = $('#' + elem_id + '-height').val();

		if (dimension_width == '') {
			dimension_width = '0';
		}

		if (dimension_height == '') {
			dimension_height = '0';
		}

		if(elem_id.indexOf('small') != -1){
			$('#' + elem_id + '-label').text('Small Devices (' + dimension_width + ' x ' + dimension_height + ')');
		}

		if(elem_id.indexOf('medium') != -1){
			$('#' + elem_id + '-label').text('Medium Devices (' + dimension_width + ' x ' + dimension_height + ')');
		}

		if(elem_id.indexOf('large') != -1){
			$('#' + elem_id + '-label').text('Large Devices (' + dimension_width + ' x ' + dimension_height + ')');
		}
	}



	// Runs when the media button is clicked.
	$( 'body' ).click(function(e) {
		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if ( !btn || !$( btn ).attr( 'data-media-cancel-target' ) ) return;

		// Get the field target
		var field = $( btn ).data( 'media-cancel-target' );

		// Prevents the default action from occuring.
		e.preventDefault();

		$(field).val('');
		$(field+'-width').val('');
		$(field+'-height').val('');

		var imageid = field.replace("#", "");
		setImgDimensioninfo(imageid);
	});	
	
	$('.wfc-previewmedia-btn').on('click', function () {
		$('.edit-post-sidebar > .components-panel').addClass("preview-cont-index");
	});
	
	$('.wfc-heroimages-preview-main-cont').on('click', function() {
		
		setTimeout(function(){ 
			$('.edit-post-sidebar > .components-panel').removeClass("preview-cont-index");
		}, 500);
		
	});
	
	function adaptive_image_toggle() {
		var adaptive = $('input[name="wfc_adaptive_image"]');
		if (  adaptive.is(':checked') ) {
			$('.adaptive-image-container').show();
		} else {
			$('.adaptive-image-container').hide();
		}
	}
	adaptive_image_toggle();
	
	function hero_type_toggle() {
		var hero_type = $('select[name="wfc_hero_type"]');
		var value = hero_type.find(":selected").val();
		if( value == 'hero-w-cta') {
			$('.with-cta-wrapper').show();     
		} else {
			$('.with-cta-wrapper').hide(); 
		}
	}
	hero_type_toggle();
	
	$('input[name="wfc_adaptive_image"]').on('click', adaptive_image_toggle );
	$('select[name="wfc_hero_type"]').on('change', hero_type_toggle );
	
	

});