<?php if(isset($_REQUEST['section'])){
//call register settings function
?>
	<div class="wrap" style="position: relative;">
<h1>Settings <sub style="color:orange">PRO</sub></h1>

<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system');?>" class=""><i class="dashicons dashicons-chart-bar"></i> View Results</a>
			</th>
			<th style="text-align: center;">
				<a href="<?php echo admin_url('post-new.php?post_type=it_epoll_poll');?>" class=""><i class="dashicons dashicons-chart-pie"></i> Create New Poll</a>
			</th>
			<th style="text-align: right;">
				<a href="https://infotheme.in/#support" class=""><i class="dashicons dashicons-sos"></i> Get Support</a>
			</th>
		</tr>
	</thead>
</table>
<?php 
 if (isset($_REQUEST['activate_license'])) {

	        $license_key = $_REQUEST['lc_key'];
	      
	        $lic    = new itWPMOdsEPOLL_LC($license_key , ITEPOLL_HOST , ITEPOLL_SECKEY );
	        
	        if($lic->active()){?>
	             <div class="updated notice">
				    <p>Thanks For Using Our Product!</p>
				</div>
	        <?php }else{?>
	          
			<div class="error notice">
			    <p><?php  echo $lic->err;?></p>
			</div>

	       <?php }

	    }?>
	
	<?php
$license_key ="";
    $lic = new itWPMOdsEPOLL_LC($license_key , ITEPOLL_HOST , ITEPOLL_SECKEY );
    if(!$lic->is_licensed()){ ?>
    	<div class="it_epoll_system_upgrade_pro">
		<div class="it_epoll_system_upgrade_pro_dotted_line"></div>
	    	<form autocomplete="off" action="" method="post" class="it_edb_pro_activation_form" name="infotheme_lc_activation" id="titlediv"> 

			<div class="dashicons dashicons-admin-network it_epoll_system_upgrade_pro_icon" style="color:#8BC34A !important;"></div>
			<input type="text" name="lc_key" id="title" value="" class="widefat" placeholder="Enter License Key" required title="Enter Valid License Key">
			<input type="hidden" name="lc_req" id="lc_req" value="<?php echo wp_create_nonce( 'infotheme_lc_activation' );?>" class="widefat" required>
			<input type="hidden" name="sendme" id="sendme" value="infotheme_lc_activation" class="widefat" required>
			<input type="hidden" name="product" id="product" value="product" class="widefat" required>
			<input type="hidden" name="callback_url" id="callback_url" value="<?php echo admin_url('admin.php?page=it_epoll_system&section=it_epoll_settings');?>" class="widefat" required>
			<input type="submit" name="activate_license" value="Activate Now" class="it_edb_submit it_epoll_system_activate_pro_btn" style="max-width:100%;"/>
			
			</form>	

		</div>
        <?php } ?>
        <form method="post" action="options.php">
		<?php settings_fields( 'it_epoll_system_settings' ); ?>	
        <?php do_settings_sections( 'it_epoll_system_settings' );?>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th style="text-align: center;" colspan="2">
				<h2>Customize Plugin As You Want!</h2>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2">
				
				<table class="widefat" style="max-width: 720px; margin:40px auto;">
					<tr>
						<th style="text-align: center;" colspan="2">
							<h3>General Settings</h3>
							<hr>
						</th>
					</tr>
					<tr>
						<td>
							<label>Enable Unique Vote</label>
						
							<select name="it_epoll_settings_uniqe_vote" class="widefat">
							<option value="0"<?php if(get_option('it_epoll_settings_uniqe_vote') == 0) echo ' selected';?>>No</option>
							<option value="1"<?php if(get_option('it_epoll_settings_uniqe_vote') == 1) echo ' selected';?>>Yes</option>
						</select>
						</td>
						<td>
							<label>Disable Brading</label>
							<select name="it_epoll_settings_disable_branding" class="widefat">
							<option value="0"<?php if(get_option('it_epoll_settings_disable_branding') == 0) echo ' selected';?>>No</option>
							<option value="1"<?php if(get_option('it_epoll_settings_disable_branding') == 1) echo ' selected';?>>Yes</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>
						<label>Show A Pole in Popup</label>
						<select class="widefat" id="it_epoll_settings_pollInpop" name="it_epoll_settings_pollInpop">
								<option value="0">None</option>
								<?php
											// WP_Query arguments
											$itepollBackednqueryargs = array(
												'post_type'              => array( 'it_epoll_poll' ),
												'post_status'            => array( 'publish' ),
												'nopaging'               => false,
												'paged'                  => '0',
												'posts_per_page'         => '20',
												'order'                  => 'DESC',
											);

											// The Query
											$itepollBackednquery = new WP_Query( $itepollBackednqueryargs );

											// The Loop
											$i=1;
											if ( $itepollBackednquery->have_posts() ) {
												while ( $itepollBackednquery->have_posts() ) {
													$itepollBackednquery->the_post();?>
													<option value="<?php echo get_the_id();?>"<?php if(get_option('it_epoll_settings_pollInpop') == get_the_id()) echo " selected";?>><?php echo the_title();?></option>
												<?php }
											}
											?>
							</select>
						</td>
					
						<td>
							<label>Enable OTP</label>
						
							<select name="it_epoll_settings_enableOTP" class="widefat">
							<option value="0"<?php if(get_option('it_epoll_settings_enableOTP') == 0) echo ' selected';?>>No</option>
							<option value="email"<?php if(get_option('it_epoll_settings_enableOTP') == "email") echo ' selected';?>>Email Based</option>
							<option value="phone"<?php if(get_option('it_epoll_settings_enableOTP') == "phone") echo ' selected';?>>Mobile Based</option>
							<option value="emailphone"<?php if(get_option('it_epoll_settings_enableOTP') == "emailphone") echo ' selected';?>>Both Type OTP</option>
						</select>
						</td>
					</tr>
					<tr>
						
						<td>
							<label>SMS API KEY</label>
						
							<input type="text" name="it_epoll_settings_apiKey" class="widefat" value="<?php if(get_option('it_epoll_settings_apiKey')) echo get_option('it_epoll_settings_apiKey');?>">
						</td>
						<td>
							<label>Enter OTP SALT</label>
						
							<input type="text" name="it_epoll_settings_sec_salt" class="widefat" value="<?php if(get_option('it_epoll_settings_sec_salt')) echo get_option('it_epoll_settings_sec_salt');?>" placeholder="A security key whatever you want eg: PEHMPSDNLXIOG65U">
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<label>SENDER API URL</label>
						
							<input type="url" name="it_epoll_settings_apiUrl" class="widefat" value="<?php if(get_option('it_epoll_settings_apiUrl')) echo get_option('it_epoll_settings_apiUrl');?>" placeholder="https://smsapiexample.com/?sender_id=EXAMPLEID&SERVICE_TYPE=TEMPLATE_BASED"> <br><br><a href="https://infotheme.in/buy-bulk-sms/" target="_blank" class="button button-primary">Get SMS API</a>
						</td>
					</tr>

					<tr>
						<td colspan="">
							<label>Receiver EMAIL Shortcode</label>
						
							<input type="text" name="it_epoll_settings_reciever_email" id="it_epoll_settings_reciever_email" class="widefat" value="<?php if(get_option('it_epoll_settings_reciever_email')) echo get_option('it_epoll_settings_reciever_email');?>" placeholder="Enter Reciever Email ShortCode eg:  [VOTER_DATA_VAL id='c2f5']">
						</td>
						<td colspan="">
							<label>Receiver Mobile Shortcode</label>
							<input type="text" name="it_epoll_settings_reciever_mobile" id="it_epoll_settings_reciever_mobile" class="widefat" value="<?php if(get_option('it_epoll_settings_reciever_mobile')) echo get_option('it_epoll_settings_reciever_mobile');?>" placeholder="Enter Reciever Email ShortCode eg:  [VOTER_DATA_VAL id='c2f5']">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label class="it_epoll_short_code">You can use these variable to send in mail/sms: [IT_EPOLL_OTP](Use For OTP Code), IT_EPOLL_VOTING] (Use For Poll Name), [IT_EPOLL_OPTION] (Use For POLL OPTION)<span class='it_epoll_msg_tags'><?php if(get_option('it_epoll_msg_tags')) echo get_option('it_epoll_msg_tags');?></span></label>
							<textarea id="it_epoll_msg_tags" style="display:none;" name="it_epoll_msg_tags"><?php if(get_option('it_epoll_msg_tags')) echo get_option('it_epoll_msg_tags');?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<label>VEIFICATION EMAIL SUBJECT</label>
							<input type="text" name="it_epoll_settings_v_email_title" id="it_epoll_settings_v_email_title" class="widefat" value="<?php if(get_option('it_epoll_settings_v_email_title')) echo get_option('it_epoll_settings_v_email_title');?>" placeholder="Enter Email Subject with/without Shortcode">
						</td>

					</tr>
					<tr>
						<td>
							<label>VEIFICATION EMAIL</label>
							<?php if(get_option('it_epoll_settings_v_email_text')) $it_epoll_tareaval = get_option('it_epoll_settings_v_email_text');?>
							<?php echo wp_editor( $it_epoll_tareaval, 'it_epoll_settings_v_email_text', array('textarea_rows'=>3,'teeny'=>true,'tinymce'=>true));?>
						</td>
						<td>
							<label>VEIFICATION SMS TEXT</label>
						
							<textarea name="it_epoll_settings_v_phone_text" class="widefat"  rows="10" placeholder="You Can use Above Given Variable Here"><?php if(get_option('it_epoll_settings_v_phone_text')) echo get_option('it_epoll_settings_v_phone_text');?></textarea>
							<input type="hidden" name="it_epoll_settings_v_data_assoc" value="<?php echo get_option('it_epoll_settings_v_data_assoc');?>" id="it_epoll_settings_v_data_assoc">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr>
							<label>REDEISGN CONTACT FORM</label>
							<table class="widefat">
								<thead>
									<tr c>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_form_title"><i class="dashicons dashicons-pin it_adm_ico_button_epoll"></i> Form Title</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_tel_num"><i class="dashicons dashicons-phone it_adm_ico_button_epoll"></i> Phone</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_name"><i class="dashicons 
