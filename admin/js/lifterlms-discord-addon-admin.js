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
			});

				/*success: function (response) {
					if (response != null && response.hasOwnProperty('code') && response.code == 50001 && response.message == 'Missing Access') {
						$(".btn-connect-to-bot").show();
					} else if (response == null || response.message == '401: Unauthorized' || response.hasOwnProperty('code') || response == 0) {
						$("#connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
					} else {
						if ($('.ets-tabs button[data-identity="level-mapping"]').length) {
							$('.ets-tabs button[data-identity="level-mapping"]').show();
						}
						$("#connect-discord-bot").show().html("Bot Connected <i class='fab fa-discord'></i>").addClass('not-active');

						var activeTab = localStorage.getItem('activeTab');
						if ($('.ets-tabs button[data-identity="level-mapping"]').length == 0 && activeTab == 'level-mapping') {
							$('.ets-tabs button[data-identity="mepr_settings"]').trigger('click');
						}
						$.each(response, function (key, val) {
							var isbot = false;
							if (val.hasOwnProperty('tags')) {
								if (val.tags.hasOwnProperty('bot_id')) {
									isbot = true;
								}
							}

							if (key != 'previous_mapping' && isbot == false && val.name != '@everyone') {
								$('.discord-roles').append('<div class="makeMeDraggable" style="background-color:#' + val.color.toString(16) + '" data-role_id="' + val.id + '" >' + val.name + '</div>');
								$('#defaultRole').append('<option value="' + val.id + '" >' + val.name + '</option>');
								makeDrag($('.makeMeDraggable'));
							}
						 }
						 */
					 	
	
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
