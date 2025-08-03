<?php
//Global File Of WP Voting System By INFOTHEME INC.
//DEVELOPER: TEAM INFOTHEME
//PRO LICENSE REQUIRED TO RUN THIS TOOL
/***********************************************
ADDING MAIN MENU OF INFOTHEM PRODUCTS
************************************************/
// Add to admin_menu function

if( ! function_exists('itwpMods_ind_wp_addons')){

		add_action('admin_menu', 'itwpMods_ind_wp_addons');

		function itwpMods_ind_wp_addons() {
		
			add_menu_page(__('InfothemeWP'), __('InfothemeWP'), 'manage_options', 'itwpMods_addons', 'itwpMods_addons', '
		dashicons-info', 2); 
		
		}

}


if( ! function_exists('itwpMods_General_addSubMenu')){
		
		add_action('admin_menu', 'itwpMods_General_addSubMenu');

		function itwpMods_General_addSubMenu(){
			
			add_submenu_page('itwpMods_addons', __('INFOTHEME ADDONS'), __('Add Ons'), 'manage_options', 'itwpMods_addons', 'itwpMods_addons');
		
		}

}
define('ITEPOLL_SECKEY', 'hjkdnvu767327sf.3767dhjf'); 

define('ITEPOLL_HOST', 'https://infotheme.net'); 

define('IT_EPOLL_REF', 'EPOLL PLUGIN');


class itWPMOdsEPOLL_LC{
    public $lic;
    public $server;
    public $api_key;
    private $wp_option  = 'epoll_wp_itsSimpleNoCheatCode';
    private $product_id = '87';
    public $err;
    public function __construct($lic=false , $server , $api_key){
        if($this->is_licensed())
            $this->lic      =   get_option($this->wp_option);
        else
            $this->lic      =   $lic;

        $this->server   =   $server;
        $this->api_key  =   $api_key;
    }
    /**
     * check for current product if licensed
     * @return boolean 
     */
    public function is_licensed(){
        $lic = get_option($this->wp_option);
        if(!empty( $lic ))
            return true;
        return false;
    }

    /**
     * send query to server and try to active lisence
     * @return boolean
     */
    public function active(){
        $url = ITEPOLL_HOST . '/?secret_key=' . ITEPOLL_SECKEY . '&slm_action=slm_activate&license_key=' . $this->lic . '&registered_domain=' . get_bloginfo('siteurl').'&item_reference='.$this->product_id;
        $response = wp_remote_get($url, array('timeout' => 20, 'sslverify' => true));

        //print_r($url); exit;
        if(is_array($response)){
            $json = $response['body']; // use the content
            $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', utf8_encode($json));
            $license_data = json_decode($json);
        }
        if($license_data->result == 'success'){
            update_option( $this->wp_option, $this->lic );
            return true;
        }else{
            $this->err = $license_data->message;
            return false;
        }
    }

    /**
     * send query to server and try to deactive lisence
     * @return boolean
     */
    public function deactive(){

    }

}

//initializing page content of addons

if( ! function_exists('itwpMods_addons')){

	function itwpMods_addons(){
		include_once('core/wp_addons.php');
	}

}

//Initializing this plugins conf
include_once('library/Google2FAClass.php');
include_once('module_config.php');