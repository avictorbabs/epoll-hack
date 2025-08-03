<?php
/*
Plugin Name: WP Poll Survey & Voting System PRO
Plugin Uri: https://infotheme.in/plugins/epoll/v3/demo/
Description: The WP Poll Survey & Voting System is a unique advanced and stylish voting poll system designed to integrate voting / poll / survey / election quiz systems into your post, pages and everywhere in website by just a shortcode. Add poll system to your post by placing shortcode or add voting system into your website.
Author: InfoTheme
Author URI: https://www.infotheme.in
Version: 3.0
Tags: WordPress Plugin, wp voting, question andwer, q&a, wp poll system, poll plugin, survey plugin, wp poll, user poll, user voting, wp poll, poll system, add poll, wp poll system, ask question, forum, poll, voting system, wp voting, vote, vote system, posts, pages, category, plugin.
Text Domain: it_epoll
Licence: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


/*###############################################################
    EPOLL 3.0 PRO (A Complete Event/Contest/Voting System)
##############################################################*/

/*********Plugin Initialization*/
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**ACTIVATOR*/
register_activation_hook(__FILE__, 'it_epoll_activate');
if(function_exists('it_epoll_activate')){
	$plugin = dirname(__FILE__) . '/it-epoll.php';
	deactivate_plugins($plugin);
	wp_die('<div class="plugins"><h2>Epoll 3.0 Pro Plugin Activation Error!</h2><p style="background: #ffef80;padding: 10px 15px;border: 1px solid #ffc680;">We Found that you are using Our Plugin\'s Free Version, Please Deactivate Free Version & than try to re-activate it. Don\'t worry free plugins data will be automatically migrate into pro version. Thanks!</p></div>','Plugin Activation Error',array('response'=>200,'back_link'=>TRUE));
}
    if(!function_exists('it_epoll_activate')){
			function it_epoll_activate(){
				//Creating Database for Voting Results
				global $wpdb;
				$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table
			
				$charset_collate = $wpdb->get_charset_collate();
			
				$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`result_id` BIGINT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`poll_id` bigint(255) NOT NULL,
			`option_id` bigint(255) NOT NULL,
			`voter_data` longtext NOT NULL,
			`voter_email` varchar(255) NOT NULL,
			`voter_phone` varchar(50) NOT NULL,
			`voter_ip` varchar(255) NOT NULL,
			`voter_otp` varchar(6) NOT NULL,
			`voter_status` int(1) NOT NULL DEFAULT '0') $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			$success = empty($wpdb->last_error);
			
			return $success;
			/*****************************Create Voter Result Table End**********************/
			}
		}

//E Poll Deactivation
register_activation_hook(__FILE__, 'it_epoll_deactivate');
if(!function_exists('it_epoll_deactivate')){	
	function it_epoll_deactivate(){

	}
}

if( ! function_exists('it_epoll_plugin_conf')){
	//Global File Attach
	function it_epoll_plugin_conf(){
		if(!isset($_SESSION)){@session_start();}
		include_once('core.php');	
	}
	add_action('init','it_epoll_plugin_conf');	
}



if ( ! function_exists('it_epoll_poll_create_poll') ) {
function it_epoll_poll_create_poll() {

	$labels = array(
		'name'                => _x( 'Poll', 'Post Type General Name', 'it_epoll' ),
		'singular_name'       => _x( 'Poll', 'Post Type Singular Name', 'it_epoll' ),
		'menu_name'           => __( 'ePoll', 'it_epoll' ),
		'name_admin_bar'      => __( 'ePoll', 'it_epoll' ),
		'parent_item_colon'   => __( 'Parent Poll:', 'it_epoll' ),
		'all_items'           => __( 'All Polls', 'it_epoll' ),
		'add_new_item'        => __( 'Add New Poll', 'it_epoll' ),
		'add_new'             => __( 'Add New', 'it_epoll' ),
		'new_item'            => __( 'New Poll', 'it_epoll' ),
		'edit_item'           => __( 'Edit Poll', 'it_epoll' ),
		'update_item'         => __( 'Update Poll', 'it_epoll' ),
		'view_item'           => __( 'View Poll', 'it_epoll' ),
		'search_items'        => __( 'Search Poll', 'it_epoll' ),
		'not_found'           => __( 'Not found', 'it_epoll' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'it_epoll' ),
	);
	$args = array(
		'label'               => __( 'Poll', 'it_epoll' ),
		'description'         => __( 'Poll Description', 'it_epoll' ),
		'labels'              => $labels,
		'supports'            => array( 'title','thumbnail','revisions'),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'			  => 'dashicons-chart-pie',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite' 			  => array('slug' => 'poll'),
		'capability_type'     => 'page',
	);
	register_post_type( 'it_epoll_poll', $args );
	flush_rewrite_rules(true);
}

// Hook into the 'init' action
add_action( 'init', 'it_epoll_poll_create_poll', 0 );


}


