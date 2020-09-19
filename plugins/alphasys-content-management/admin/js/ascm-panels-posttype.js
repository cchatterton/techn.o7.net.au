jQuery(document).ready(function($){

    // Video Embed Code
    var ascm_panels_video_videoembedcode = $(".ascm-panels-video-videoembedcode")[0];
    var ascmpanels_video_videoembedcode = CodeMirror.fromTextArea(ascm_panels_video_videoembedcode, {
        lineNumbers : true,
        mode : "xml",
        htmlMode: true,
        theme: "darcula"
    });
    ascmpanels_video_videoembedcode.save();
    setTimeout(function() {
        ascmpanels_video_videoembedcode.refresh();
    },100);


    // Custom CSS Tab
    var ascm_panels_csscode = $(".ascm-panels-csscode")[0];
    var ascmpanelscsscode = CodeMirror.fromTextArea(ascm_panels_csscode, {
        lineNumbers : true,
        mode: "css",
        theme: "darcula"
    });
    ascmpanelscsscode.save();
    setTimeout(function() {
        ascmpanelscsscode.refresh();
    },100);


    // JS functionality for accordian
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            var links = this.el.find('.ascm-panels-article-title');
            links.on('click', {
                el: this.el,
                multiple: this.multiple
            }, this.dropdown)
        }

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            $this = $(this),
                    $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('ascm-panels-open');

            if (!e.data.multiple) {
                $el.find('.ascm-panels-accordion-content').not($next).slideUp().parent().removeClass('ascm-panels-open');
            };
        }
        var accordion = new Accordion($('.ascm-panels-accordion-container'), false);

        setTimeout(function() {
            $('.ascm-panels-accordion-content').each(function () {
                $(this).css('display', 'none');
            });
        },200);

    });

    // JS functionality for range slider
    $('.ascm-rangeslider').each(function(){
        var append_char = $(this).attr('append-char');
        if (typeof append_char == typeof undefined || append_char == false) {
            append_char = '';
        }

        var rangeslider = $(this).find('input[type=range]');
        $('#'+rangeslider.attr('id')+'-rangeslider-info').text(rangeslider.val() + append_char);
        rangeslider.on('input', function(){
            var rangeslider_id = $(this).attr('id');
            $('#'+rangeslider_id+'-rangeslider-info').text($(this).val() + append_char);
        });
    });

    // JS functionality for range simple color picker
    $('.ascm-simplecolorpicker').each(function(){
        var simplecolorpicker_cont = $(this);
        var simplecolorpicker_name = simplecolorpicker_cont.attr('simplecolorpicker-name');
        var simplecolorpicker_value = simplecolorpicker_cont.attr('simplecolorpicker-value');

        var simplecolorpicker_colors = simplecolorpicker_cont.attr('simplecolorpicker-colors');
        if (simplecolorpicker_colors == 'not_wfc_genesis') {
            var color_arr = ['transparent', '#f44336', '#f4433680', '#e91e63', '#e91e6380', '#9c27b0', '#9c27b080', '#673ab7', '#673ab780', '#3f51b5', '#3f51b580', '#2196f3', '#2196f380', '#03a9f4', '#03a9f480', '#00bcd4', '#00bcd480', '#009688', '#00968880', '#4caf50', '#4caf5080', '#8bc34a', '#8bc34a80', '#cddc39', '#cddc3980', '#ffeb3b', '#ffeb3b80', '#ffc107', '#ffc10780', '#ff9800', '#ff980080', '#ff5722', '#ff572280', '#795548', '#79554880', '#9e9e9e', '#9e9e9e80', '#607d8b', '#607d8b80'];
        }else{
            var color_arr = simplecolorpicker_colors.split(',');
        }

        $.each( color_arr, function( index, value){
            var checkedstatus = '';
            if (simplecolorpicker_value == value) {
                checkedstatus = 'checked';
            }

            if (value == 'transparent') {
                var colorradio = '<input type="radio" name="'+simplecolorpicker_name+'" id="'+simplecolorpicker_name+'-'+value+'" value="'+value+'" '+checkedstatus+'><label for="'+simplecolorpicker_name+'-'+value+'" style="background-color: #fff !important; color: inherit !important;">'+value+'</label>';
            }else {
                var colorradio = '<input type="radio" name="'+simplecolorpicker_name+'" id="'+simplecolorpicker_name+'-'+value+'" value="'+value+'" '+checkedstatus+'><label for="'+simplecolorpicker_name+'-'+value+'" style="background-color:'+value+' !important;">'+value+'</label>';
            }
            simplecolorpicker_cont.append(colorradio);
        });
    });


    // lock other panel options if panel as content is enabled
    $("#ascm-panels-panelascontent").change(function() {
        PanelAsContentLockToggle();
        ChildrenAsDoNothingLockToggle();  
    });
    PanelAsContentLockToggle();
    function PanelAsContentLockToggle(){
        var title_arr = ['ascm-panel-recipe','ascm-panel-calltoaction', 'ascm-panel-background'];
        if($("#ascm-panels-panelascontent").prop("checked") == true){
            LockUnlockAccordion(title_arr, 'lock');

            var outerwrapperclass_maincont = $('#ascm-panels-hidetitle-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-hidetitle-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'lock');

            var outerwrapperclass_maincont = $('#ascm-panels-displayclildrenas-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-displayclildrenas-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'lock');

            var outerwrapperclass_maincont = $('#ascm-panels-displaytype-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-displaytype-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'lock');

            var outerwrapperclass_maincont = $('#ascm-panels-outerwrapperclass-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-outerwrapperclass-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'lock');

            var innerwrapperclass_maincont = $('#ascm-panels-innerwrapperclass-maincont');
            var innerwrapperclass_subcont = $('#ascm-panels-innerwrapperclass-subcont');
            LockUnlockField(innerwrapperclass_maincont, innerwrapperclass_subcont, 'lock');
        }else{
            LockUnlockAccordion(title_arr, 'unlock');

            var outerwrapperclass_maincont = $('#ascm-panels-hidetitle-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-hidetitle-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'unlock');

            var outerwrapperclass_maincont = $('#ascm-panels-displayclildrenas-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-displayclildrenas-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'unlock');

            var outerwrapperclass_maincont = $('#ascm-panels-displaytype-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-displaytype-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'unlock');

            var outerwrapperclass_maincont = $('#ascm-panels-outerwrapperclass-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-outerwrapperclass-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'unlock');

            var innerwrapperclass_maincont = $('#ascm-panels-innerwrapperclass-maincont');
            var innerwrapperclass_subcont = $('#ascm-panels-innerwrapperclass-subcont');
            LockUnlockField(innerwrapperclass_maincont, innerwrapperclass_subcont, 'unlock');
        }
    }


    // lock other panel options if children as is not set to don nothing
    $('input[name=ascm-panels-displayclildrenas]').on('change', function(){
        PanelAsContentLockToggle();
        ChildrenAsDoNothingLockToggle();    
    });
    ChildrenAsDoNothingLockToggle();
    function ChildrenAsDoNothingLockToggle(){
        var title_arr = ['ascm-panel-recipe','ascm-panel-calltoaction'];
        if ($('input[name=ascm-panels-displayclildrenas]:checked').val() != 'donothing') {
            LockUnlockAccordion(title_arr, 'lock');

            if($("#ascm-panels-panelascontent").prop("checked") != true) {
                var outerwrapperclass_maincont = $('#ascm-panels-parentpanel-maincont');
                var outerwrapperclass_subcont = $('#ascm-panels-parentpanel-subcont');
                LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'lock');
            }

        }else{
            if($("#ascm-panels-panelascontent").prop("checked") != true){
                LockUnlockAccordion(title_arr, 'unlock');
            }

            var outerwrapperclass_maincont = $('#ascm-panels-parentpanel-maincont');
            var outerwrapperclass_subcont = $('#ascm-panels-parentpanel-subcont');
            LockUnlockField(outerwrapperclass_maincont, outerwrapperclass_subcont, 'unlock');
        }
    }


    // Lock accordion method
    function LockUnlockAccordion(title_arr, action){
        $.each( title_arr, function( index, value){
            var title_elem = $('#'+value).find('.ascm-panels-article-title');
            var content_elem = $('#'+value).find('.ascm-panels-accordion-content');

            title_elem.find('span').remove();
            title_elem.find('small').remove();
            title_elem.css('opacity', '1');
            title_elem.css('pointer-events', 'all');
            if (action == 'lock') {
                $('#'+value).removeClass('ascm-panels-open');
                title_elem.append('<span class="dashicons dashicons-lock" style="margin-right: 10px; float: right;">');
                title_elem.append('<small style="margin-left: 10px;"></small>');
                title_elem.css('opacity', '0.5');
                title_elem.css('pointer-events', 'none');
                content_elem.css('display', 'none');
            }
        });
    }


    // Lock field method
    function LockUnlockField(maincont, subcont, action){
        if (action == 'lock') {
            maincont.addClass('ascm-panels-field-lock-cont');
            maincont.find('.ascm-panels-field-lock').remove();
            maincont.prepend('<div class="ascm-panels-field-lock"><span class="dashicons dashicons-lock"></span></div>')
            subcont.addClass('ascm-panels-field-lock-field-cont');
        }else{
            maincont.removeClass('ascm-panels-field-lock-cont');
            maincont.find('.ascm-panels-field-lock').remove();
            subcont.removeClass('ascm-panels-field-lock-field-cont');
        }
    }


    // Toggle all extra settings of recipes
    $("select[name='ascm-panels-recipe']").on('change', function(){
        RecipeExtraSettings();
    }); 
    RecipeExtraSettings();   
    function RecipeExtraSettings(){
        var recipe  = $("select[name='ascm-panels-recipe']").children("option:selected").attr('recipe-settings');


        $('#ascm-panels-halfimage').css('display', 'none');
        $('#ascm-panels-postgallery').css('display', 'none');
        $('#ascm-panels-recentposts').css('display', 'none');
        $('#ascm-panels-tilemenu').css('display', 'none');
        $('#ascm-panels-video').css('display', 'none');
        $('#ascm-panels-withimage').css('display', 'none');

        if(recipe.indexOf('half_image') != -1){
            $('#ascm-panels-halfimage').css('display', 'block');
        }
        if(recipe.indexOf('post_gallery') != -1){
            $('#ascm-panels-postgallery').css('display', 'block');
        }
        if(recipe.indexOf('recent_posts') != -1){
            $('#ascm-panels-recentposts').css('display', 'block');
        }
        if(recipe.indexOf('tile_menu') != -1){
            $('#ascm-panels-tilemenu').css('display', 'block');
        }
        if(recipe.indexOf('video') != -1){
            $('#ascm-panels-video').css('display', 'block');
        }
        if(recipe.indexOf('with_image') != -1){
            $('#ascm-panels-withimage').css('display', 'block');
        }
    }


    // Half Image - Image
    var halfimage_file_frame;
    var halfimage_image_wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    var set_to_post_id = $('#ascm-panels-halfimage-image').val(); // Set this
    jQuery('#ascm_panels_halfimage_image_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( halfimage_file_frame ) {
            // Set the post ID to what we want
            halfimage_file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            halfimage_file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }
        // Create the media frame.
        halfimage_file_frame = wp.media.frames.halfimage_file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        halfimage_file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = halfimage_file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $( '#ascm-panels-halfimage-image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $( '#ascm-panels-halfimage-image' ).val( attachment.id );
            // Restore the main post ID
            wp.media.model.settings.post.id = halfimage_image_wp_media_post_id;
        });
        // Finally, open the modal
        halfimage_file_frame.open();
    });
    // Restore the main ID when the add media button is pressed
    jQuery( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = halfimage_image_wp_media_post_id;
    });
    // clear the main ID when the clear media button is pressed
    jQuery('#ascm_panels_halfimage_image_clearbtn').on('click', function( event ){
        event.preventDefault();

        $( '#ascm-panels-halfimage-image-preview' ).attr( 'src', 'https://via.placeholder.com/600x400' ).css( 'width', 'auto' );
        $( '#ascm-panels-halfimage-image' ).val('');
    });


    // With Image - Image
    var withimage_file_frame;
    var withimage_image_wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    var set_to_post_id = $('#ascm-panels-withimage-image').val(); // Set this
    jQuery('#ascm_panels_withimage_image_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( withimage_file_frame ) {
            // Set the post ID to what we want
            withimage_file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            withimage_file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }
        // Create the media frame.
        withimage_file_frame = wp.media.frames.withimage_file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        withimage_file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = withimage_file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $( '#ascm-panels-withimage-image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $( '#ascm-panels-withimage-image' ).val( attachment.id );
            // Restore the main post ID
            wp.media.model.settings.post.id = withimage_image_wp_media_post_id;
        });
        // Finally, open the modal
        withimage_file_frame.open();
    });
    // Restore the main ID when the add media button is pressed
    jQuery( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = withimage_image_wp_media_post_id;
    });
    // clear the main ID when the clear media button is pressed
    jQuery('#ascm_panels_withimage_image_clearbtn').on('click', function( event ){
        event.preventDefault();

        $( '#ascm-panels-withimage-image-preview' ).attr( 'src', 'https://via.placeholder.com/600x400' ).css( 'width', 'auto' );
        $( '#ascm-panels-withimage-image' ).val('');
    });
	
	/* Toggle Card Type Field */
	$('Select[name="ascm-panels-recipe"]').on('change', function() {
		card_type_toggle();
	});
	card_type_toggle();
	function card_type_toggle() {
		var option = $('Select[name="ascm-panels-recipe"] option:selected').attr('recipe-type');
		if ( option == 'post_gallery' || option == 'recent_posts' || option == 'tile_menu' ) {
			$('.ascm-panels-card-overwrite-wrapper').show();
		} else {
			$('.ascm-panels-card-overwrite-wrapper').hide();
		}
		
	}
	



});

