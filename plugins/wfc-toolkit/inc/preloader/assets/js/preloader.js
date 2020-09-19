(function($) {
    var WFC_Preloader_Public = {
        options: {},
        vals: {
            configs: wfc_preloader,
            transitionEnded: false,
        },

        init: function(options) {
            this.options = options;

            if (this.vals.configs.enable == '0') return;
            if (this.vals.configs.is_preload == '0') return;

            this.preInit();
            this.bind();
        },

        bind: function() {
            let self = WFC_Preloader_Public;
            $(window).on('load', function() {self.load()});
            self.options.preloaderContainer.find('.wfc-spinner').on('transitionend', function() {self.transitionEnd()});
        },

        preInit: function() {
            let self = WFC_Preloader_Public;
            this.options.body.addClass('wfc-preload-body');
            setTimeout( function() {
                self.options.preloaderContainer.removeClass('pre-loading');
            }, 50 );
            //this.options.preloaderContainer.removeClass('pre-loading');
        },

        transitionEnd: function() {
            let self = WFC_Preloader_Public;
            self.vals.transitionEnded = true;
            self.preload();
        },

        load: function() {
            let self = WFC_Preloader_Public;
            if (! self.vals.transitionEnded) return;
            this.options.preloaderContainer.find('.wfc-spinner').off('transitionend').on('transitionend', function() {
                self.preload();
            });
        },

        preload: function() {
            let self = WFC_Preloader_Public;
            setTimeout(function() {
                self.options.preloaderContainer.addClass('post-loading');
                self.options.preloaderContainer.off('transitionend').on('transitionend', function() {
                    self.options.body.removeClass('wfc-preload-body');
                    self.options.preloaderContainer.remove();

                    self.options.body.trigger('wfc-preloader:done');
                })
            }, 1000);
        }
    };

    // $(document).ready(function() {
        WFC_Preloader_Public.init({
            body: $('body'),
            preloaderContainer: $('#wfc-preloader')
        })
    // });
})(jQuery);