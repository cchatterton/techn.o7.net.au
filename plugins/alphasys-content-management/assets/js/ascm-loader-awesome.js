(function($) {
    var ASCM_Loader = {
        options: {},

        init: function(options) {
            this.options = options;

            this.bind();
        },

        bind: function() {
            let self = ASCM_Loader;

            this.options.loaderSelect.on('change', function(e) {self.loaderPreview(e, this)});
            this.options.loaderSize.on('change', function(e) {self.loaderSizePreview(e, this)});
            this.options.loaderColor.wpColorPicker({
                change: self.loaderColorPreview
            });
            this.options.loaderBGColor.wpColorPicker({
                change: self.loaderBGColorPicker
            })
        },

        loaderPreview: function(event, elem) {
            let self = ASCM_Loader;
            let $elem = $(elem);

            console.log(self.options.loaderSize);

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'ascm_loader_preview',
                    loader: $elem.val(),
                    color: self.options.loaderColor.val(),
                    size: self.options.loaderSize.parent().find('input:checked').val()
                },
                success: function(response) {
                    self.options.loaderPreviewContainer.html(response);
                }
            })
        },

        loaderSizePreview: function(event, elem) {
            let self = ASCM_Loader;
            let $elem = $(elem);
            let loader = self.options.loaderPreviewContainer.find('.item-loader-container > *');

            loader.removeClass('la-sm la-2x la-3x');

            switch ($elem.val()) {
                case 'small':
                    loader.addClass('la-sm');
                    break;
                case 'normal':
                    loader.addClass('');
                    break;
                case 'medium':
                    loader.addClass('la-2x');
                    break;
                case 'large':
                    loader.addClass('la-3x');
                    break;
            }
        },

        loaderColorPreview: function(event, ui) {
            // let self = ASCM_Loader;

            ASCM_Loader.options.loaderPreviewContainer.find('.item-loader-container > *').css('color', ui.color.toString());
        },

        loaderBGColorPicker: function(event, ui) {
            // let self = ASCM_Loader;
            console.log(ui.color.toRgb());
            let rgb = ui.color.toRgb();

            ASCM_Loader.options.loaderPreviewContainer.css(
                'background-color',
                'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', 0.4)'
            );
        }
    };

    $(document).ready(function() {
        ASCM_Loader.init({
            loaderSelect: $('#ascm-repost-loader'),
            loaderPreviewContainer: $('.ascm-loader-preview'),
            loaderSize: $('input[name=\'ascm-repost-loader-size\']'),
            loaderColor: $('#ascm-repost-loader-clr'),
            loaderBGColor: $('#ascm-repost-loader-background-clr')
        });
    })
})(jQuery);