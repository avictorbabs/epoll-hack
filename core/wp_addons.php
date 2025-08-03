<div class="wrap" style="overflow: hidden;">
			<h1 class="wp-heading-inline">AddOns</h1>
			<hr class="wp-header-end">
			<div class="theme-browser rendered">
				<div class="themes wp-clearfix">
					<?php

						 $url = 'https://infotheme.net/wp-backend-view-modules/';
					        $response = wp_remote_get($url, array('timeout' => 20, 'sslverify' => true));

					        if(is_array($response)){
								print_r($response['body']);
								exit;
					        }else{
					        	echo "Unable to Connect with InfoTheme Pro Server. Contact Us at support@infotheme.net";
					        	exit;
					        }?>
			
	</div>
</div>	
</div>	