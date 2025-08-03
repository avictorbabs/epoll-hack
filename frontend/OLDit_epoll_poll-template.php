<?php
if (!isset($_SESSION)) session_start();
get_header();

while ( have_posts() ) : the_post();
			$it_epoll_option_names = array();
			if(get_post_meta( get_the_id(), 'it_epoll_poll_option', true )){
				$it_epoll_option_names = get_post_meta( get_the_id(), 'it_epoll_poll_option', true );	
			}
			$it_epoll_option_imgs = array();
			$it_epoll_option_imgs = get_post_meta( get_the_id(), 'it_epoll_poll_option_img', true );
			$it_epoll_poll_option_cover_img = array();
			$it_epoll_poll_option_cover_img = get_post_meta( get_the_id(), 'it_epoll_poll_option_cover_img', true );
			$it_epoll_poll_status = get_post_meta( get_the_id(), 'it_epoll_poll_status', true );
			$it_epoll_poll_option_id = get_post_meta( get_the_id(), 'it_epoll_poll_option_id', true );
			$it_epoll_poll_style = get_post_meta( get_the_id(), 'it_epoll_poll_style', true );
			$it_epoll_poll_vote_total_count = (int)get_post_meta(get_the_id(), 'it_epoll_vote_total_count',true);
			$it_epoll_poll_ui = get_post_meta( get_the_id(), 'it_epoll_poll_ui', true );
			$it_epoll_multivoting = get_post_meta( get_the_id(), 'it_epoll_multivoting', true );
			$it_epoll_poll_container_color_primary = get_post_meta( get_the_id(), 'it_epoll_poll_container_color_primary', true );
			$it_epoll_poll_container_color_secondary = get_post_meta( get_the_id(), 'it_epoll_poll_container_color_secondary', true );

			$it_epoll_poll_btn_style = get_post_meta( get_the_id(), 'it_epoll_poll_btn_style', true );

			if($it_epoll_poll_btn_style == 'purple'){
				$it_epoll_poll_btn_class = 'it_epoll_purple_gradient';
			}elseif($it_epoll_poll_btn_style == 'aqua'){
				$it_epoll_poll_btn_class = 'it_epoll_aqua_gradient';
			}elseif($it_epoll_poll_btn_style == 'blue'){
				$it_epoll_poll_btn_class = 'it_epoll_blue_gradient';
			}else{
				$it_epoll_poll_btn_class = 'it_epoll_orange_gradient';
			}
			?>
			<div class="it_epoll_container"<?php if($it_epoll_poll_container_color_primary and $it_epoll_poll_container_color_secondary){?> style="background: -webkit-linear-gradient(40deg,<?php echo $it_epoll_poll_container_color_secondary;?>,<?php echo $it_epoll_poll_container_color_primary;?>)!important;
    background: -o-linear-gradient(40deg,<?php echo $it_epoll_poll_container_color_secondary;?>,<?php echo $it_epoll_poll_container_color_primary;?>)!important;
    background: linear-gradient(40deg,<?php echo $it_epoll_poll_container_color_secondary;?>,<?php echo $it_epoll_poll_container_color_primary;?>)!important;<?php }?>">
				<h1 class="it_epoll_title">
					<span class="it_epoll_title_exact"><?php the_title();?></span>
				  <span class="it_epoll_survey-stage">
				  <span class="it_epoll_stage it_epoll_live it_epoll_active" <?php if($it_epoll_poll_status !== 'live') echo 'style="display:none;"';?>>Live</span>
				  <span class="it_epoll_stage it_epoll_ended it_epoll_active" <?php if($it_epoll_poll_status !== 'end') echo 'style="display:none;"';?>>Ended</span>
				  </span>
				</h1>
				<div class="it_epoll_inner">
				<ul class="it_epoll_surveys <?php if($it_epoll_poll_style == 'list') echo 'it_epoll_list'; else echo 'it_epoll_grid';?>">
		<?php
			$i=0;
			if($it_epoll_option_names){
			foreach($it_epoll_option_names as $it_epoll_option_name):
			$it_epoll_poll_vote_count = (int)get_post_meta(get_the_id(), 'it_epoll_vote_count_'.(float)$it_epoll_poll_option_id[$i],true);
			//print_r($it_epoll_poll_option_id[$i]);
			$it_epoll_poll_vote_percentage =0;
			if($it_epoll_poll_vote_count == 0){
			$it_epoll_poll_vote_percentage =0;
			}else{
			$it_epoll_poll_vote_percentage = (int)$it_epoll_poll_vote_count*100/$it_epoll_poll_vote_total_count; 
			}
			$it_epoll_poll_vote_percentage = (int)$it_epoll_poll_vote_percentage;
			?>
			
			<?php if($it_epoll_poll_style == 'list'){?>
				<li class="it_epoll_survey-item">
					<input type="hidden" name="it_epoll_multivoting" value="<?php echo $it_epoll_multivoting;?>" id="it_epoll_multivoting">
				
			<div class="it_epoll_survey-item-inner">
				<div class="it_epoll_survey-name">
				  <?php echo $it_epoll_option_name;?>
				</div>

			<div class="it_epoll_survey-item-action <?php if(it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])) echo 'it_epoll_survey-item-action-disabled';?>">
				<?php if(!it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])):?>
				<form action="" name="it_epoll_survey-item-action-form" class="it_epoll_survey-item-action-form">
					<input type="hidden" name="it_epoll_poll-id" id="it_epoll_poll-id" value="<?php echo get_the_id();?>">
					<input type="hidden" name="it_epoll_survey-item-id" id="it_epoll_survey-item-id" value="<?php echo $it_epoll_poll_option_id[$i];?>">
					<input type="button" name="it_epoll_survey-vote-button" id="it_epoll_survey-vote-button" class="<?php echo $it_epoll_poll_btn_class;?>" value="Vote">
				</form>
				<?php else:?>
					<span class="it_epoll_green_gradient it_epoll_list_style_already_voted">Already Voted</span>
				<?php endif;?>
			</div>
				<div class="it_epoll_spinner">
						<svg version="1.1" id="it_epoll_tick" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 				viewBox="0 0 37 37" xml:space="preserve">
						<path class="it_epoll_circ it_epoll_path" style="fill:none;stroke: #ffffff;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;" d="
						M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z"
						/>
							<polyline class="it_epoll_tick it_epoll_path" style="fill:none;stroke: #ffffff;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;" points="
						11.6,20 15.9,24.2 26.4,13.8 "/>
						</svg>
				  </div>
				<div class="it_epoll_pull">

				  <span class="it_epoll_survey-progress">
					<span class="it_epoll_survey-progress-bg">
					  <span class="it_epoll_survey-progress-fg <?php echo $it_epoll_poll_btn_class;?>" style="width:<?php echo $it_epoll_poll_vote_percentage;?>%;"></span>
				  </span>

				  <span class="it_epoll_survey-progress-labels">
					  <span class="it_epoll_survey-progress-label">
						<?php echo $it_epoll_poll_vote_percentage;?>%
					  </span>

				  <input type="hidden" name="it_epoll_poll_e_vote_count" id="it_epoll_poll_e_vote_count" value="<?php echo $it_epoll_poll_vote_count;?>"/>
				  <span class="it_epoll_survey-completes">
						<?php echo it_epoll_number_shorten($it_epoll_poll_vote_count)." / ".it_epoll_number_shorten($it_epoll_poll_vote_total_count);?>
					  </span>
				  </span>
				  </span>
				</div>
				</div>
		  </li>
			<?php }else{?>
		  <li class="it_epoll_survey-item">
		  	<input type="hidden" name="it_epoll_multivoting" value="<?php echo $it_epoll_multivoting;?>" id="it_epoll_multivoting">
				
			<div class="it_epoll_survey-item-inner it_epoll_card_front">
				<div class="it_epoll_big_cover<?php echo ' '.$it_epoll_poll_btn_class;?>">
					 <?php if($it_epoll_poll_option_cover_img){
	
						 	if(isset($it_epoll_poll_option_cover_img[$i])){
							 	echo '<img src="'.$it_epoll_poll_option_cover_img[$i].'">';
							 }
					}?>	
				</div>
				
				<?php if(isset($it_epoll_option_imgs[$i])){?>
				<div class="it_epoll_survey-country it_epoll_grid-only">
				  <img src="<?php echo $it_epoll_option_imgs[$i];?>">
				  <div class="it_epoll_spinner">
				  	<svg version="1.1" id="it_epoll_tick" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 				viewBox="0 0 37 37" xml:space="preserve">
					<path class="it_epoll_circ it_epoll_path" style="fill:none;stroke: #ffffff;stroke-width:1.5;stroke-linejoin:round;stroke-miterlimit:10;" d="
				M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z"
				/>
					<polyline class="it_epoll_tick it_epoll_path" style="fill:none;stroke: #ffffff;stroke-width:1.5;stroke-linejoin:round;stroke-miterlimit:10;" points="
				11.6,20 15.9,24.2 26.4,13.8 "/>
				</svg>
				  </div>
				</div>

				<?php }?>
				<div class="it_epoll_survey-name">
				  <?php echo $it_epoll_option_name;?>
				</div>
				<?php if(get_option('it_epoll_settings_enableOTP') and get_post_meta(get_the_id(),'it_epoll_poll_ui',true)){?>
					<?php if(!it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])){?>
					<div class="it_epoll_survey-item-action<?php if(it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])) echo ' it_epoll_survey-item-action-disabled';?>">
						<form action="" name="it_epoll_survey-item-action-form" class="it_epoll_survey-item-action-form">
						<input type="hidden" name="it_epoll_poll-id" id="it_epoll_poll-id" value="<?php echo get_the_id();?>">
						<input type="hidden" name="it_epoll_survey-item-id" id="it_epoll_survey-item-id" value="<?php echo $it_epoll_poll_option_id[$i];?>">
						<input type="button" name="it_epoll_survey-vote-button" id="it_epoll_survey-confirm-button" class="it_epoll_survey-confirm-button <?php echo $it_epoll_poll_btn_class;?>" value="Vote">
						</form>
					</div>
				<?php }else{ echo '<span style="border-top:1px solid #ccc;border-bottom:1px solid #ccc; padding:0px; margin:5px; display:inline-block; color: #fc6462;">You Already Participated!</span>';}}else{?>
			<div class="it_epoll_survey-item-action <?php if(it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])) echo 'it_epoll_survey-item-action-disabled';?>">
				<?php if(!it_epoll_check_for_unique_voting(get_the_id(),$it_epoll_poll_option_id[$i])):?>
				<form action="" name="" class="it_epoll_survey-item-action-form">
					<input type="hidden" name="it_epoll_poll-id" id="it_epoll_poll-id" value="<?php echo get_the_id();?>">
					<input type="hidden" name="it_epoll_survey-item-id" id="it_epoll_survey-item-id" value="<?php echo $it_epoll_poll_option_id[$i];?>">
					<input type="button" name="it_epoll_survey-vote-button" id="it_epoll_survey-vote-button" class="<?php echo $it_epoll_poll_btn_class;?>" value="Vote">
				</form>
				<?php endif;?>
			</div>
		<?php } ?>

				<div class="it_epoll_pull-right">

				  <span class="it_epoll_survey-progress">
					<span class="it_epoll_survey-progress-bg">
					  <span class="it_epoll_survey-progress-fg <?php echo $it_epoll_poll_btn_class;?>" style="width:<?php echo $it_epoll_poll_vote_percentage;?>%;"></span>
				  </span>

				  <span class="it_epoll_survey-progress-labels">
					  <span class="it_epoll_survey-progress-label">
						<?php echo $it_epoll_poll_vote_percentage;?>%
					  </span>
					  <input type="hidden" name="it_epoll_poll_e_vote_count" id="it_epoll_poll_e_vote_count" value="<?php echo $it_epoll_poll_vote_count;?>"/>
				  <span class="it_epoll_survey-completes">
						<?php echo it_epoll_number_shorten($it_epoll_poll_vote_count)." / ".it_epoll_number_shorten($it_epoll_poll_vote_total_count);?>
					  </span>
				  </span>
				  </span>
				</div>

				</div>
				<?php if(get_option('it_epoll_settings_enableOTP') and get_post_meta(get_the_id(),'it_epoll_poll_ui',true)){?>
				<div class="it_epoll_survey-item-inner it_epoll_card_back" id="it_epoll_otp_confirm_vote">
					<form class="it_epoll_survey_confirmation_form" id="it_epoll_survey_confirmation_form" name="it_epoll_survey_confirmation_form" action="" method="post" autocomplete="off">
						<?php echo do_shortcode(get_option('it_epoll_settings_v_conformdata'));?>
					</form>
				</div>
				<div class="it_epoll_survey-item-inner it_epoll_card_back" id="it_epoll_otp_confirm_form">
					<form class="it_epoll_survey_confirmation_form" id="it_epoll_otp_confirmation_form" name="it_epoll_otp_confirmation_form" action="" method="post" autocomplete="off">
						<h3 class="it_epoll_voting_confirmation_poll_title">Confirm OTP</h3>
						<div class="it_epoll_short_code" style="margin:15px;">Please Check Your Mail Box / Message Box</div>
						<div class="it_edb_input_container"><label>Enter OTP Code</label><input type="text" name="otp" value="" placeholder="Enter OTP CODE" class="it_epoll_cform_input it_edb_input" autocomplete="off" required>
						<input type="hidden" id="email_otp_confirm_input" name="email" value="">
						<input type="hidden" id="phone_otp_confirm_input" name="phone" value="">	
						</div>
						<div class="it_edb_input_container"><input type="submit" name="confirmNow" value="Confirm" class="it_epoll_cform_input it_edb_submit"></div>
					</form>
				</div>
		<?php } ?>
		  </li>
		<?php }?>
<?php
	$i++;
	endforeach;
	echo '</ul> <div style="clear:both;"></div>';	
			}else{
				if( current_user_can('author') || current_user_can('editor') || current_user_can('administrator') ){
					_e('<p class="it_epoll_short_code">Please add some questions or may be you missed the option field.</p><br><a href="'.get_edit_post_link(get_the_id()).'" class="it_epoll_survey-notfound-button" style="width:auto;max-width:100%;">Edit This Poll</a>','it_epoll');
				}else{
					_e('<p class="it_epoll_short_code">This Poll is not yet ready contact site administrator</p>','it_epoll');
				}
				
			}?>
	 
	</div>

	<?php if(get_option('it_epoll_settings_disable_branding')){?>
	<?php }else{?>
	<div class="it_epoll_powered_by">
		<a href="https://wordpress.org/plugins/epoll-wp-voting/" target="_blank" rel="nofollow">Via WP Poll & Voting System</a>
	</div>
<?php } ?>
</div>

<?php endwhile;?>
<?php 
get_footer();
?>