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
<h1><?php echo __( 'lifterlms Discord Add On Settings', 'lifterlms-discord-add-on' ); ?></h1>
		<div id="outer" class ="skltbs-theme-light" data-skeletabs='{ "startIndex": 1 }'>
	
    <!-- include css file lifter.css here-->
        <ul class="lifterlms-tab-group">
				<li class="lifterlms-tab-item">
				<button class="skltbs-tab" data-identity="mepr_settings" ><?php echo __( 'Application details', 'lifterlms-discord-add-on' ); ?><span class="initialtab spinner"></span></button>
				</li>
				<?php if ( ets_memberpress_discord_check_saved_settings_status() ) : ?>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="level-mapping" ><?php echo __( 'Role Mappings', 'lifterlms-discord-add-on' ); ?></button>
				</li>
				<?php endif; ?>	
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="advanced" data-toggle="tab" data-event="ets_advanced"><?php echo __( 'Advanced', 'lifterlms-discord-add-on' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="logs" data-toggle="tab" data-event="ets_logs"><?php echo __( 'Logs', 'lifterlms-discord-add-on' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="docs" data-toggle="tab" data-event="ets_docs"><?php echo __( 'Documentation', 'lifterlms-discord-add-on' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="support" data-toggle="tab" data-event="ets_about_us"><?php echo __( 'Support', 'lifterlms-discord-add-on' ); ?>	
				</button>
				</li>
			</ul>
        <!-- create pages....-->    
			<div class="skltbs-panel-group">
				<div id='mepr_general_settings' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-settings.php'; ?>
				</div>
				<?php if ( ets_memberpress_discord_check_saved_settings_status() ) : ?>
				<div id='mepr_role_mapping' class="skltbs-panel">
					<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-role-level-map.php'; ?>
				</div>
				<?php endif; ?>
				<div id='mepr_advance' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-advance.php'; ?>
				</div>
				<div id='mepr_logs' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-error-log.php'; ?>
				</div>
				<div id='mepr_docs' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-documentation.php'; ?>
				</div>
				<div id='mepr_support' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-get-support.php'; ?>
				</div>
			</div>
		</div>
