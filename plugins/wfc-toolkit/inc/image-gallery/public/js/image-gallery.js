(function($) {
    var WFCG_WPImageGallery = {
        options: {},
        config: wfcImageGalleryConfig,

        init: function(options) {
            this.options = options;

            this.options.imageGallery.removeClass(function(i, cls) {
                return (cls.match(/columns-\d{1,2}/g) || []).join(' ');
            });

            this.options.imageGallery.addClass('column-small-' + this.config.colCountSmall);
            this.options.imageGallery.addClass('column-medium-' + this.config.colCountMedium);
            this.options.imageGallery.addClass('column-large-' + this.config.colCountLarge);

            this.bind();
        },

        bind: function() {
            switch (this.config.displayType) {
                case 'equalize':
                    this.options.imageGalleryClassic.addClass('is-equalize');
                    break;
                case 'masonry':
                    let isotopeOptions = {
                        itemSelector: '.gallery-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: 0,
                            horizontalOrder: true
                        }
                    };
                    this.options.imageGalleryClassic.isotope({
                        itemSelector: '.gallery-item',
                        percentPosition: true,
                    });

                    this.options.imageGallery.addClass('is-masonry');
                    setTimeout(function() {
                        let self = WFCG_WPImageGallery;
                        self.options.imageGallery.isotope({
                            itemSelector: '.blocks-gallery-item',
                            percentPosition: true,
                            masonry: {
                                gutter: 16
                            }
                        });
                        self.postProcess();
                    }, 800);
                    break;
            }
        },

        postProcess: function() {
            this.options.imageGalleryClassic.find('.gallery-item').each(function() {
                WFCG_WPImageGallery.imageLoad(
                    $(this),
                    WFCG_WPImageGallery.options.imageGalleryClassic.isotope('layout')
                );
            });

            this.options.imageGallery.find('.blocks-gallery-item').each(function() {
                WFCG_WPImageGallery.imageLoad(
                    $(this),
                    WFCG_WPImageGallery.options.imageGallery.isotope('layout')
                );
            })
        },

        imageLoad: function(elem, callback) {
            let $elem = $(elem);

            $elem.imagesLoaded(function() {

                let imgHeight = $elem.find('img').height();

                $elem.find('img').animate({
                    'height': imgHeight + 'px'
                }, 300, function() {
                    // clone.find('img').addClass('loaded');
                    // clone.find('.image-loader').css('opacity', '0.0');
                });

                if (typeof callback === 'function')
                    callback();
            })
        }
    };

    $(document).ready(function() {
        WFCG_WPImageGallery.init({
            imageGalleryClassic: $('.gallery'),     // image gallery below WordPress 5, using classic
            imageGallery: $('.wp-block-gallery')    // image gallery WordPress 5 or above that uses Gutenberg
        });
    })
})(jQuery);