jQuery(document).ready(function($){
    if ($('body').hasClass('wfcg-preload-body')){

        $('body').on('wfcg-preloader:done', function () {
            console.log('WFCG Preloader Detected');
            $("div[ascm-carousel-id='true']").each(function( index ) {
                var ascm_carousel_id = $(this).attr('id');
                var owlCarousel_element = $("#"+ascm_carousel_id).owlCarousel({
                    nav : true,
                    navText : ['<i class="fas fa-chevron-left fa-5x"></i><i class="fas fa-chevron-left fa-2x"></i>','<i class="fas fa-chevron-right fa-2x"></i><i class="fas fa-chevron-right fa-5x"></i>'],
                    items:1,
                    margin:0,
                    dots: false,
                    autoHeight:true,
                    loop: true,
                    autoplay: false,
                    autoplayHoverPause: true,
                    lazyLoad: true,
                    startPosition: 0
                });
            });
        });

    } else {
        $("div[ascm-carousel-id='true']").each(function( index ) {
            var ascm_carousel_id = $(this).attr('id');
            var owlCarousel_element = $("#"+ascm_carousel_id).owlCarousel({
                nav : true,
                navText : ['<i class="fas fa-chevron-left fa-5x"></i><i class="fas fa-chevron-left fa-2x"></i>','<i class="fas fa-chevron-right fa-2x"></i><i class="fas fa-chevron-right fa-5x"></i>'],
                items:1,
                margin:0,
                dots: false,
                autoHeight:true,
                loop: true,
                autoplay: false,
                autoplayHoverPause: true,
                lazyLoad: true,
                startPosition: 0
            });
        });
    }

});