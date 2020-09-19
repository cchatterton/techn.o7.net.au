(function() {
    if (typeof  tinymce === 'undefined') return; 

    tinymce.create("tinymce.plugins.ascm_repost_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("ascm_repost_button", {
                title : "Related Post",
                cmd : "ascm_repost_button_command",
                image : jQuery('#ascm-repost-logo').val() 
            });

            //button functionality.
            ed.addCommand("ascm_repost_button_command", function() {
                console.log('asdasd');
                var selected_text = ed.selection.getContent();

                jQuery('#ascm-repost-relatedpostlist-sub-cont').css('animation-name','showEnter');
                jQuery('#ascm-repost-relatedpostlist-main-cont').css('display','flex');
            });

            jQuery('#ascm-repost-relatedpostlist-apply-btn').on( 'click', function() {
                jQuery('#ascm-repost-relatedpostlist-sub-cont').css('animation-name','hideExit');
                setTimeout(function(){ 
                    jQuery('#ascm-repost-relatedpostlist-main-cont').css('display','none');
                }, 500);

                var title = jQuery('#ascm-repost-relatedpostlist-title').val();
                title = title.replace(/\s+/g, '~');

                var tag_elem_val = '';
                jQuery('#ascm-repost-relatedpostlist-postid').find('div').each(function(){
                    if (tag_elem_val == '') {
                        tag_elem_val = $(this).find('input').val();
                    }else {
                        tag_elem_val = tag_elem_val + ',' + $(this).find('input').val();
                    }
                });


                var return_text = '[ascm-repost type=relatedpostlist title='+title+' id='+tag_elem_val+']';
                ed.execCommand("mceInsertContent", 0, return_text);
               // tinymce.activeEditor.execCommand('mceInsertContent', false, "some text");
            }); 

            jQuery('#ascm-repost-relatedpostlist-cancel-btn').on( 'click', function() {
                //console.log('asdasda');
                jQuery('#ascm-repost-relatedpostlist-sub-cont').css('animation-name','hideExit');
                setTimeout(function(){ 
                    jQuery('#ascm-repost-relatedpostlist-main-cont').css('display','none');
                }, 500);
            });  

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "WFC Genesis Repost",
                author : "AlphaSys Pty. Ltd.",
                version : "1.0.0.0"
            };
        }
    });

    tinymce.PluginManager.add("ascm_repost_button_plugin", tinymce.plugins.ascm_repost_button_plugin);
})();




