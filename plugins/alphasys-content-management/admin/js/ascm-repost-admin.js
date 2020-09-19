jQuery(document).ready(function($){

    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    var set_to_post_id = $('#ascm-repost-relatedpostlist-fallback-img').val(); // Set this
    jQuery('#ascm_repost_relatedpostlist_fallback_img_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            // Set the post ID to what we want
            file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $( '#ascm-repost-relatedpostlist-fallback-img-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $( '#ascm-repost-relatedpostlist-fallback-img' ).val( attachment.id );
            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;
        });
            // Finally, open the modal
            file_frame.open();
    });
    // Restore the main ID when the add media button is pressed
    jQuery( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = wp_media_post_id;
    });

    jQuery('#ascm_repost_relatedpostlist_fallback_img_clearbtn').on('click', function( event ){
        event.preventDefault();
        
        $( '#ascm-repost-relatedpostlist-fallback-img-preview' ).attr( 'src', 'https://via.placeholder.com/600x400' ).css( 'width', 'auto' );
        $( '#ascm-repost-relatedpostlist-fallback-img' ).val('');
    });


    //  JS for settings save
    $('#ascm-mod-settings-save-btn-repost').on( 'click', function() {
        $('#ascm-mod-settings-loading-cont-repost').removeClass('ascm-hidden');

        $('#ascm-mod-settings-fields-cont-repost').addClass('ascm-disable');
        $('#ascm-mod-settings-save-btn-repost').addClass('ascm-disable');
        $('#ascm-mod-settings-cancel-btn-repost').addClass('ascm-disable');

        var field_arr = [
            'ascm-repost-relatedpostlist-fallback-img',
            'ascm-repost-relatedpostlist-outercontclass',
            'ascm-repost-relatedpostlist-innercontclass',
        ];

        var field_save_obj = {};
        $.each(field_arr, function(index,value){
            var tag_elem = $('#'+value);
            if (typeof tag_elem.attr('data-tags-input-name') !== typeof undefined && tag_elem.attr('data-tags-input-name') !== false) {
                var tag_elem_val = '';
                tag_elem.find('div').each(function(){
                    if (tag_elem_val == '') {
                        tag_elem_val = $(this).find('input').val();
                    }else {
                        tag_elem_val = tag_elem_val + ',' + $(this).find('input').val();
                    }
                });
                field_save_obj[value] = tag_elem_val;
            }else {
                field_save_obj[value] = $('#'+value).val();
            }    
        });

        field_save_obj['ascm-repost-loader-size'] = $('input[name=\'ascm-repost-loader-size\']:checked').val();

        $.ajax({
            type: 'POST',
            url:  ascm_modsettings_repost_param.url,
            data: {
                'action':'save_modsettings_repost', 
                nonce: ascm_modsettings_repost_param.nonce,
                modsettings: field_save_obj,
            },
            success: function(resp) {
                console.log(resp);
                setTimeout(function(){
                    $('#ascm-mod-settings-loading-cont-repost').addClass('ascm-hidden');

                    $('#ascm-mod-settings-fields-cont-repost').removeClass('ascm-disable');
                    $('#ascm-mod-settings-save-btn-repost').removeClass('ascm-disable');
                    $('#ascm-mod-settings-cancel-btn-repost').removeClass('ascm-disable');
                }, 500);
            },
            error: function(resp) {
                reject( resp );
                setTimeout(function(){
                    $('#ascm-mod-settings-loading-cont-repost').addClass('ascm-hidden');

                    $('#ascm-mod-settings-fields-cont-repost').removeClass('ascm-disable');
                    $('#ascm-mod-settings-save-btn-repost').removeClass('ascm-disable');
                    $('#ascm-mod-settings-cancel-btn-repost').removeClass('ascm-disable');
                }, 500);
            }
        });
    }); 

    

});