jQuery(document).ready(function($){

	console.log('AlphaSys Content Management');
	$('div[id=ascm-main-sidemenu-button]').on('click' , function(event) {

        ToggleASCMContent($(this).attr('btnelvalue'));

    });


    var modules = ['bestbefore', 'repost', 'panels'];
    $.each(modules, function(index, value){
        var gear_elem = null;
        $('#ascm-mod-settings-btn-'+value).on( 'click', function() {
            gear_elem = $(this).find('i');
            gear_elem.addClass('fa-spin');
            setTimeout(function(){ 
                gear_elem.removeClass('fa-spin');
            }, 500);
            $('#ascm-mod-settings-sub-cont-'+value).css('animation-name','showEnter');
            $('#ascm-mod-settings-main-cont-'+value).css('display','flex');
        }); 

        $('#ascm-mod-settings-cancel-btn-'+value).on( 'click', function() {
            $('#ascm-mod-settings-sub-cont-'+value).css('animation-name','hideExit');
            setTimeout(function(){ 
                $('#ascm-mod-settings-main-cont-'+value).css('display','none');
            }, 500);
            gear_elem.addClass('fa-spin');
            setTimeout(function(){ 
                gear_elem.removeClass('fa-spin');
            }, 500);
        });  
    });




   

});
