(function ($, undefined) {
	window.Wds = window.Wds || {};

	/**
	 * General scoped variable getter
	 *
	 * @param {String} scope Scope to check for variable
	 * @param {String} string Particular varname
	 *
	 * @return {String} Found value or false
	 */
	window.Wds.get = window.Wds.get || function (scope, varname) {
		scope = scope || 'general';
		return (window['_wds_' + scope] || {})[varname] || false;
	};

	/**
	 * Fetch localized string for a particular context
	 *
	 * @param {String} scope Scope to check for strings
	 * @param {String} string Particular string to check for
	 *
	 * @return {String} Localized string
	 */
	window.Wds.l10n = window.Wds.l10n || function (scope, string) {
		return (Wds.get(scope, 'strings') || {})[string] || string;
	};

	/**
	 * Fetch template for a particular context
	 *
	 * @param {String} scope Scope to check for templates
	 * @param {String} string Particular template to check for
	 *
	 * @return {String} Template markup
	 */
	window.Wds.template = window.Wds.template || function (scope, template) {
		return (Wds.get(scope, 'templates') || {})[template] || '';
	};

	/**
	 * Compiles the template using underscore templaing facilities
	 *
	 * This is a simple wrapper with templating settings override,
	 * Used because of the PHP ASP tags issues with linters and
	 * deprecated PHP setups.
	 *
	 * @param {String} tpl Template to expand
	 * @param {Object{ obj Optional data object
	 *
	 * @return {String} Compiled template
	 */
	window.Wds.tpl_compile = function (tpl, obj) {
		var setup = _.templateSettings,
			value
		;
		_.templateSettings = {
			evaluate: /\{\{(.+?)\}\}/g,
			interpolate: /\{\{=(.+?)\}\}/g,
			escape: /\{\{-(.+?)\}\}/g
		};
		value = _.template(tpl, obj);
		_.templateSettings = setup;
		return value;
	};

	window.Wds.qtips = function ($elements) {
		var $ = jQuery;
		$elements.each(function () {
			$element = $(this);
			$element.qtip(
				$.extend({
					style: {
						classes: 'wds-qtip qtip-rounded'
					},
					position: {
						my: 'bottom center',
						at: 'top center'
					}
				}, $element.data())
			);
		});
	};

	window.Wds.hook_toggleables = function () {
		let toggle_content = function () {
			var $content = $(this),
				$form_field = $content.closest('.sui-form-field'),
				$toggle = $form_field.find('> .sui-toggle'),
				$checkbox = $toggle.find('input[type="checkbox"]'),
				is_active = $checkbox.is(":checked");

			if (is_active) {
				$content.show();
			} else {
				$content.hide();
			}

			$checkbox.on('change', function () {
				toggle_content.apply($content);
			});
		};
		$('.sui-toggle-content').each(toggle_content);
	};

	window.Wds.hook_conditionals = function () {
		var root_selector = '.wds-conditional',
			$ = jQuery;

		function show_conditional_elements($select) {
			var $root = $select.closest(root_selector);

			$.each($root.find('.wds-conditional-inside'), function (index, conditional_el) {
				var $conditional_el = $(conditional_el);

				if ($conditional_el.data('conditional-val') == $select.val()) {
					$conditional_el.show();
				}
				else {
					$conditional_el.hide();
				}

				window.Wds.readjust_vertical_tabs_height();
			});
		}

		var $selects = $("select", $(root_selector)).not(".wds-conditional-inside *");

		$.each($selects, function (index, select) {
			show_conditional_elements($(select));

			$(select).change(function () {
				show_conditional_elements($(this));
				return false;
			});
		});
	};

	window.Wds.readjust_vertical_tabs_height = function () {
		// Click the current tab for height recalculation
		if (jQuery(".vertical-tabs").length) {
			jQuery('[name="wds-admin-active-tab"]:checked').click();
		}
	};

	window.Wds.accordion = function (end_callback) {
		var $ = jQuery;

		$(document).on('click', '.wds-accordion-handle', function () {
			var $handle = $(this),
				$accordion = $handle.closest('.wds-accordion'),
				$section = $handle.closest('.wds-accordion-section');

			if ($section.is('.disabled')) {
				return;
			}

			if ($section.is('.open')) {
				$section.removeClass('open');
			} else {
				$accordion.find('.open').removeClass('open');
				$section.addClass('open');
			}

			window.Wds.readjust_vertical_tabs_height();

			if (end_callback) {
				end_callback();
			}
		});
	};

	window.Wds.link_dropdown = function () {
		var $ = jQuery;

		function close_all_dropdowns($except) {
			var $dropdowns = $('.wds-links-dropdown');
			if ($except) {
				$dropdowns = $dropdowns.not($except);
			}
			$dropdowns.removeClass('open');
		}

		$('body').click(function (e) {
			var $this = $(e.target),
				$el = $this.closest('.wds-links-dropdown');

			if ($el.length == 0) {
				close_all_dropdowns();
			}
			else if ($this.is('a')) {
				e.preventDefault();
				close_all_dropdowns($el);

				$el.toggleClass('open');
			}
		});
	};

	window.Wds.media_url = function ($root) {
		var $ = jQuery,
			$button = $root.find('.wds-media-url-button'),
			$field = $root.find('.wds-media-url-field'),
			idx = $root.data('name');

		if (!(wp || {}).media) {
			return;
		}

		wp.media.frames.wds_media_url = wp.media.frames.wds_media_url || {};
		wp.media.frames.wds_media_url[idx] = wp.media.frames.wds_media_url[idx] || new wp.media({
			multiple: false,
			library: {type: 'image'}
		});

		$button.click(function (e) {
			if (e && e.preventDefault) e.preventDefault();
			wp.media.frames.wds_media_url[idx].open();

			return false;
		});

		wp.media.frames.wds_media_url[idx].on('select', function () {
			var selection = wp.media.frames.wds_media_url[idx].state().get('selection'),
				url = '';

			if (!selection) {
				return false;
			}

			selection.each(function (model) {
				url = model.get("url");
			});

			if (!url) {
				return false;
			}

			$field.val(url);
		});
	};

	window.Wds.styleable_file_input = function () {
		function file_input($context) {
			var $root = $context.closest('.sui-upload');

			return {
				file_input: $root.find('input[type="file"]'),
				upload_button: $root.find('.sui-upload-button'),
				file_details: $root.find('.sui-upload-file'),
				file_name: $root.find('.sui-upload-file span'),
				clear_button: $root.find('.sui-upload-file button')
			};
		}

		function get_file_name(path) {
			if (!path) {
				return '';
			}

			var delimiter = path.includes('\\') ? '\\' : '/';

			return path.split(delimiter).pop();
		}

		function handle_clear_button_click(e) {
			e.preventDefault();

			var el = file_input($(this));

			el.upload_button.show();
			el.file_details.hide();
			el.file_input.val(null);
		}

		function handle_file_input_change() {
			var el = file_input($(this)),
				file_path = el.file_input.val();

			if (!file_path) {
				return;
			}

			el.file_details.show();
			el.file_name.html(get_file_name(file_path));
			el.upload_button.hide();
		}

		function set_defaults_on_page_load() {
			$('.sui-upload').each(function () {
				handle_file_input_change.apply(this);
			})
		}

		$(document)
			.on('click', '.sui-upload .sui-upload-file button', handle_clear_button_click)
			.on('change', '.sui-upload input[type="file"]', handle_file_input_change)
			.on('ready', set_defaults_on_page_load);
	};

	window.Wds.styleable_checkbox = function ($element) {
		var $ = jQuery;
		$element.each(function () {
			var $checkbox = $(this);

			if ($checkbox.closest('.wds-checkbox-container').length) {
				return;
			}

			$checkbox.wrap('<div class="wds-checkbox-container">');
			$checkbox.wrap('<label>');
			$checkbox.after('<span></span>');
		});
	};

	window.Wds.optimum_length_indicator = function ($element, lower, upper, default_value) {
		var $ = jQuery,
			offset = 8 / 100 * upper,
			almost_lower = lower + offset,
			almost_upper = upper - offset,
			field_class = 'wds-optimum-length-indicator-field',
			field_selector = '.' + field_class,
			indicator_class = 'wds-optimum-length-indicator',
			indicator_selector = '.' + indicator_class;

		if ($element.is(field_selector) || !$element.is('input,textarea')) {
			return;
		}

		$element.addClass(field_class);
		$('<div><span></span><span></span></div>').addClass(indicator_class).insertAfter($element);

		var $indicator = $element.next(indicator_selector),
			$bar = $indicator.find('span').first(),
			$character_count = $indicator.find('span').last();

		function reset_classes() {
			$element.removeClass('over almost-over just-right almost-under under');
		}

		function add_resolving_class() {
			$element.addClass('resolving');
		}

		var update_indicator = function () {
			var $this = $(this),
				value = $this.val();

			value = !!value ? value : default_value;
			if (!value) {
				return;
			}

			Wds.macroReplacement.replace(value, Wds.postEditor.get_data()).then(function (final_value) {
				final_value = Wds.stringUtils.strip_html(final_value);
				final_value = Wds.stringUtils.normalize_whitespace(final_value);

				var length = Array.from(final_value).length,
					ideal_length = (upper + lower) / 2,
					percentage = length / ideal_length * 100;

				$element.removeClass('resolving');
				$element.one('input propertychange', add_resolving_class);

				// When the length is equal to mean, the progress bar should be in the center instead of the end. Therefore:
				percentage = percentage / 2;
				percentage = percentage > 100 ? 100 : percentage;

				$bar.width(percentage + '%');
				$character_count.html(length + ' / ' + lower + '-' + upper + ' ' + Wds.l10n('admin', 'characters'));
				if (!!length) {
					$character_count.show();
				} else {
					$character_count.hide();
				}

				reset_classes();

				if (length > upper) {
					$element.addClass('over');
				}
				else if (almost_upper < length && length <= upper) {
					$element.addClass('almost-over');
				}
				else if (almost_lower <= length && length <= almost_upper) {
					$element.addClass('just-right');
				}
				else if (lower <= length && length < almost_lower) {
					$element.addClass('almost-under');
				}
				else if (lower > length) {
					$element.addClass('under');
				}
			});
		};

		var update_indicator_apply = function () {
			update_indicator.apply($element);
		};
		update_indicator_apply();
		$element
			.on('input propertychange', _.debounce(update_indicator, 200))
			.one('input propertychange', add_resolving_class)
		;
		Wds.postEditor.addEventListener('content-change', update_indicator_apply);
		Wds.postEditor.addEventListener('autosave', update_indicator_apply);
	};

	window.Wds.dismissible_message = function () {
		var $ = jQuery;

		function remove_message(event) {
			event.preventDefault();

			var $dismiss_link = $(this),
				$message_box = $dismiss_link.closest('.wds-mascot-message, .wds-notice'),
				message_key = $message_box.data('key');

			$message_box.remove();
			if (message_key) {
				$.post(
					ajaxurl,
					{
						action: 'wds_dismiss_message',
						message: message_key,
						_wds_nonce: _wds_admin.nonce
					},
					'json'
				);
			}
		}

		$(document).on('click', '.wds-mascot-bubble-dismiss, .wds-notice-dismiss', remove_message);
	};

	window.Wds.vertical_tabs = function () {
		var $ = jQuery;

		jQuery(document).on('click', '.wds-vertical-tabs a', function () {
			var tab = $(this).data('target'),
				url_parts = location.href.split('&tab=');

			history.replaceState({}, "", url_parts[0] + "&tab=" + tab);
			switch_to_tab(tab);

			event.preventDefault();
			event.stopPropagation();
			return false;
		});

		function switch_to_tab(tab) {
			hide_all_except_active(tab);
			add_current_class(tab);
			update_active_tab_input(tab);

			$('.wds-vertical-tabs').trigger('wds_vertical_tabs:tab_change', [$('#' + tab).get(0)]);
		}

		function hide_all_except_active(tab) {
			$('.wds-vertical-tab-section').addClass('hidden');
			$('#' + tab).removeClass('hidden');
		}

		function add_current_class(tab) {
			$('.wds-vertical-tabs li').removeClass('current');
			$('[data-target="' + tab + '"]').closest('li').addClass('current');
		}

		function update_active_tab_input(tab) {
			$('#wds-admin-active-tab').val(tab);
		}
	};

	window.Wds.update_progress_bar = function ($element, value) {
		if (!$element.is('.wds-progress.sui-progress-block') || isNaN(value)) {
			return;
		}

		var rounded = parseFloat(value).toFixed();
		if (rounded > 100) {
			rounded = 100;
		}

		$element.data('progress', value);
		$element.find('.sui-progress-text span').html(rounded + '%');
		$element.find('.sui-progress-bar span').width(value + '%');
	};

	window.Wds.open_dialog = function (id, focus_after_closed, focus_after_open) {
		if (!focus_after_closed) {
			focus_after_closed = 'container';
		}

		SUI.openModal(id, focus_after_closed, focus_after_open);
	};

	window.Wds.close_dialog = function () {
		SUI.closeModal();
	};

	window.Wds.macro_dropdown = function () {
		jQuery(document).on('change', '.wds-allow-macros select', function () {
			var $select = jQuery(this),
				$input = $select.closest('.wds-allow-macros').find('input, textarea'),
				macro = $select.val();

			$input
				.val(jQuery.trim($input.val()) + ' ' + macro)
				.trigger('change')
				.trigger('input');
		});
	};

	window.Wds.conditional_fields = function () {
		var $ = jQuery;

		function el_value($el) {
			if ($el.is(':checkbox')) {
				return $el.prop('checked') ? '1' : '0';
			} else {
				return $el.val();
			}
		}

		function handle_conditional($child) {
			var parent = $child.data('parent'),
				$parent = $('#' + parent),
				parent_val = $child.attr('data-parent-val'),
				values = [];

			if (parent_val.indexOf(',') !== -1) {
				values = parent_val.split(',');
			}
			else {
				values.push(parent_val);
			}

			if (values.indexOf(el_value($parent)) === -1) {
				$child.hide();
			}
			else {
				$child.show();
			}
		}

		$('.wds-conditional-child').each(function () {
			handle_conditional(
				$(this)
			);
		});

		$('.wds-conditional-parent').on('change', function () {
			var $parent = $(this),
				parent_id = $parent.attr('id'),
				$children = $('[data-parent="' + parent_id + '"]');

			$children.each(function () {
				handle_conditional(
					$(this)
				);
			});
		});
	};

	window.Wds.floating_message = function () {
		jQuery('.wds-floating-notice-trigger').click();
	};

	window.Wds.show_floating_message = function (id, message, type) {
		if (!type) {
			type = 'info';
		}

		SUI.openNotice(id, '<p>' + message + '</p>', {
			type: type,
			autoclose: {
				show: true,
				timeout: 5000
			}
		});
	};

	/**
	 * Gets cookie value.
	 * Source: https://www.quirksmode.org/js/cookies.html
	 *
	 * @param {String} name Cookie key to get.
	 *
	 * @return {String}|{Null} Value.
	 */
	window.Wds.get_cookie = function (name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	};

	/**
	 * Sets cookie value.
	 * Source: https://www.quirksmode.org/js/cookies.html
	 *
	 * @param {String} name Cookie key to set.
	 * @param {String} value Value to set.
	 * @param {Number} name Cookie expiration time.
	 */
	window.Wds.set_cookie = function (name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	};

	/**
	 * Expires a cookie
	 * Source: https://www.quirksmode.org/js/cookies.html
	 *
	 * @param {String} name Cookie key to expire.
	 */
	window.Wds.delete_cookie = function (name) {
		document.cookie = name + '=; Max-Age=-99999999;';
	};

	window.Wds.inverted_toggle = function () {
		var selector = '.wds-inverted-toggle';
		$(selector).each(function (index, inverted) {
			$('.sui-toggle [type="checkbox"]', $(inverted))
				.on('change', function () {
					var $checkbox = $(this),
						$hidden = $checkbox.closest(selector).find('.wds-inverted-toggle-value');

					$hidden.prop(
						'value',
						$checkbox.is(':checked') ? '' : $hidden.data('value')
					);
				});
		});
	};

	function init() {
		window.Wds.floating_message();
		window.Wds.inverted_toggle();
		window.Wds.sui_tab_fix();
	}

	$(init);

	window.Wds.update_checkup_progress = function ($progress_bar, on_complete) {
		function update_progress_text(progress) {
			var strings = {
					init_text: Wds.l10n('admin', 'initializing'),
					finalizing_text: Wds.l10n('admin', 'finalizing'),
					running_text: Wds.l10n('admin', 'running'),
				},
				text;

			if (progress < 5) {
				text = strings.init_text;
			} else if (progress < 99) {
				text = strings.running_text;
			} else {
				text = strings.finalizing_text;
			}

			if (text) {
				$('span', $progress_bar.next('.sui-progress-state')).html(text);
			}
		}

		return $.post(ajaxurl, {
			action: 'wds-checkup-status'
		}, function (resp) {
			var status = (resp || {}).success || false,
				percentage = ((resp || {}).data || {}).percentage || 0
			;

			window.Wds.update_progress_bar(
				$progress_bar,
				percentage
			);

			update_progress_text(percentage);
			if (status && parseInt(percentage, 10) >= 100) {
				return on_complete();
			} else {
				Wds.update_checkup_progress($progress_bar, on_complete);
			}
		});
	};

	window.Wds.sui_tab_fix = function () {
		// Until shared UI starts working properly with the jQuery 1.12 we need to include jquery migrate
		$('.sui-tabs-menu label').click(function () {
			var $label = $(this);

			$label.find('input[type="radio"]').prop('checked', true).change();
		});
	}

})(jQuery);
