(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// console.log(RechargeApiParams)

	jQuery(document).ready(function($) {
		
		$('#apiForm').submit(function(e) {
			e.preventDefault();
			
			var url = $('#url').val();
			var email = $('#email').val();
			var password = $('#password').val();
	
			$.ajax({
				type: 'POST',
				url: RechargeApiParams.admin_ajax,
				data: { 'action': 'recharge-api-add-new' ,'url': url, 'email': email, 'password':password },
				beforeSend: function() {
					$('#resultContainer').html('Loading......');
				},
				success: function(response) {
					$('#resultContainer').html(response);
				},
				error: function() {
					$('#resultContainer').html('Failed to connect.');
				}
			});
		});
	});
	


})( jQuery );
