(function() {
    tinymce.create("tinymce.plugins.ascm_panels_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("ascm_panels_button", {
                title : "Panels",
                cmd : "ascm_panels_button_command",
                image : jQuery('#ascm-panels-logo').val() 
            });

            //button functionality.
            ed.addCommand("ascm_panels_button_command", function() {
                var selected_text = ed.selection.getContent();

                jQuery('#ascm-panels-metaopt-sub-cont').css('animation-name','showEnter');
                jQuery('#ascm-panels-metaopt-main-cont').css('display','flex');
            });

            jQuery('#ascm-panels-metaopt-apply-btn').on( 'click', function() {
                jQuery('#ascm-panels-metaopt-sub-cont').css('animation-name','hideExit');
                setTimeout(function(){ 
                    jQuery('#ascm-panels-metaopt-main-cont').css('display','none');
                }, 500);

                var return_text = '';
                return_text = jQuery('#ascm-panels-metaopt-select').val();
                ed.execCommand("mceInsertContent", 0, return_text);
               // tinymce.activeEditor.execCommand('mceInsertContent', false, "some text");
            }); 

            jQuery('#ascm-panels-metaopt-cancel-btn').on( 'click', function() {
                //console.log('asdasda');
                jQuery('#ascm-panels-metaopt-sub-cont').css('animation-name','hideExit');
                setTimeout(function(){ 
                    jQuery('#ascm-panels-metaopt-main-cont').css('display','none');
                }, 500);
            });  

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "WFC Genesis Panels",
                author : "AlphaSys Pty. Ltd.",
                version : "1.0.0.0"
            };
        }
    });

    tinymce.PluginManager.add("ascm_panels_button_plugin", tinymce.plugins.ascm_panels_button_plugin);
})();