//Adding Columns to epoll cpt

if(!function_exists('set_custom_edit_it_epoll_columns')){
	add_filter( 'manage_it_epoll_poll_posts_columns', 'set_custom_edit_it_epoll_columns' );
	function set_custom_edit_it_epoll_columns($columns) {
		$columns['total_option'] = __( 'Total Options', 'it_epoll' );
		$columns['poll_status'] = __( 'Poll Status', 'it_epoll' );
		$columns['shortcode'] = __( 'Shortcode', 'it_epoll' );
		$columns['view_result'] = __( 'View Result', 'it_epoll' );
		return $columns;
	}
}

if(!function_exists('custom_it_epoll_poll_column')){
// Add the data to the custom columns for the book post type:
add_action( 'manage_it_epoll_poll_posts_custom_column' , 'custom_it_epoll_poll_column', 10, 2 );
function custom_it_epoll_poll_column( $column, $post_id ) {
    switch ( $column ) {

        case 'shortcode' :
            $code = '<code>[IT_EPOLL id="'.$post_id.'"][/IT_EPOLL]</code>';
            if ( is_string( $code ) )
                echo $code;
            else
                _e( 'Unable to get shortcode', 'it_epoll' );
            break;
        case 'poll_status' :
        	echo "<span style='text-transform:uppercase'>".get_post_meta(get_the_id(),'it_epoll_poll_status',true)."</span>";
        	break;
        case 'total_option' :
        	if(get_post_meta($post_id,'it_epoll_poll_option',true)){
        		$total_opt = sizeof(get_post_meta($post_id,'it_epoll_poll_option',true));
        	}else{
        		$total_opt = 0;
        	}
        	echo $total_opt;
            break;
         case 'view_result' :
        	echo "<a target='_blank' href='".admin_url('admin.php?page=it_epoll_system&view=results&id='.$post_id)."' class='button button-primary'>View</a>";
        	break;
    }
}
}

