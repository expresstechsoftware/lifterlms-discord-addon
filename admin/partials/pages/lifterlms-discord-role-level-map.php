<?php
$user_id             = sanitize_text_field( trim( get_current_user_id() ) );

$mpr_lifterlms        = get_posts( 
	                       array(
							'post_type' => 'Course', 
						    'post_status' => 'publish')
                         );

// $post = get_post(array('post_type' => 'course', 'post_status' => 'publish'));
// echo $post->post_title."<br>";
// echo $post->ID;
						 
 
$default_role        = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
$allow_none_member = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
?>
 <!-- Drag and Drop the Discord Roles  -->

<div class="notice notice-warning ets-notice">
	<p><i class='fas fa-info'></i> <?php echo __( 'Drag and Drop the Discord Roles over to the lifterlms Levels', 'lifterlms-discord-add-on' ); ?></p>
</div>


<div class="row-container">
	<div class="discord-roles-col">
		<h2><?php echo __( 'Discord Roles', 'lifterlms-discord-add-on' ); ?></h2>
		<hr>
		<div class="discord-roles">
			<span class="spinner"></span>
		</div>
	</div>

    <div class="ets-column">
		<h2><?php echo __( 'Lifterlms_Courses ', 'lifterlms-discord-add-on' ); ?></h2>
		<hr>
		<div class="lifterlms-courses">
			<?php
			  foreach ( array_reverse( $mpr_lifterlms ) as $key => $value ) {
				?>
				<div class="makeMeDroppable" data-course_id="<?php echo esc_attr( $value->ID ); ?>" ><span><?php echo esc_html( $value->post_title ); ?></span></div>
				<?php
			 }
			?>
		</div>
	</div>
</div>


<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php' ?>">
	<input type="hidden" name="action" value="lifterlms_discord_role_mapping">
	<table class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row"><label for="defaultRole"><?php echo __( 'Default Role', 'lifterlms-discord-add-on' ); ?></label></th>
			<td>
				<?php wp_nonce_field( 'discord_role_mappings_nonce', 'ets_lifterlms_discord_role_mappings_nonce' ); ?>
				<input type="hidden" id="selected_default_role" value="<?php echo esc_attr( $default_role ); ?>">
				<select id="defaultRole" name="defaultRole">
					<option value="none"><?php echo __( '-None-', 'lifterlms-discord-add-on' ); ?></option>
				</select>
			<p class="description"><?php echo __( 'This Role will be assigned to all level members', 'lifterlms-discord-add-on' ); ?></p>
			</td>
		</tr>

        
		<tr>
		<th scope="row"><label><?php echo __( 'Allow non-members', 'lifterlms-discord-add-on' ); ?></label></th>
		<td>
			<fieldset>
				<label><input type="radio" name="allow_none_member" value="yes"  
				<?php
				if ( 'yes' === $allow_none_member ) {
					echo 'checked="checked"'; }
				?>
				> <span><?php echo __( 'Yes', 'lifterlms-discord-add-on' ); ?></span></label><br>
				<label><input type="radio" name="allow_none_member" value="no" 
				<?php
				if ( empty( $allow_none_member ) || 'no' === $allow_none_member ) {
					echo 'checked="checked"'; }
				?>
				> <span><?php echo __( 'No', 'lifterlms-discord-add-on' ); ?></span></label>
				<p class="description"><?php echo __( 'This setting will apply on Cancel and Expiry of Membership' ); ?></p>
			</fieldset>
		</td>
		</tr>
	</tbody>
	</table>
	<br>


	<div class="mapping-json">
	<textarea id="maaping_json_val" name="ets_lifterlms_discord_role_mapping">
	<?php
	if ( isset( $ets_discord_roles ) ) {
		echo esc_html( $ets_discord_roles );}
	?>
	</textarea>
  </div>


  <div class="bottom-btn">
	<button type="submit" name="submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php echo __( 'Save Settings', 'lifterlms-discord-add-on' ); ?>
	</button>
	<button id="lifterlmsRevertMapping" name="flush" class="ets-submit ets-bg-red">
	  <?php echo __( 'Flush Mappings', 'lifterlms-discord-add-on' ); ?>
	</button>
  </div>
</form>
