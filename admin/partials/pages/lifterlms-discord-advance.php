<form>
<input type="hidden" name="action" value="lifterlms_discord_advance_settings">
<?php wp_nonce_field( 'save_discord_adv_settings', 'ets_discord_save_adv_settings' ); ?>
 
<table class="form-table" role="presentation">
	<tbody>
	 <tr>
		<th scope="row"><?php echo __( 'Shortcode:', 'lifterlms-discord-add-on' ); ?></th>
	    <td> <fieldset>
                    [mepr_discord_button]
                    <br/>
                    <small><?php echo __( 'Use this shortcode to display Discord Connect button anywhere on your website, Optionally you can make your redirect url to that page on which the button shortcode is being added.', 'lifterlms-discord-add-on' ); ?></small>
		    </fieldset>
        </td>
	 </tr>


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
<!-- Membership welcome........-->
    <tr>
		<th scope="row"><?php echo __( 'LifterLMS welcome message', 'lifterlms-discord-add-on' ); ?></th>
		<td> 
            <fieldset>
                    <textarea class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_welcome_message" id="ets_lifterlms_discord_welcome_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_welcome_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_welcome_message ) ) ); } ?></textarea> 
                    <br/>
                    <small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME], [MEMBERSHIP_ENDDATE], [MEMBERSHIP_STARTDATE]</small>
		    </fieldset>
        </td>
	</tr>
<!--Send Membership........-->
    <tr>
		<th scope="row"><?php echo __( 'Send LifterLMS expiration warning message', 'lifterlms-discord-add-on' ); ?></th>
            <td> 
                <fieldset>
                    <input name="ets_lifterlms_discord_send_expiration_warning_dm" type="checkbox" id="ets_lifterlms_discord_send_expiration_warning_dm" 
                    <?php
                    if ( $ets_lifterlms_discord_send_expiration_warning_dm == true ) {
                        echo 'checked="checked"'; }
                    ?>
                     value="1">
		        </fieldset>
            </td>
	  </tr>
<!--Membership Expiration warning.......-->
    <tr>
		<th scope="row"><?php echo __( 'Lifterlms expiration warning message', 'lifterlms-discord-add-on' ); ?></th>
		<td>
            <fieldset>
                    <textarea  class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_expiration_warning_message" id="ets_lifterlms_discord_expiration_warning_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_expiration_warning_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_expiration_warning_message ) ) ); } ?></textarea> 
                    <br/>
                    <small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME], [MEMBERSHIP_ENDDATE], [MEMBERSHIP_STARTDATE]</small>
		    </fieldset>
        </td>
	</tr>
<!--Membership Expiration massage.......-->
    <tr>
		<th scope="row"><?php echo __( 'Send LifterLMS expired message', 'lifterlms-discord-add-on' ); ?></th>
		<td>
            <fieldset>
                    <input name="ets_lifterlms_discord_send_membership_expired_dm" type="checkbox" id="ets_lifterlms_discord_send_membership_expired_dm" 
                    <?php
                    if ( $ets_lifterlms_discord_send_membership_expired_dm == true ) {
                        echo 'checked="checked"'; }
                    ?>
                    value="1">
		    </fieldset>
        </td>
	</tr>
<!--Membership Expired massage.......-->

<tr>
	<th scope="row"><?php echo __( 'LifterLMS expired message', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
                <textarea  class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_expiration_expired_message" id="ets_lifterlms_discord_expiration_expired_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_expiration_expired_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_expiration_expired_message ) ) ); } ?></textarea> 
                <br/>
                <small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME]</small>
		</fieldset>
  </td>
</tr>
<!--Send Membership cancel massage.......-->
<tr>
	<th scope="row"><?php echo __( 'Send LifterLMS cancel message', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
            <fieldset>
                    <input name="ets_lifterlms_discord_send_membership_cancel_dm" type="checkbox" id="ets_lifterlms_discord_send_membership_cancel_dm" 
                    <?php
                    if ( $ets_lifterlms_discord_send_membership_cancel_dm == true ) {
                        echo 'checked="checked"'; }
                    ?>
                    value="1">
		    </fieldset>
    </td>
</tr>
<!--Membership cancel massage.......-->
<tr>
		<th scope="row"><?php echo __( 'LifterLMS cancel message', 'lifterlms-discord-add-on' ); ?></th>
		<td> 
            <fieldset>
                    <textarea  class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_cancel_message" id="ets_lifterlms_discord_cancel_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_cancel_message ) { echo esc_textarea( wp_unslash( stripslashes_deep ( $ets_lifterlms_discord_cancel_message ) ) ); } ?></textarea> 
                    <br/>
                    <small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME]</small>
		    </fieldset>
        </td>
</tr>
<!--Re-assign roles upon .......-->
<tr>
	<th scope="row"><?php echo __( 'Re-assign roles upon payment failure', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
                <input name="upon_failed_payment" type="checkbox" id="upon_failed_payment" 
                    <?php
                    if ( $upon_failed_payment == true ) {
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
                <input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
                <?php
                    if ( $retry_failed_api == true ) {
                        echo 'checked="checked"'; }
                    ?>
                value="1">
		</fieldset>
    </td>
</tr>
<!--API call .......-->
<tr>
	<th scope="row"><?php echo __( 'How many times a failed API call should get re-try', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		     <input name="ets_lifterlms_retry_api_count" type="number" min="1" id="ets_lifterlms_retry_api_count" value="<?php if ( isset( $retry_api_count ) ) { echo esc_attr( $retry_api_count ); } else { echo 1; } ?>">
		</fieldset>
    </td>
</tr> 
<tr>
	<th scope="row"><?php echo __( 'Set job queue concurrency', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		     <input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php if ( isset( $set_job_cnrc ) ) { echo esc_attr( $set_job_cnrc ); } else { echo 1; } ?>">
		</fieldset>
    </td>
</tr>
<tr>
	<th scope="row"><?php echo __( 'Set job queue batch size', 'lifterlms-discord-add-on' ); ?></th>
	<td> 
        <fieldset>
		      <input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php if ( isset( $set_job_q_batch_size ) ) { echo esc_attr( $set_job_q_batch_size ); } else { echo 10; } ?>">
		</fieldset>
    </td>
</tr>
<!--LOG API CALL-->
<tr>
	<th scope="row"><?php echo __( 'Log API calls response (For debugging purpose)', 'lifterlms-discord-add-on' ); ?></th>
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
<tbody> 
</table>
<!--Save button-bottom-->
<div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php echo __( 'Save Settings', 'lifterlms-discord-add-on' ); ?>
	</button>
</div>


</form>
