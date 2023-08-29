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
					// console.log (response);
					$('#resultContainer').html(response);
				},
				error: function() {
					$('#resultContainer').html('Failed to connect.');
				}
			});
		});
	});

	jQuery(document).ready(function($) {
		$('.delete-row').on('click', function(e) {
			e.preventDefault();
	
			var rowId = $(this).data('id');
			var $row = $(this).closest('tr'); // Get the parent row
			var confirmDelete = confirm('Are you sure you want to delete this row?');
	
			if (confirmDelete) {
				$.ajax({
					url: RechargeApiParams.admin_ajax,
					type: 'POST',
					data: {
						action: 'delete_user_api_row',
						row_id: rowId,
					},
					success: function(response) {
						// Reload or update the table
						$row.remove();
						
					},
				});
			}
		});
	});

	jQuery(document).ready(function ($) {
        $('#run_recharge_manuelle').on('click', function () {
            var phone_number = $('#phone_number').val();

            $.ajax({
                type: 'POST',
                url: RechargeApiParams.admin_ajax,
                data: {
                    action: 'manual_recharge_request',
                    phone_number: phone_number,
                },
				beforeSend: function(){
					$('.result_manuelle').html('loading.....');
				},
                success: function (response) {
                    $('.result_manuelle').html(response);
                }
            });
        });
    });

	jQuery(document).ready(function ($) {
        $('#run_solde').on('click', function () {
            var device_id = $('#device_id').val();

            $.ajax({
                type: 'POST',
                url: RechargeApiParams.admin_ajax,
                data: {
                    action: 'check_solde',
                    device_id: device_id,
                },
				beforeSend: function(){
					$('.result_manuelle').html('loading.....');
				},
                success: function (response) {
                    $('.result_manuelle').html(response);
                }
            });
        });
    });
	
	
	$.skeletabs.setDefaults({
		keyboard: false,
	}); 

})( jQuery );
