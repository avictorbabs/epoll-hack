<?php
/*shortcode*/

function it_epoll_voter_data_val_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'id'	=> '',
		),
		$atts
	));

	$data = array();
	parse_str($_POST['data'],$dataa);
	return $dataa[$id];
}

add_shortcode( 'VOTER_DATA_VAL', 'it_epoll_voter_data_val_shortcode' );


function it_epoll_voter_epoll_voting_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'id'	=> '',
		),
		$atts
	));

	$data = array();
	$title="Poll Name";
	$title = get_the_title( $_POST['poll_id'] );
	return $title;
}

add_shortcode( 'IT_EPOLL_VOTING', 'it_epoll_voter_epoll_voting_shortcode' );


add_shortcode( 'VOTER_DATA_VAL', 'it_epoll_voter_data_val_shortcode' );


function it_epoll_voter_epoll_option_voting_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'id'	=> '',
		),
		$atts
	));
	$option_name = "";
	$it_epoll_option_names = get_post_meta($_POST['poll_id'], 'it_epoll_poll_option', true );

	if($it_epoll_option_names){
		$i=0;
		foreach ($it_epoll_option_names as $it_epoll_option_name) {

			$it_epoll_poll_option_id = get_post_meta($_POST['poll_id'], 'it_epoll_poll_option_id', true );

			if($it_epoll_poll_option_id[$i] == $_POST['option_id']){
				$option_name = $it_epoll_option_name;
			}
			$i++;
		}
	}
	return $option_name;
}

add_shortcode( 'IT_EPOLL_OPTION', 'it_epoll_voter_epoll_option_voting_shortcode' );


function it_epoll_voter_epoll_otp_voting_shortcode( $atts ) {
	extract(shortcode_atts(
		array(
			'id'	=> '',
		),
		$atts
	));
	global $it_epoll_otp_code;
	if(!$it_epoll_otp_code){
		$it_epoll_otp_code = it_epoll_generate_otp_code();
	}

	return $it_epoll_otp_code;
}

add_shortcode( 'IT_EPOLL_OTP', 'it_epoll_voter_epoll_otp_voting_shortcode' );


// VOTER NAME Shortcode
function it_epoll_voter_name_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Name',
			'id'	=> '',
		),
		$atts
	));
	if(is_admin()){
		$it_eshortcode = '<div class="it_edb_input_container">
	<label>'.$label.'</label>
	<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="off">
	</div>';
	}else{
		$it_eshortcode = '<div class="it_edb_input_container">
		<label>'.$label.'</label>
		<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" required autocomplete="off" data-validetta="required">
		</div>';
	}
	

	return $it_eshortcode;

}
add_shortcode( 'VOTER_NAME', 'it_epoll_voter_name_shortcode' );


// VOTER NAME Shortcode
function it_epoll_voter_form_title_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Enter Your Details'
		),
		$atts
	));
	$it_eshortcode = '<h3 class="it_epoll_voting_confirmation_poll_title">'.$label.'</h3>';

	return $it_eshortcode;

}
add_shortcode( 'VOTE_FORM_TITLE', 'it_epoll_voter_form_title_shortcode' );


 
function it_epoll_voter_telnum_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Mobile',
			'id' => '',
		),
		$atts
	));
	if(is_admin()){
	$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label>
	<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'" maxlength="12">
	</div>';

	}else{
		$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label>
		<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" pattern="\d*" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'" required  data-validetta="required" maxlength="12">
		</div>';

	}
	
	return $it_eshortcode;
}
add_shortcode( 'VOTER_TEL_NUM', 'it_epoll_voter_telnum_shortcode' );




function it_epoll_voter_email_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Email',
			'id' => '',
		),
		$atts
	));
	if(is_admin()){
		$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label>
		<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="email" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input"  autocomplete="off">
		</div>';

	}else{
		$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label>
		<input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="email" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="off" required>
		</div>';

	}
	

	return $it_eshortcode;
}
add_shortcode( 'VOTER_EMAIL', 'it_epoll_voter_email_shortcode' );


function it_epoll_voter_addr_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Address',
			'id' => '',
		),
		$atts
	));
	
	
	if(is_admin()){
		$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'">
		</div>';
	}else{
		$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'" required>
		</div>';
	}
	return $it_eshortcode;
}
add_shortcode( 'VOTER_ADDRESS', 'it_epoll_voter_addr_shortcode' );




function it_epoll_voter_ctext_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Custom Text',
			'id' => '',
		),
		$atts
	));
	if(is_admin()){
	$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'"></div>';
	
	}else{
	$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><input type="text" name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_input" autocomplete="VOTER_text_'.uniqid().'" required></div>';
		
	}
	return $it_eshortcode;
}

add_shortcode( 'VOTER_CTEXT', 'it_epoll_voter_ctext_shortcode' );


function it_epoll_voter_ctextarea_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Your Custom Textarea',
			'id' => '',
		),
		$atts
	));
	if(is_admin()){
	$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><textarea name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_textarea" autocomplete="VOTER_text_'.uniqid().'"></textarea></div>';
	
	}else{
	$it_eshortcode = '<div class="it_edb_input_container"><label>'.$label.'</label><input type="hidden" name="'.$id.'_label" value="'.$label.'" required/><textarea name="'.$id.'" value="" placeholder="'.$label.'" class="it_epoll_cform_input it_edb_textarea" autocomplete="VOTER_text_'.uniqid().'" required></textarea></div>';
	
	}
	return $it_eshortcode;
}

add_shortcode( 'VOTER_CTEXTAREA', 'it_epoll_voter_ctextarea_shortcode' );

function it_epoll_voter_sbmt_btn_shortcode( $atts ) {

	// Attributes
	extract(shortcode_atts(
		array(
			'label' => 'Vote Now',
		),
		$atts
	));
	$name = 'submit_button';
	$it_eshortcode = '<div class="it_edb_input_container"><input type="submit" name="'.$name.'" value="'.$label.'" class="it_epoll_cform_input it_edb_submit"></div>';
	return $it_eshortcode;
}
add_shortcode( 'VOTER_SUBMIT_BTN', 'it_epoll_voter_sbmt_btn_shortcode' ); 
?>