(function($) {
	'use strict';
			/*Load all roles from discord server*/
			$.ajax({
					type: "POST",
					dataType: "JSON",
					url: ets_lifterlms_param.admin_ajax,
					data: { 'action': 'lifterlms_load_discord_roles', 'ets_lifterlms_discord_nonce': ets_lifterlms_param.ets_lifterlms_discord_nonce, },
					beforeSend: function () {
						$(".discord-roles .spinner").addClass("is-active");
						$(".initialtab.spinner").addClass("is-active");
			    	},
					success: function (response) {
						if (response != null && response.hasOwnProperty('code') && response.code == 50001 && response.message == 'Missing Access') {
							$(".btn-connect-to-bot").show();
						}
						 else if (response == null || response.message == '401: Unauthorized' || response.hasOwnProperty('code') || response == 0) {
							$("#connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
						} 
						 else {
							if ($('.skltbs-tab-group button[data-identity="lifterlms_role_level_Support_settings"]').length) {
								$('.skltbs-tab-group button[data-identity="lifterlms_role_level_Support_settings"]').show();
						     }
							 $("#connect-discord-bot").show().html("Bot Connected <i class='fab fa-discord'></i>").addClass('not-active');

							
							
							
					}
				}
			});

	 jQuery(".js-example-tags").select2({
		placeholder: "Select a Pages ",
		allowClear: true
		//tags: true
	   });

	   /*Tab options*/
	$.skeletabs.setDefaults({
		keyboard: false,
	});

})( jQuery );
