<?php if(isset($_REQUEST['view'])){?>
<div class="wrap" style="position: relative;">
<h1>Voting Results <sub style="color:orange">PRO</sub></h1>
<?php if($_REQUEST['view'] == 'voter_details'){?>

<?php 
 if (isset($_REQUEST['activate_license'])) {

	        $license_key = $_REQUEST['lc_key'];
	      
	        $lic    = new itWPMOdsEPOLL_LC($license_key , ITEPOLL_HOST , ITEPOLL_SECKEY );
	        print_r($lic->active());
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

<table class="wp-table widefat fixed striped posts">
	<thead>
		<tr>
			<th>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system&view=results&id='.$_REQUEST["id"].'');?>" class=""><i class="dashicons dashicons-arrow-left-alt"></i> Go Back</a>
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
if(!isset($_REQUEST['id']) and !isset($_REQUEST['option'])){
	die("Nothing Found");
 }else{
 	$id = $_REQUEST['id'];
 	$option = $_REQUEST['option'];
 } 
 ?>
<?php 

if(it_epoll_get_voting_result($id,$option)){
	$itepres = it_epoll_get_voting_result($id,$option);?>
	<table class="wp-table widefat fixed striped posts it_epoll_sys_show_voter_table">
	<thead>
		<tr>
			<th>
				Voter Details
			</th>
			<th>
				Voter's IP
			</th>
			<th>
				Status
			</th>
		</tr>
	</thead>
	<tbody>
		<?php 
	foreach ( $itepres as $itepresult )
	{ ?>
		<tr>
			<td>
				<?php if($itepresult->voter_data){
					$voter_data = @unserialize($itepresult->voter_data);
					if($voter_data){
						$i =0;?>
						<table class="wp-table widefat fixed striped posts it_epoll_sys_show_voter_table bordered">
						<?php
						foreach($voter_data as $vdkey => $vdval){?>
							<?php 
							if($vdkey !='submit_button'){
								if ($i % 2 == 0){
									echo '<tr><th><strong>'.$vdval.' :</strong></th>';
								}else{
									echo '<td><span class="it_epoll_badge_label">'.$vdval.'</span></td></tr>';
								}

							}
							$i++;
								}?>
							</table>
							<?php	
						}
					
				}else{
					echo 'N/A';
				}
				?>
			</td>
			<td><?php if($itepresult->voter_ip){
				echo $itepresult->voter_ip;
			}else{
				echo 'N/A';
			}?></td>
			<td>
				<?php if($itepresult->voter_status == 1){
					echo "OTP Verified";
				}else{
					echo "Not Verified Via OTP";
				}?>
			</td>
		</tr>
	<?php }?>
</tbody>
</table>
	
<?php }else{?>
<table class="wp-table widefat fixed striped posts it_epoll_sys_show_voter_table">
	<tbody>
		<tr>
			<td style="text-align: center;">
				<h3>Please Keep Patience because we didn't get any records related to this poll / Please confirm you have set "Enable Unique Vote => Yes" from settings</h3>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system&section=it_epoll_settings');?>" class="button button-secondary"><i class="dashicons dashicons-hammer"></i> Change Settings</a>
			</td>
		</tr>
	</tbody>
</table>
<?php }?>
<?php }else{?>
<?php 
 if (isset($_REQUEST['activate_license'])) {

	        $license_key = $_REQUEST['lc_key'];
	      
	        $lic    = new itWPMOdsEPOLL_LC($license_key , ITEPOLL_HOST , ITEPOLL_SECKEY );
	        print_r($lic->active());
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
	$license_key = "";
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
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system');?>" class=""><i class="dashicons dashicons-arrow-left-alt"></i> Go Back</a>
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
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		
		<?php 
		if(!isset($_REQUEST['id'])){
			die("Invalid Poll");
		}else{
			$pid = $_REQUEST['id'];
		}
		$it_epoll_poll_vote_total_count = (int)get_post_meta($pid, 'it_epoll_vote_total_count',true);
		$it_epoll_option_names = array();
		$it_epoll_option_names = get_post_meta( $pid, 'it_epoll_poll_option', true );
		$it_epoll_poll_option_id = array();
		$it_epoll_poll_option_id = get_post_meta( $pid, 'it_epoll_poll_option_id', true );


		$i=0;
		$count_array = array();
		$winnerAr=array();
		if($it_epoll_option_names){?>
			<tr>
				<th>
					Canidate / Option Name
				</th>
				<th>
					Total Votes
				</th>
				<th>
					Votes in (x/x)
				</th>
				<th>
					Live Result
				</th>
				<th>
					Voter Details
				</th>
			</tr>
			<?php
			foreach($it_epoll_option_names as $it_epoll_option_name):
			$it_epoll_poll_vote_count = (int)get_post_meta($pid, 'it_epoll_vote_count_'.(float)$it_epoll_poll_option_id[$i],true);
					
				 array_push($winnerAr,$it_epoll_poll_vote_count);
				 $i++; endforeach;
				 if (count(array_keys($winnerAr, max($winnerAr))) > 1){
					$winner = sizeof($winnerAr)+1;
				 }else{
					$winner = array_keys($winnerAr, max($winnerAr));
					$winner = $winner[0];
				 }
				$j = 0;
		foreach($it_epoll_option_names as $it_epoll_option_name):
			$it_epoll_option_id = $it_epoll_poll_option_id[$j];
			$it_epoll_poll_vote_count = (int)get_post_meta($pid, 'it_epoll_vote_count_'.(float)$it_epoll_option_id,true);
			$it_epoll_poll_vote_percentage = "$it_epoll_poll_vote_count/$it_epoll_poll_vote_total_count";		
			?>
		<tr>
			<th>
				<?php echo $it_epoll_option_names[$j];?>
			</th>
			<th>
				<?php echo $it_epoll_poll_vote_count;?>
			</th>
			<th>
				<?php echo $it_epoll_poll_vote_percentage;?>
			</th>
			<th>
				<?php if($j == $winner){?>
					<?php if(get_post_meta($pid,'it_epoll_poll_status',true) != 'live'){?>
						<span class="it_epoll_winner_result_badge">Winner</span>
					<?php }else{?>	
					<span class="it_epoll_winner_result_badge">Winner</span> <sup class="it_epoll_winner_result_badge_text">Now</sup>
					<?php }}elseif(get_post_meta($pid,'it_epoll_poll_status',true) != 'live'){?>
						<span class="it_epoll_leading_result_badge">Participated</span>
					<?php }else{?>
					<span class="it_epoll_leading_result_badge">Leading</span> <sup class="it_epoll_winner_result_badge_text">Now</sup>
				<?php  } ?>
					
			</th>
			<th>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system&view=voter_details&id='.$_REQUEST["id"].'&option='.$it_epoll_option_id);?>" class="button button-secondary">View</a>		
			</th>
		</tr>
		<?php $j++; endforeach;
			}else{?>
				<tr>
						<td colspan="5" style="text-align: center;">
							<h2>OOPS! it seems you didn't created any options for this poll!</h2>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align: center;">
							<a href="<?php echo admin_url('post.php?post='.$_REQUEST["id"].'&action=edit');?>" class="button button-secondary"><i class="dashicons dashicons-chart-pie"></i> Edit This Poll</a>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align: center;">
							
						</td>
					</tr>
			<?php }
		?>
	</thead>
</table>
<?php }?>
<?php }else{?>
<div class="wrap" style="position: relative;">
<h1>Voting Results <sub style="color:orange">PRO</sub></h1>

<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th>
				<a href="<?php echo admin_url('admin.php?page=it_epoll_system&section=it_epoll_settings');?>" class=""><i class="dashicons dashicons-hammer"></i> Change Settings</a>
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
<table class="wp-table widefat">
	<thead>
		<tr>
			<th>
			ID
			</th>
		<th>
			Voting / Poll Name
		</th>
		<th>
			Status
		</th>
		<th>
			Total Votes
		</th>
		<th>
			Total Candidates / Options
		</th>
		<th>
			Action
		</th>
	</tr>
	</thead>
	<tbody>
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
						
							<tr>
							<td class="has-row-actions column-primary">
								<?php the_id();?>

							</td>
							<td>
								<?php the_title();?>
							</td>
							<td>
								<?php echo get_post_meta(get_the_id(),'it_epoll_poll_status',true);?>
							</td>
							<td>
								<?php 
								if(get_post_meta(get_the_id(),'it_epoll_vote_total_count',true)) echo get_post_meta(get_the_id(),'it_epoll_vote_total_count',true); else echo 0;?>
							</td>
							<td>
								<?php 
									if(get_post_meta(get_the_id(),'it_epoll_poll_option',true)){

										echo sizeof(get_post_meta(get_the_id(),'it_epoll_poll_option',true));	
										}else{
											echo '0';
										}
								?>
							</td>
							<td>
								<a href="<?php echo admin_url('admin.php?page=it_epoll_system&view=results&id='.get_the_id());?>" class="button button-secondary">View</a>
							</td>
						</tr>
				<?php $i++;	}
				} else {?>
					<tr>
						<td colspan="6" style="text-align: center;">
							<h2>OOPS! You have no poll created yet!</h2>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: center;">
							<a href="<?php echo admin_url('post-new.php?post_type=it_epoll_poll');?>" class="button button-secondary"><i class="dashicons dashicons-chart-pie"></i> Create New Poll</a>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: center;">
							
						</td>
					</tr>
				<?php }

				// Restore original Post Data
				wp_reset_postdata();
				?>
	</tbody>
</table>
</div>
<?php }?>