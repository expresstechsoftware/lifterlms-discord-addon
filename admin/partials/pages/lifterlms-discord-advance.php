<?php

$ets_lifterlms_discord_send_welcome_dm            =   sanitize_text_field( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) );
$ets_lifterlms_discord_welcome_message            =   sanitize_text_field( get_option( 'ets_lifterlms_discord_welcome_message' ) );
$ets_lifterlms_discord_kick_upon_disconnect       =   sanitize_text_field( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) );
$ets_lifterlms_discord_retry_failed_api           =   sanitize_text_field( get_option( 'ets_lifterlms_discord_retry_failed_api' ));
$ets_lifterlms_discord_retry_api_count            =   sanitize_text_field( get_option( 'ets_lifterlms_discord_retry_api_count' ) );
$ets_lifterlms_discord_job_queue_concurrency      =   sanitize_text_field( get_option( 'ets_lifterlms_discord_job_queue_concurrency' ));
$ets_lifterlms_discord_job_queue_batch_size       =   sanitize_text_field( get_option( 'ets_lifterlms_discord_job_queue_batch_size' ) );
$ets_lifterlms_discord_log_api_response           =   sanitize_text_field( get_option( 'ets_lifterlms_discord_log_api_response' ) );

?>

<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php' ?>">
<input type="hidden" name="action" value="lifterlms_discord_advance_settings">
<?php wp_nonce_field( 'save_discord_adv_settings', 'ets_discord_save_adv_settings' ); ?>
 
<table class="form-table" role="presentation">
	<tbody>
	 
<!-- ets_lifterlms_discord_send_welcome_dm-->
    <tr>
		<th scope="row"><?php echo __( 'Send welcome message', 'lifterlms-discord-add-on' ); ?></th>
        <td> 
            <fieldset>
                    <input name="ets_lifterlms_discord_send_welcome_dm" type="checkbox" id="ets_lifterlms_discord_send_welcome_dm" 
                    <?php
                    if ( $ets_lifterlms_discord_send_welcome_dm == true ) {
                        echo 'checked="checked"'; }
                    ?>
                    value="1">
            </fieldset>
        </td>
	</tr> 


<!-- Welcome message........-->
    <tr>
		<th scope="row"><?php echo __( 'Welcome message', 'lifterlms-discord-add-on' ); ?></th>
		<td> 
            <fieldset>
                    <textarea class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_welcome_message" id="ets_lifterlms_discord_welcome_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_welcome_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_welcome_message ) ) ); } ?></textarea> 
                    <br/>
                    <small>Merge fields: Hi [LP_STUDENT_NAME] ([LP_STUDENT_EMAIL]), Welcome, Your courses [LP_COURSES],'</small>
		    </fieldset>
        </td>
	</tr>

<!--Do not kick students upon disconnect........-->
    <tr>
		<th scope="row"><?php echo __( 'Do not kick students upon disconnect', 'lifterlms-discord-add-on' ); ?></th>
            <td> 
                <fieldset>
                    <input name="ets_lifterlms_discord_kick_upon_disconnect" type="checkbox" id="ets_lifterlms_discord_kick_upon_disconnect" 
                    <?php
                    if ( $ets_lifterlms_discord_kick_upon_disconnect == true ) {
                        echo 'checked="checked"'; }
                    ?>
                     value="1">
		        </fieldset>
            </td>
	  </tr>
<!--Retry failed API calls .......-->
<tr>
	<th scope="row"><?php echo __( 'Retry Failed API calls', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
                <input name="ets_lifterlms_discord_retry_failed_api" type="checkbox" id="ets_lifterlms_discord_retry_failed_api" 
                    <?php
                    if ( $ets_lifterlms_discord_retry_failed_api == true ) {
                        echo 'checked="checked"'; }
                    ?>
                value="1">
		</fieldset>
    </td>
</tr>

<!--How many times a failed API call should get re-try .......-->
<tr>
	<th scope="row"><?php echo __( 'How many times a failed API call should get re-try', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		     <input name="ets_lifterlms_discord_retry_api_count" type="number" min="1" id="ets_lifterlms_discord_retry_api_count" value="<?php if ( isset( $retry_api_count ) ) { echo esc_attr( $retry_api_count ); } else { echo 1; } ?>">
		</fieldset>
    </td>
</tr> 

<!--ets_lifterlms_discord_job_queue_concurrency .......-->

<tr>
	<th scope="row"><?php echo __( 'Set job queue concurrency', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		     <input name="ets_lifterlms_discord_job_queue_concurrency" type="number" min="1" id="ets_lifterlms_discord_job_queue_concurrency" value="<?php if ( isset( $set_job_cnrc ) ) { echo esc_attr( $set_job_cnrc ); } else { echo 1; } ?>">
		</fieldset>
    </td>
</tr>


<tr>
	<th scope="row"><?php echo __( 'Set job queue batch size', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		      <input name="ets_lifterlms_discord_job_queue_batch_size" type="number" min="1" id="ets_lifterlms_discord_job_queue_batch_size" value="<?php if ( isset( $set_job_q_batch_size ) ) { echo esc_attr( $set_job_q_batch_size ); } else { echo 10; } ?>">
		</fieldset>
    </td>
</tr>
<!--LOG API CALL-->
<tr>
	<th scope="row"><?php echo __( 'Log API calls response (For debugging purpose)', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
                <input name="ets_lifterlms_discord_log_api_response" type="checkbox" id="ets_lifterlms_discord_log_api_response" 
                    <?php
                    if ( $ets_lifterlms_discord_log_api_response == true ) {
                        echo 'checked="checked"'; }
                    ?>
                value="1">
		</fieldset>
    </td>
</tr>
<tbody> 
</table>
<!--Save button-bottom-->
<div class="bottom-btn">
	<button type="submit" name="advance_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php echo __( 'Save Settings', 'lifterlms-discord-add-on' ); ?>
	</button>
</div>

</form>
