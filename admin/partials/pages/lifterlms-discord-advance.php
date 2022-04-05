<?php
$set_job_cnrc                                = sanitize_text_field( trim( get_option( 'set_job_cnrc' ) ) );
$set_job_q_batch_size                         = sanitize_text_field( trim( get_option( 'set_job_q_batch_size' ) ) );
$retry_failed_api                             = sanitize_text_field( trim( get_option( 'retry_failed_api' ) ) );
$log_api_res                                  = sanitize_text_field( trim( get_option( 'log_api_res' ) ) );

$ets_lifterlms_discord_send_welcome_dm            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
$ets_lifterlms_discord_welcome_message            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_welcome_message' ) ) );
$ets_lifterlms_discord_kick_upon_disconnect       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) ) );
$ets_lifterlms_retry_api_count                    = sanitize_text_field( trim( get_option( 'ets_lifterlms_retry_api_count' ) ) );

?>



<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php' ?>">
<input type="hidden" name="action" value="lifterlms_discord_advance_settings">


  

<table class="form-table" role="presentation">
<tbody>	
<tr>
	<th scope="row">
        <?php echo __( 'Send welcome message', 'lifterlms-discord-addon' ); ?>
    </th>
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

<tr>
		<th scope="row">
            <?php echo __( 'Welcome message', 'lifterlms-discord-addon' ); ?>
        </th>
	<td> 
        <fieldset>
            <textarea class="ets_lifterlms_discord_welcome_message" name="ets_lifterlms_discord_welcome_message" id="ets_lifterlms_discord_welcome_message" row="25" cols="50">
                    <?php if ( $ets_lifterlms_discord_welcome_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_welcome_message ) ) ); } ?>
            </textarea>
            <br/>
            
		</fieldset>
    </td>
</tr>

<tr>
	<th scope="row">
        <?php echo __( 'Do Not kick students upon disconnect', 'lifterlms-discord-addon' ); ?>
    </th>
	<td> 
    <fieldset>
            <input name="ets_lifterlms_discord_kick_upon_disconnect" type="checkbox" id="ets_lifterlms_discord_kick_upon_disconnect" 
           
            value="1">
	</fieldset>
    </td>
</tr>

<tr>
	<th scope="row"><?php echo __( 'How many times a failed API call should get re-try', 'lifterlms-discord-addon' ); ?></th>
	<td> 
        <fieldset>
		    <input name="ets_lifterlms_retry_api_count" type="number" min="1" id="ets_lifterlms_retry_api_count" value="<?php if ( isset( $retry_api_count ) ) { echo esc_attr( $retry_api_count ); } else { echo 1; } ?>">
	    </fieldset>
    </td>
</tr>

<tr>
	<th scope="row"><?php echo __( 'Set job queue concurrency', 'lifterlms-discord-addon' ); ?></th>
	<td> 
        <fieldset>
		    <input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php if ( isset( $set_job_cnrc ) ) { echo esc_attr( $set_job_cnrc ); } else { echo 1; } ?>">
		</fieldset>
    </td>
</tr>

<tr>
	<th scope="row"><?php echo __( 'Set job queue batch size', 'lifterlms-discord-addon' ); ?></th>
	<td>
        <fieldset>
		    <input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php if ( isset( $set_job_q_batch_size ) ) { echo esc_attr( $set_job_q_batch_size ); } else { echo 10; } ?>">
		</fieldset>
    </td>
</tr>

<tr>
		<th scope="row"><?php echo __( 'Retry Failed API calls', 'lifterlms-discord-addon' ); ?></th>
	<td> 
        <fieldset>
            <input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
            <?php
            if ( $retry_failed_api == true ) {
                echo 'checked="checked"'; }
            ?>
            value="1">
		</fieldset>
    </td>
</tr>

<tr>
	<th scope="row"><?php echo __( 'Log API calls response (For debugging purpose)', 'lifterlms-discord-addon' ); ?></th>
	<td> 
        <fieldset>
            <input name="log_api_res" type="checkbox" id="log_api_res" 
            <?php
            if ( $log_api_res == true ) {
                echo 'checked="checked"'; }
            ?>
            value="1">
		</fieldset>
    </td>
</tr>

	
</tbody>
</table>
  <div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php echo __( 'Save Settings', 'memberpress-discord-add-on' ); ?>
	</button>
  </div>
</form>