//Add ePoll Admin Scripts
if(!function_exists('it_epoll_enqueue_newscript')){

	function it_epoll_enqueue_newscript(){
		wp_enqueue_script( 'it_epoll_ajax', plugins_url( '/assets/js/it_epoll_vote.js', __FILE__ ), array('jquery'),'3.1.3',false );
		wp_localize_script( 'it_epoll_ajax', 'it_epoll_ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );	
	}
	
	add_action( 'wp_enqueue_scripts', 'it_epoll_enqueue_newscript' );
}

if(!function_exists('it_epoll_js_register')){
	add_action( 'admin_enqueue_scripts', 'it_epoll_js_register' );
	
	function it_epoll_js_register() {
		wp_enqueue_script('media-upload');
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script('thickbox');
		wp_register_script('it_epoll_js', plugins_url('/assets/js/it_epoll.js',__FILE__ ), array('jquery','jquery-ui-core','media-upload','wp-color-picker','thickbox'));
	
		wp_enqueue_script('it_epoll_js');
	
		wp_register_script('it_epoll_contact_builder', plugins_url('/assets/js/it_epoll_contact_builder.js',__FILE__ ), array('jquery','thickbox','jquery-ui-core'));
		wp_enqueue_script('it_epoll_contact_builder');
	}
}

 
//Add ePoll Admin Style
if(!function_exists('it_epoll_css_register')){
	add_action( 'admin_enqueue_scripts', 'it_epoll_css_register' );

	function it_epoll_css_register() {
		wp_register_style('it_epoll_css', plugins_url('/assets/css/it_epoll.css',__FILE__ ),false,'3.1.3',false);
		wp_enqueue_style(array('thickbox','it_epoll_css'));
	}

}
	
//Add ePoll Frontend Style
if(!function_exists('it_epoll_enqueue_style')){
	add_action( 'wp_enqueue_scripts', 'it_epoll_enqueue_style' );
	
	function it_epoll_enqueue_style() {
		wp_enqueue_style( 'it_epoll_style', plugins_url('/assets/css/it_epoll_frontend.css',__FILE__ ), false,'3.1.3',false );
	}
}	

//Add ePoll Frontend Script
if(!function_exists('it_epoll_enqueue_script')){
	add_action( 'wp_enqueue_scripts', 'it_epoll_enqueue_script' );

	function it_epoll_enqueue_script() {
		wp_enqueue_script( 'it_epoll_validetta_script', plugins_url('/assets/js/jquery.validate.min.js',__FILE__ ), false );
		wp_enqueue_script( 'it_epoll_script', plugins_url('/assets/js/it_epoll_frontend.js',__FILE__ ), array('jquery'),'3.1.3',false );
	}
}
	
include_once('backend/it_epoll_shortcode.php');
include_once('backend/it_epoll_poll_metaboxes.php');	
include_once('frontend/it_epoll_poll.php');

if(!function_exists('get_it_epoll_poll_template')){
	add_filter( 'single_template', 'get_it_epoll_poll_template' );

	function get_it_epoll_poll_template($single_template) {
		global $post;
   
		if ($post->post_type == 'it_epoll_poll') {
			 $single_template = dirname( __FILE__ ) . '/frontend/it_epoll_poll-template.php';
		}
		return $single_template;
   }
}

if(!function_exists('ajax_it_epoll_vote')){
add_action( 'wp_ajax_it_epoll_vote', 'ajax_it_epoll_vote' );
add_action( 'wp_ajax_nopriv_it_epoll_vote', 'ajax_it_epoll_vote' );

function ajax_it_epoll_vote() {
	
	if(isset($_POST['action']) and $_POST['action'] == 'it_epoll_vote')
	{
		@session_start();
		if(isset($_POST['poll_id'])){
		$poll_id = intval(sanitize_text_field($_POST['poll_id']));
		}

		if(isset($_POST['option_id'])){
		$option_id = (float) sanitize_text_field($_POST['option_id']);
		}

		
		//Validate Poll ID
		if ( ! $poll_id ) {
		  $poll_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields are required")));
		}

		//Validate Option ID
		if ( ! $option_id ) {
		  $option_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		 die(json_encode(array("voting_status"=>"error","msg"=>"Fields are required")));
		}

		$oldest_vote = 0;
		$oldest_total_vote = 0;
		if(get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true)){
			$oldest_vote = get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true);	
		}
		if(get_post_meta($poll_id, 'it_epoll_vote_total_count')){
			$oldest_total_vote = get_post_meta($poll_id, 'it_epoll_vote_total_count',true);	
		}

		if(!it_epoll_check_for_unique_voting($poll_id,$option_id)){
				
		$new_total_vote = intval($oldest_total_vote) + 1;
		$new_vote = (int)$oldest_vote + 1;
		//echo $new_vote.'  id=it_epoll_vote_count_'.$option_id;
		update_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,$new_vote);
		update_post_meta($poll_id, 'it_epoll_vote_total_count',$new_total_vote);

		$multivote = false;
		if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
			$multivote = true;
		}

		$outputdata = array();
		$outputdata['total_vote_count'] = $new_total_vote;
		$outputdata['total_opt_vote_count'] = $new_vote;
		$outputdata['option_id'] = $option_id;
		$outputdata['voting_status'] = "done";
		$outputdata['multivote'] = $multivote;
		$outputdataPercentage = ($new_vote*100)/$new_total_vote;
		$outputdata['total_vote_percentage'] = (int)$outputdataPercentage;
		if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
			$_SESSION['it_epoll_session_'.$option_id] = uniqid();	
		}else{
			$_SESSION['it_epoll_session_'.$poll_id] = uniqid();
		}
		$ipAddress = it_epoll_get_ip_address();

		if(get_option('it_epoll_settings_uniqe_vote')){
			it_epoll_saveIPBasedData($poll_id,$option_id,"","","",$ipAddress,"",0);	
		}
		print_r(json_encode($outputdata));

		}
	}
	die();
}
}

