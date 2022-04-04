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
<!-- Save Setting Massage -->
<?php

if ( isset( $_GET['save_settings_msg'] ) ) {
	?>
	<div class="notice notice-success is-dismissible support-success-msg">
		<p><?php echo esc_html( $_GET['save_settings_msg'] ); ?></p>
	</div>
	<?php
}
?>
<!-- This is Main Page LifterLms-Discord-Addon --->

<h1><?php echo __( 'LifterLMS Discord Add On Settings', 'lifterlms-discord-add-on' ); ?></h1>
		<div id="outer" class="skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
			
		<ul class="skltbs-tab-group">

				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_application" ><?php echo __( 'Application Details', 'lifterlms-discord-addon' ); ?><span class="initialtab spinner"></span></button>
				</li>	
				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="level-mapping" ><?php echo __( 'Role Mapping', 'lifterlms-discord-addon' ); ?></button>
				</li>
				<li class="skltbs-tab-item">
					<button class="skltbs-tab" data-identity="advanced-tab" data-toggle="tab" data-event="ets_advanced"><?php echo __( 'Advanced', 'lifterlms-discord-addon' ); ?>	</button>
				</li>
		</ul>
<!--Creating Tabs-->
            <div class="skltbs-panel-group">
				<div id='lifterlms_general_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-application-details.php'; ?>
				</div>

				<div id='lifterlms_role_level' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-role-level-map.php'; ?>
				</div>

				<div id='lifterlms_advanced_tab' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-advance.php'; ?>
				</div>

			</div>
    </div>
