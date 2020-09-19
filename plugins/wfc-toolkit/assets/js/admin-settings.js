(function($, window, undefined) {
	var taggedEl = {},
		condLogicApp = (function() {
			var taggedEl = [],
				condLogics = [],
				helpers = {
					tag: function(tagId, el, show) {
						var $el = $(el),
							domEl,
							showTag,
							taggedIndex;

						if (!$el.length) {
							return;
						}

						domEl = $el.get(0);
						showTag = $el.data('wfcShow');
						taggedIndex = taggedEl.indexOf(domEl);

						if (showTag === undefined) {
							showTag = {};
						}

						showTag[tagId] = new Boolean(show);

						if (taggedIndex === -1) {
							taggedEl.push(domEl);
						}

						$el.data('wfcShow', showTag);
					},
					run: function() {
						if (condLogics.length) {
							$.each(condLogics, function(i, logic) {
								if ( ! logic.input || ! logic.callback || ! typeof logic.callback == 'function' ) {
									return false;
								}

								var $el = $(logic.input);

								if ($el.length) {
									switch ($el.get(0).type) {
										case 'checkbox':
											$el.on('change', function() {
												logic.callback.call(null, $(this).is(':checked'), helpers.tag);
												helpers.process();
											}).trigger('change');
											break;

										case 'select-one':
											$el.on('change', function() {
												logic.callback.call(null, $(this).val(), helpers.tag);
												helpers.process();
											}).trigger('change');
											break;

										case 'radio':
											$el.on('change', function() {
												logic.callback.call(null, $(this).val(), helpers.tag);
												helpers.process();
											});

											logic.callback.call(null, $el.filter(':checked').val(), helpers.tag);
											helpers.process();
											break;

										case 'text':
										default:
											$el.on('input', function(e) {
												logic.callback.call(null, $(this.val()), helpers.tag);
												helpers.process();
											}).trigger('input');
											break;
									}
								}
							});
						}
					},
					process: function() {
						$.each(taggedEl, function(i, el) {
							var showTag = $(el).data('wfcShow'),
								show = true;

							if (showTag !== undefined) {
								$.each(Object.values(showTag), function(index, isShow) {
									if (!show) {
										return;
									}

									show = isShow.valueOf();
								});

								$(el).toggle(show);
							}
						});
					}
				};

			return {
				init: function(logics) {
					if ($.isArray(logics) && logics.length) {
						condLogics = logics;
					}

					helpers.run();
				}
			};
		})();

	$(function() {
		$('.wfc-tabs-switcher').on('click', function(e) {
			var contentId,
				currItem;

			currItem = $(this).parent('.wfc-tabs-item');
			contentId = currItem.data('content');

			$('.wfc-tabs-item').removeClass('wfc-tabs-item-active');
			$('.wfc-content-wrap').removeClass('wfc-content-active');

			currItem.addClass('wfc-tabs-item-active');
			$('#' + contentId).addClass('wfc-content-active');
		});

		$('.wfc-color-picker input[type="text"]').wpColorPicker();
		$('.wfc-img-upload').on('click', '.wfc-img-upload-btn', onWpMedia);

		$('.wfc-range input[type="range"]').on('change', function(e) {
			var unit = $(this).parent('.wfc-range').data('unit'),
				value = $(this).val();

			$(this).siblings('.wfc-range-value').text(value + unit);
		}).trigger('change');

		$('.wfc-select-multi').select2();

		condLogicApp.init([{
			input: '[name="enable_preloader"]',
			callback: function(value, tag) {
				tag('enable_preloader', $('#preloader-page'), value);
				tag('enable_preloader', $('#preloader-page-except'), value);
				tag('enable_preloader', $('#preloader-selected-page'), value);
				tag('enable_preloader', $('#preloader-type'), value);
				tag('enable_preloader', $('#preloader-spinner'), value);
				tag('enable_preloader', $('#preloader-spinner-color'), value);
				tag('enable_preloader', $('#preloader-spinner-size'), value);
				tag('enable_preloader', $('#preloader-spinner-width'), value);
				tag('enable_preloader', $('#preloader-spinner-image'), value);
				tag('enable_preloader', $('#preloader-bg-color'), value);
				tag('enable_preloader', $('#preloader-text'), value);
				tag('enable_preloader', $('#preloader-text-color'), value);
				tag('enable_preloader', $('#preloader-text-size'), value);
			}
		}, {
			input: '[name="preloader_page"]',
			callback: function(value, tag) {
				tag('preloader_page', $('#preloader-page-except'), value == 'page_except');
				tag('preloader_page', $('#preloader-selected-page'), value == 'selected_page');
			}
		}, {
			input: '[name="preloader_type"]',
			callback: function(value, tag) {
				tag('preloader_type', $('#preloader-spinner'), value == 'spinner');
				tag('preloader_type', $('#preloader-spinner-color'), value == 'spinner');
				tag('preloader_type', $('#preloader-spinner-size'), value == 'spinner');

				tag('preloader_type', $('#preloader-spinner-image'), value == 'image');
				tag('preloader_type', $('#preloader-spinner-width'), value == 'image');
			}
		}, {
			input: '[name="enable_sticky_elements"]',
			callback: function(value, tag) {
				tag('enable_sticky_elements', $('#enable-sticky-on-desktop'), value);
				tag('enable_sticky_elements', $('#enable-sticky-on-mobile'), value);
				tag('enable_sticky_elements', $('#enable-sticky-on-tablet'), value);
				tag('enable_sticky_elements', $('#sticky-target-element'), value);
			}
		}]);
	});

	function onWpMedia(e) {
		e.preventDefault();

		var button = $(this),
			custom_uploader = wp.media({
			title: 'Upload Image',
			library: {
				type: 'image'
			},
			button: {
				text: 'Use this image'
			},
			multiple: false
		}).on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON(),
				field = button.siblings('.wfc-img-upload-field'),
				preview = button.siblings('.wfc-img-upload-preview'),
				img = $('<img>');

			field.val(attachment.url);
			img.attr('src', attachment.url);
			preview.html(img);

			console.log(preview, img);
		}).open();
	}
})(window.jQuery, window);