if(!function_exists('ajax_it_epoll_vote_by_form')){		
add_action( 'wp_ajax_it_epoll_vote_by_form', 'ajax_it_epoll_vote_by_form' );
add_action( 'wp_ajax_nopriv_it_epoll_vote_by_form', 'ajax_it_epoll_vote_by_form' );

function ajax_it_epoll_vote_by_form(){
	
	if(isset($_POST['action']) and $_POST['action'] == 'it_epoll_vote_by_form')
	{

		@session_start();

		$data = array();
		if(isset($_POST['data'])){
			parse_str($_POST['data'],$data);
		}

		if(isset($_POST['poll_id'])){
		$poll_id = intval(sanitize_text_field($_POST['poll_id']));
		}

		if(isset($_POST['option_id'])){
		$option_id = (float) sanitize_text_field($_POST['option_id']);
		}

		//Validate Poll ID
		if ( ! $poll_id ) {
		  $poll_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields are required")));
		}

		//Validate Option ID
		if ( ! $option_id ) {
		  $option_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields are required")));
		}


		//Validate Data
		if ( ! $data ) {
		  $data = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		 die(json_encode(array("voting_status"=>"error","msg"=>"Fields are required")));
		}
		
		if(get_option('it_epoll_settings_enableOTP')){
			$Switcher = get_option('it_epoll_settings_enableOTP');
		}

		global $it_epoll_otp_code;

		$it_epoll_otp_code = it_epoll_generate_otp_code();

		$Email_To ="";
		$Phone_To ="";
		$sendSms = 0;
		$sendMail = 0;
		if($Switcher == 'email' || $Switcher == 'emailphone'){

			$email_data = get_option('it_epoll_settings_v_email_text');
			$email_title = get_option('it_epoll_settings_v_email_title');
			
			if(get_option('it_epoll_settings_reciever_email')){
				$Email_To = do_shortcode(get_option('it_epoll_settings_reciever_email'));
			}else{
				die(json_encode(array("voting_status"=>"error","msg"=>"Please Check Epoll Voting Plugin Setting: You Haven't Set Yet Receiever's Email Field")));
			}

			$Email_Content = do_shortcode($email_data);

			$Email_Subject = do_shortcode($email_title);

			// Sending otp to email
			$adminemail = get_bloginfo('admin_email');
			$blogname = get_bloginfo('name');
			$headers[] = 'From: '.$blogname.' <'.$adminemail.'>';
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$sendMail = 1;
		}

		if($Switcher == 'phone' || $Switcher == 'emailphone'){
			$phone_data = get_option('it_epoll_settings_v_phone_text');
			$phone_title = get_option('it_epoll_settings_v_phone_title');

			if(get_option('it_epoll_settings_reciever_mobile')){
				$Phone_To = intval(do_shortcode(get_option('it_epoll_settings_reciever_mobile')));
			}else{
				die(json_encode(array("voting_status"=>"error","msg"=>"Please Check Epoll Voting Plugin Setting: You Haven't Set Yet Receiever's Mobile Field")));
			}

			$Phone_Content = do_shortcode($phone_data);

			//Sending OTP to sms
			$sendSms = 1;

		}


		if($Switcher){
			//Asking to Verify Data
			$savedata ="";
			$savedata = serialize($data);
			$ipAddress = it_epoll_get_ip_address();
			if(it_epoll_saveIPBasedData($poll_id,$option_id,$Email_To,$Phone_To,$savedata,$ipAddress,$it_epoll_otp_code,0)){
				$outputdata = array();
				$outputdata['otp_email'] = $Email_To;
				$outputdata['otp_phone'] = $Phone_To;
				$outputdata['voting_status'] = 'otp_step';
				if($sendMail){
					wp_mail( $Email_To, $Email_Subject, $Email_Content, $headers );	
				}
				if($sendSms){
					if(it_epoll_send_sms($Phone_To,$Phone_Content)){}
				}
				if(!get_option('it_epoll_settings_enableOTP')){
					if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
					$_SESSION['it_epoll_session_'.$option_id] = uniqid();	
					}else{
						$_SESSION['it_epoll_session_'.$poll_id] = uniqid();
					}	
				}
				
				print_r(json_encode($outputdata));
			}else{
				if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
					$_SESSION['it_epoll_session_'.$option_id] = uniqid();	
				}else{
					$_SESSION['it_epoll_session_'.$poll_id] = uniqid();
				}
				die(json_encode(array("voting_status"=>"error","msg"=>"You Already Voted For This Candidate!")));
			}

		}else{
			$savedata ="";
			$savedata = serialize($data);
			$ipAddress = it_epoll_get_ip_address();
			if(it_epoll_saveIPBasedData($poll_id,$option_id,$Email_To,$Phone_To,$savedata,$ipAddress,$it_epoll_otp_code,0)){
				$oldest_vote = 0;
				$oldest_total_vote = 0;
				if(get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true)){
					$oldest_vote = get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true);	
				}
				if(get_post_meta($poll_id, 'it_epoll_vote_total_count')){
					$oldest_total_vote = get_post_meta($poll_id, 'it_epoll_vote_total_count',true);	
				}
			
				$new_total_vote = intval($oldest_total_vote) + 1;
				$new_vote = (int)$oldest_vote + 1;
				//echo $new_vote.'  id=it_epoll_vote_count_'.$option_id;
				update_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,$new_vote);
				update_post_meta($poll_id, 'it_epoll_vote_total_count',$new_total_vote);

				$outputdata = array();
				$outputdata['total_vote_count'] = $new_total_vote;
				$outputdata['total_opt_vote_count'] = $new_vote;
				$outputdata['option_id'] = $option_id;
				$outputdata['voting_status'] = 'done';
				$outputdataPercentage = ($new_vote*100)/$new_total_vote;
				$outputdata['total_vote_percentage'] = (int)$outputdataPercentage;
				if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
					$_SESSION['it_epoll_session_'.$option_id] = uniqid();	
				}else{
					$_SESSION['it_epoll_session_'.$poll_id] = uniqid();
				}
				print_r(json_encode($outputdata));
			}else{
				$_SESSION['it_epoll_session'] = uniqid();
				die(json_encode(array("voting_status"=>"error","msg"=>"You Already Voted For This Candidate!")));
			}

	}
	die();
	}
}
}
add_action( 'wp_ajax_it_epoll_vote_confirm', 'ajax_it_epoll_vote_confirm' );
add_action( 'wp_ajax_nopriv_it_epoll_vote_confirm', 'ajax_it_epoll_vote_confirm' );

