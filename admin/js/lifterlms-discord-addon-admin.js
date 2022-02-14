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
							
						var activeTab = localStorage.getItem('activeTab');
							if ($('.ets-tabs button[data-identity="lifterlms_role_level_Support_settings"]').length == 0 && activeTab == 'lifterlms_role_level_Support_settings') {
								$('.ets-tabs button[data-identity="lifterlms_settings"]').trigger('click');
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
							});

							var defaultRole = $('#selected_default_role').val();
								if (defaultRole) {
									$('#defaultRole option[value=' + defaultRole + ']').prop('selected', true);
								}
								if (response.previous_mapping) {
									var mapjson = response.previous_mapping;
								} else {
									var mapjson = localStorage.getItem('LifterlmsMappingjson');
								}


								$("#maaping_json_val").html(mapjson);
								$.each(JSON.parse(mapjson), function (key, val) {
									var arrayofkey = key.split('id_');
									var preclone = $('*[data-role_id="' + val + '"]').clone();
									if(preclone.length>1){
										preclone.slice(1).hide();
									}
									if (jQuery('*[data-level_id="' + arrayofkey[1] + '"]').find('*[data-role_id="' + val + '"]').length == 0) {
										$('*[data-level_id="' + arrayofkey[1] + '"]').append(preclone).attr('data-drop-role_id', val).find('span').css({ 'order': '2' });
									}
									if ($('*[data-level_id="' + arrayofkey[1] + '"]').find('.makeMeDraggable').length >= 1) {
										$('*[data-level_id="' + arrayofkey[1] + '"]').droppable("destroy");
									}
									preclone.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '0px', 'order': '1' }).attr('data-level_id', arrayofkey[1]);
									makeDrag(preclone);
								});

					}
				},
				error: function (response) {
					$("#connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
					console.error(response);
				},
				complete: function () {
					$(".discord-roles .spinner").removeClass("is-active").css({ "float": "right" });
					$("#skeletabsTab1 .spinner").removeClass("is-active").css({ "float": "right", "display": "none" });
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