dashicons-admin-users it_adm_ico_button_epoll"></i> NAME</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_email"><i class="dashicons 
dashicons-email it_adm_ico_button_epoll"></i> EMAIL</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_address"><i class="dashicons 
dashicons-location it_adm_ico_button_epoll"></i> ADDRESS</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_custom_text"><i class="dashicons 
dashicons-star-filled it_adm_ico_button_epoll"></i> TextField</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_custom_textarea"><i class="dashicons 
dashicons-star-filled it_adm_ico_button_epoll"></i>TEXTAREA</button></td>
										<td><button type="button" class="button button-secondary" id="iteditor_epoll_voter_submit_btn"><i class="dashicons 
dashicons-migrate it_adm_ico_button_epoll"></i> SUBMIT BUTTON</button></td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4">
											<textarea name="it_epoll_settings_v_conformdata" id="it_epoll_contact_builder_textarea" class="widefat" rows="12" placeholder="" readonly><?php if(get_option('it_epoll_settings_v_conformdata')) echo get_option('it_epoll_settings_v_conformdata');?></textarea>
										<button type="button" id="it_epoll_contact_builder_textarea_reset" class="button button-secondary"><i class="dashicons 
dashicons-update it_adm_ico_button_epoll"></i> Reset Design</button>
										</td>
										<td colspan="4">
											<div style="max-height: 300px; overflow-y:scroll;">
											<div class="it_epoll_contact_formbuilder_demo">
												<?php if(get_option('it_epoll_settings_v_conformdata')){}else{?>
												<h3 style="text-align: center; color:#fff;">Preview</h3>
											<?php } ?>
												<div class="it_epoll_contact_formbuilder_demo_content">
													<?php if(get_option('it_epoll_settings_v_conformdata')) echo do_shortcode(get_option('it_epoll_settings_v_conformdata'));?>
												</div>
											</div>
										</div>
										</td>
									</tr>
								</tbody>	
							</table>
						</td>
					</tr>
					<tr>
						<td style="text-align: center;" colspan="2">
							<hr>
							<button type="submit" name="it_epoll_settings_save" class="button button-primary">Save Settings</button>
							<button type="button" name="it_epoll_settings_cancel" onclick="window.location.reload();" class="button button-secondary">Cancel Changes</button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
</form>
</div>

<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>
<?php 
}else{
include_once('it_epoll_results.php');
?>
<?php }?>