function ajax_it_epoll_vote_confirm(){
	
	if(isset($_POST['action']) and $_POST['action'] == 'it_epoll_vote_confirm')
	{
		@session_start();

		$data = array();
		if(isset($_POST['data'])){
			parse_str($_POST['data'],$data);
		}
		if(isset($data['email'])){
			$email = sanitize_text_field($data['email']);
		}


		if(isset($data['phone'])){
			$phone = sanitize_text_field($data['phone']);
		}

		if(isset($_POST['poll_id'])){
		$poll_id = intval(sanitize_text_field($_POST['poll_id']));
		}

		if(isset($_POST['option_id'])){
		$option_id = (float) sanitize_text_field($_POST['option_id']);
		}

		if(isset($data['otp'])){
			$otp = sanitize_text_field($data['otp']);
		}


		//Validate Poll ID
		if ( ! $poll_id ) {
		  $poll_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields Are Requeired.")));
		}

		if ( ! $option_id ) {
		  $option_id = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields Are Requeired.")));
		}

		if (empty($email) and empty($phone)) {
		  $email = '';
		  $phone = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Mail and Phone Fields Are Requeired.")));
		}

		if ( ! $otp ) {
		  $otp = '';
		  $_SESSION['it_epoll_session'] = uniqid();
		  die(json_encode(array("voting_status"=>"error","msg"=>"Fields Are Requeired.")));
		}

		$ipAddress = it_epoll_get_ip_address();

		if(it_epoll_updateIPBasedData($poll_id, $option_id, $email, $phone, $ipAddress,$otp,1)){
				$oldest_vote = 0;
				$oldest_total_vote = 0;
				if(get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true)){
					$oldest_vote = get_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,true);	
				}
				if(get_post_meta($poll_id, 'it_epoll_vote_total_count')){
					$oldest_total_vote = get_post_meta($poll_id, 'it_epoll_vote_total_count',true);	
				}
			
				$new_total_vote = intval($oldest_total_vote) + 1;
				$new_vote = (int)$oldest_vote + 1;
				update_post_meta($poll_id, 'it_epoll_vote_count_'.$option_id,$new_vote);
				update_post_meta($poll_id, 'it_epoll_vote_total_count',$new_total_vote);

				$outputdata = array();
				$outputdata['total_vote_count'] = $new_total_vote;
				$outputdata['total_opt_vote_count'] = $new_vote;
				$outputdata['option_id'] = $option_id;
				$outputdata['voting_status'] = 'done';
				$outputdataPercentage = ($new_vote*100)/$new_total_vote;
				$outputdata['total_vote_percentage'] = (int)$outputdataPercentage;
				$_SESSION['it_epoll_session'] = uniqid();

				//Send email
				print_r(json_encode($outputdata));
		}else{
			die(json_encode(array("voting_status"=>"error","msg"=>"Inavlid OTP Code Entered By You Check Your Inbox.")));
		}
	}
	die();
}

