<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
if ( isset( $_GET['save_settings_msg'] ) ) {
	?>
	<div class="notice notice-success is-dismissible support-success-msg">
		<p><?php echo esc_html( $_GET['save_settings_msg'] ); ?></p>
	</div>
	<?php
}
?>

<h1><?php echo __( 'LifterLMS Discord Add On Settings', 'lifterlms-discord-add-on' ); ?></h1>
		<div id="outer" class="skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
			
		<ul class="skltbs-tab-group">
				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_settings" ><?php echo __( 'Application Details', 'lifterlms-discord-add-on' ); ?><span class="initialtab spinner"></span></button>
				</li>

				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_role_level_Support_settings" ><?php echo __( 'Role Mapping', 'lifterlms-discord-add-on' ); ?></button>
				</li>

				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_advance_settings" ><?php echo __( 'Advanced', 'lifterlms-discord-add-on' ); ?></button>
				</li>
				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_documentation_settings" ><?php echo __( 'Documentation', 'lifterlms-discord-add-on' ); ?></button>
				</li>
				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_error_log_settings" ><?php echo __( 'Log', 'lifterlms-discord-add-on' ); ?></button>
				</li>

				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_get_Support_settings" ><?php echo __( 'Support', 'lifterlms-discord-add-on' ); ?></button>
				</li>

				
					
		</ul>


			<div class="skltbs-panel-group">

				<div id='lifterlms_general_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-application-details.php'; ?>
				</div>	
				
				<div id='lifterlms_role_level_Support_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-discord-role-level-map.php'; ?>
				</div>

				<div id='lifterlms_advance_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-discord-advance.php'; ?>
				</div>

				<div id='lifterlms_documentation_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-discord-documentation.php'; ?>
				</div>

				<div id='lifterlms_error_log_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-discord-error-log.php'; ?>
				</div>
				<div id='lifterlms_get_Support_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_PLUGIN_DIR . 'admin/partials/pages/lifterlms-discord-get-support.php'; ?>
				</div>


				

			</div>
		</div>
