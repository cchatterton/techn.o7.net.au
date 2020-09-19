(function($) {
    $.fn.wfcgSlider = function() {
        return this.each(function() {
            const s = $(this);
            const sui = s.next();

            var min = parseInt(s.attr('min'));
            var max = parseInt(s.attr('max'));
            var val = parseInt(s.val());
            var orientation = s.attr('data-orientation');

            sui.slider({
                range: 'min',
                value: val,
                min: min,
                max: max,
                orientation: orientation,
                start: function(event, ui) {
                    $(ui.handle).attr('data-value', ui.value);
                },
                slide: function(event, ui) {
                    s.val(ui.value);
                    $(ui.handle).attr('data-value', ui.value);
                }
            });
        });
    };

    $(document).ready(function() {
        // hiding Column Count option by binding click event and finding the control to hide it
        // force making crop option to false to make it not crop images
        $(document).on('click', 'div[data-type=\'core/gallery\']', function() {
            let componentsPanel = $('.components-panel');
            componentsPanel.find('.components-panel__body .components-range-control').hide();

            let toggleControl = componentsPanel.find('.components-panel__body .components-toggle-control');
            let toggleFormControl = toggleControl.find('.components-form-toggle');
            if (toggleFormControl.hasClass('is-checked')) {
                toggleFormControl.find('input.components-form-toggle__input').click();
            }
            toggleControl.hide();
        });

        $('.wfcg-slider').wfcgSlider();
    });
})(jQuery);