function it_epoll_updateIPBasedData($poll_id, $option_id, $email=null, $phone=null, $ip,$otp=null,$status){

		global $wpdb;
		$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table

			if($email and !$phone){
				$sqli = "voter_email ='$email'";
			}
			if(!$email and $phone){
				$sqli = "voter_phone ='$phone'";
			}
			if($email and $phone){
				$sqli = "voter_email ='$email' or voter_phone='$phone'";
			}

			if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
				
				$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and option_id='$option_id' and ($sqli) and voter_otp='$otp' and voter_status!=1 limit 1" );
			}else{
				$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and ($sqli) and voter_otp='$otp' and voter_status!=1 limit 1");
			}

		if($voter_existing){
			if($phone && $email){
				$wpdb->update($table_name, array('voter_status'=>1), array('poll_id'=>$poll_id,'voter_otp'=>$otp,'option_id'=>$option_id,'voter_email'=>$email, 'voter_phone'=>$phone),array('%d'),array('%d','%s','%s','%s','%s'));	
			}elseif($phone && !$email){
				$wpdb->update($table_name, array('voter_status'=>1), array('poll_id'=>$poll_id,'voter_otp'=>$otp,'option_id'=>$option_id,'voter_phone'=>$phone),array('%d'),array('%d','%s','%s','%s'));
			}else{
				$wpdb->update($table_name, array('voter_status'=>1), array('poll_id'=>$poll_id,'voter_otp'=>$otp,'option_id'=>$option_id,'voter_email'=>$email),array('%d'),array('%d','%s','%s','%s'));
				
			}

			return 1;
		}else{
			return 0;
		}
}

