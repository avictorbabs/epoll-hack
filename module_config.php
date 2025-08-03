<?php

/************************************************************************
		Add Plugin Menus
***************************************************************************/


//Voting Settings Menu Add


if( ! function_exists('it_epoll_settings_menu')){
		
		add_action('admin_menu', 'it_epoll_settings_menu');

		function it_epoll_settings_menu(){
			
			add_submenu_page('itwpMods_addons', __('Voting System'), __('Voting System'), 'administrator', 'it_epoll_system', 'it_epoll_system');
		add_action( 'admin_init', 'it_epoll_system_settings' );

		}

}

	function it_epoll_system_settings() {
	//register our settings
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_uniqe_vote' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_pollInpop' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_disable_branding' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_enableOTP' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_apiKey' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_apiUrl' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_v_email_title' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_v_email_text' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_v_phone_text' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_v_conformdata' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_msg_tags' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_sec_salt' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_reciever_email' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_reciever_mobile' );
	register_setting( 'it_epoll_system_settings', 'it_epoll_settings_v_data_assoc' );
}

//Voting Settings Page Callabck


if( ! function_exists('it_epoll_system')){


		function it_epoll_system(){

			include_once('backend/it_epoll_setting.php');

		}

}
?>