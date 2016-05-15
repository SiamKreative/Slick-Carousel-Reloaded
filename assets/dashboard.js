jQuery(document).ready(function ($) {

	/**
	 * Copy to clipboard
	 * https://github.com/zenorocha/clipboard.js/
	 */
	var clipboard = new Clipboard('.wpscr_copy_sc');

	clipboard.on('success', function (e) {
		var btnText = $(e.trigger).find('span');
		var defaultText = btnText.text();

		// Change text on success
		btnText.text(btnText.attr('data-copy-success'));

		// Restore default text after 2 seconds
		setTimeout(function () {
			btnText.text(defaultText);
		}, 2000);

		e.clearSelection();
	});

	/**
	 * Textarea Autosize
	 * https://github.com/jackmoore/autosize
	 */
	autosize($('#wpscr_slider_customparameters'));
	autosize($('#wpscr_slider_sc'));

	/**
	 * Loading Spinners
	 */
	$('.form-table .tf-radio-image input[type=radio]').on('change', function (event) {
		event.preventDefault();
		$(this).parents('label').siblings().removeClass('selected');
		if ($(this).is(':checked')) {
			$(this).parents('label').addClass('selected');
		}
	});
	$('.form-table .tf-radio-image input[type=radio]:checked').parents('label').addClass('selected');

});