function it_epoll_saveIPBasedData($poll_id, $option_id, $email=null,$phone=null,$data=null,$ip,$otp=null,$status=0){
	if($poll_id and $option_id and $ip and ($otp || $email || $phone)){
		//Save Contact Form Data

		global $wpdb;
		$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table
		//checking data
		if($email and !$phone){
			$sqli = "voter_email ='$email'";
		}
		if(!$email and $phone){
			$sqli = "voter_phone ='$phone'";
		}
		if($email and $phone){
			$sqli = "voter_email ='$email' or voter_phone='$phone'";
		}
		if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
			$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and option_id='$option_id' and ($sqli) and voter_status=1 limit 1" );
		}else{

			$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and ($sqli) and voter_status=1 limit 1" );
		}

		if(!$voter_existing){

				if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
				$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and option_id='$option_id' and ($sqli) and voter_status=0 limit 1" );
				}else{

					$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and ($sqli) and voter_status=0 limit 1" );
				}
				if($voter_existing){
					$wpdb->update($table_name, array('voter_otp'=>$otp), array('poll_id'=>$poll_id,'option_id'=>$option_id,'voter_email'=>$email, 'voter_phone'=>$phone),array('%s'),array('%d','%s','%s','%s','%s'));
				}else{
					$wpdb->insert(
				$table_name, 
				array( 
					'poll_id' => $poll_id,
					'option_id' => $option_id,
					'voter_data' => $data, 
					'voter_email' => $email, 
					'voter_phone' => $phone,
					'voter_ip' => $ip, 
					'voter_otp'=>$otp, 
					'voter_status' => $status
				),
				array( 
					'%d', 
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
				) 
			);
				}
			
			

			return 1;
		}else{
			return 0;
		}
		

	}elseif($poll_id and $ip and (!$otp || !$email || !$phone)){
		//Save Guest User Data
		global $wpdb;
		$table_name = $wpdb->prefix . "epoll_voting_results"; 
		if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
			$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and option_id='$option_id' and voter_ip='$ip' limit 1" );
		}else{
			$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and voter_ip='$ip' limit 1" );
		}

		if(!get_option('it_epoll_settings_uniqe_vote')){
			$voter_existing = 0;
		}

		if(!$voter_existing){
			$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table

			$wpdb->insert( 
				$table_name, 
				array( 
					'poll_id' => $poll_id, 
					'option_id' => $option_id,
					'voter_ip' => $ip,
					'voter_status' => $status
				),
				array(
					'%d',
					'%s',
					'%s',
					'%d'
				) 
			);
			return 1;
		}
		
	}else{
		return 0;
	}
}

if(!function_exists('it_epoll_register_button')){
	function it_epoll_register_button( $buttons ) {
		array_push( $buttons, "|", "it_epoll" );
		return $buttons;
	 }
}

if(!function_exists('it_epoll_add_plugin')){
	function it_epoll_add_plugin( $plugin_array ) {
	$plugin_array['it_epoll'] = plugins_url( '/assets/js/it_epoll_tinymce_btn.js', __FILE__ );
	return $plugin_array;
	}
}


if(!function_exists('it_epoll_tinymce_setup')){
	add_action('init', 'it_epoll_tinymce_setup');
	
	function it_epoll_tinymce_setup() {

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}

		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', 'it_epoll_add_plugin' );
			add_filter( 'mce_buttons', 'it_epoll_register_button' );
		}
	}
}

//Getting IP Address

function it_epoll_get_ip_address() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && it_epoll_validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (it_epoll_validate_ip($ip))
                    return $ip;
            }
        } else {
            if (it_epoll_validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && it_epoll_validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && it_epoll_validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && it_epoll_validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && it_epoll_validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function it_epoll_generate_otp_code(){
	if(get_option('it_epoll_settings_sec_salt')){
		$InitalizationKey = get_option('it_epoll_settings_sec_salt');
	}else{
		$InitalizationKey = "PEHMPSDNLXIOG65U";
	}
	$digits = 4;
	$otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
	//$otp       	  = strtoupper(bin2hex(openssl_random_pseudo_bytes(3))); // A smart code to generate OTP PIN.;	// Get current token
	return $otp;
}

function it_epoll_validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

function it_epoll_send_sms($mobile=null, $messege=null)
{
	$SMSapiKey = "";

	$ApiUrl = "";
	if(get_option('it_epoll_settings_apiUrl')){
		$ApiUrl = get_option('it_epoll_settings_apiUrl');
	}else{
		die(json_encode(array("voting_status"=>"error","msg"=>"Please Check Epoll Voting Plugin Setting: You Haven't Set Yet SMS API URL/Disabled SMS Based OTP to work this/Contact us")));
	}

	if(get_option('it_epoll_settings_apiKey')){
		$SMSapiKey = get_option('it_epoll_settings_apiKey');
	}else{
		die(json_encode(array("voting_status"=>"error","msg"=>"Please Check Epoll Voting Plugin Setting: You Haven't Set Yet SMS API KEY/Disabled SMS Based OTP to work this/Contact us")));
	}

	$url = $ApiUrl.'&APIKEY='.$SMSapiKey.'&MobileNo='.urlencode($mobile).'&Message='.urlencode($messege);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec($ch);
	curl_close($ch);
	//die($returndata);
	return 1;
}

if(!function_exists('it_epoll_check_for_unique_voting')){

function it_epoll_check_for_unique_voting($poll_id,$option_id){
		$voter_ip = it_epoll_get_ip_address();
		if(get_post_meta($poll_id,'it_epoll_poll_status',true) == 'end'){
			return true;
		}
		
		return false;//Added by Vick to allow same IP MULTIPLE VOOTING.

		if(get_option('it_epoll_settings_uniqe_vote')){

			global $wpdb;
			$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table
			if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
				$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and option_id='$option_id' and voter_ip = '$voter_ip' limit 1" );
			}else{
				$voter_existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where poll_id='$poll_id' and voter_ip = '$voter_ip' limit 1"); 
			}

			if($voter_existing){
				return true;
			}else{
				return false;
			}

		}else{
			
			
			if(get_post_meta($poll_id,'it_epoll_multivoting',true)){
					if(isset($_SESSION['it_epoll_session_'.$option_id])){
						return true;
					}else{
						return false;
					}
				}else{
					if(isset($_SESSION['it_epoll_session_'.$poll_id])){
						return true;
					}else{
						return false;
					}
				}
				
			if(isset($_SESSION['it_epoll_session'])){
				return true;
			}else{
				return false;
			}
		}
	    
}
}

if(!function_exists('it_epoll_get_voting_result')){

	function it_epoll_get_voting_result($poll_id,$option){
		global $wpdb;
		$table_name = $wpdb->prefix . "epoll_voting_results"; //Voting Result Table

		$it_ep_result = $wpdb->get_results( 
		"
		SELECT * 
		FROM $table_name
		WHERE poll_id = '$poll_id' 
			AND option_id = '$option'
		"
	);

		return $it_ep_result;
	}
}

//Deleting record
add_action( 'before_delete_post', 'it_epoll_delete_poll_result' );

function it_epoll_delete_poll_result($postid){
	// We check if the global post type isn't ours and just return
    global $post_type,$wpdb;  
    if ( $post_type != 'it_epoll_poll' ) return;
    $wpdb->delete( 'table', array( 'poll_id' => $postid), array( '%d' ) );
}

function it_epoll_get_forms_field_keys(){
	return get_option('it_epoll_settings_v_conformdata');
}

// Shortens a number and attaches K, M, B, etc. accordingly
if(!function_exists('it_epoll_number_shorten')){

	function it_epoll_number_shorten($num) {
	if($num>1000) {

			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array('k', 'm', 'b', 't');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];

			return $x_display;

	}

	return $num;
	}
}

if(!isset($_COOKIE["it_epoll_cookie_popup_new"])){
	setcookie("it_epoll_cookie_popup_new", "it_epoll_cookie_popup_show", time() + (86400 * 1), "/");
}

function it_epoll_show_popup(){

	if(get_option('it_epoll_settings_pollInpop')){
		if(!isset($_COOKIE["it_epoll_cookie_popup_new"])){
			setcookie("it_epoll_cookie_popup_new", "it_epoll_cookie_popup_show", time() + (86400 * 1), "/");
		?>
	<div class="it_epoll_modal_outer">
		<div class="it_epoll_modal_inner_container">
			<div class="it_epoll_modal_inner">
				<a href="javascript:void(0);" class="it_epoll_frontend_close_btn">Close</a>
				<div class="it_epoll_modal_header">
					<?php echo do_shortcode('[IT_EPOLL id="'.get_option('it_epoll_settings_pollInpop').'" type="list"][/IT_EPOLL]');?>		
				</div>
			</div>
		</div>
	</div>
<?php }
	}
}

add_action('wp_footer','it_epoll_show_popup');
include_once('backend/it_epoll_widget.php');
?>