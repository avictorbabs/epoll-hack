/*IT EPOLL CONTACT FOR BUILDER*/
jQuery.noConflict();

function it_epoll_generateUUID() { // Public Domain/MIT
    var d = new Date().getTime();
    if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
        d += performance.now(); //use high-precision timer if available
    }
    return 'xxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}


jQuery(document).ready(function($){
	var it_eplediprefx = '#iteditor_epoll_';
	//Action Tele Button

	jQuery(it_eplediprefx+'voter_tel_num').on('click',function(){

		var ele_val = prompt("Enter Label", "Your Mobile Number");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_TEL_NUM label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').text(jQuery('.it_epoll_msg_tags').text()+', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');


		if(!jQuery('#it_epoll_settings_reciever_mobile').val()){
			jQuery('#it_epoll_settings_reciever_mobile').val('[VOTER_DATA_VAL id=\''+ele_id+'\']');
		}

	});
	//Action Name Button
	jQuery(it_eplediprefx+'voter_name').on('click',function(){
		var ele_val = prompt("Enter Label", "Your Name");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_NAME label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').text(jQuery('.it_epoll_msg_tags').text()+', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');
	});
	//Action Email Button
	jQuery(it_eplediprefx+'voter_email').on('click',function(){
		var ele_val = prompt("Enter Label", "Your Email");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_EMAIL label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').text(jQuery('.it_epoll_msg_tags').text()+', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');
		
		if(!jQuery('#it_epoll_settings_reciever_email').val()){
			jQuery('#it_epoll_settings_reciever_email').val('[VOTER_DATA_VAL id=\''+ele_id+'\']');
		}
	});
	//Action ADDRESS Button
	jQuery(it_eplediprefx+'voter_address').on('click',function(){
		var ele_val = prompt("Enter Label", "Your Address");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_ADDRESS label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').appned(', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');
	});

	//Action ADDRESS Button
	jQuery(it_eplediprefx+'form_title').on('click',function(){
		var ele_val = prompt("Enter Label", "Enter Your Details");
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTE_FORM_TITLE label="'+ele_val+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo_prev').fadeOut();

		//jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
	
	});
	//Action CUSTOM TEXT
	jQuery(it_eplediprefx+'voter_custom_text').on('click',function(){
		var ele_val = prompt("Enter Label", "");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_CTEXT label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_input"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').text(jQuery('.it_epoll_msg_tags').text()+', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');
	});
	//Action CUSTOM TEXTAREA
	jQuery(it_eplediprefx+'voter_custom_textarea').on('click',function(){
		var ele_val = prompt("Enter Label", "");
		var ele_id = it_epoll_generateUUID();
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_CTEXTAREA label="'+ele_val+'" id="'+ele_id+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><label>'+ele_val+'</label><div class="it_edb_textarea"></div></div>');
		jQuery('#it_epoll_msg_tags').val(jQuery('#it_epoll_msg_tags').val()+', [VOTER_DATA_VAL id="'+ele_id+'"]');
		jQuery('.it_epoll_msg_tags').text(jQuery('.it_epoll_msg_tags').text()+', [VOTER_DATA_VAL id=\''+ele_id+'\']');
		jQuery('#it_epoll_settings_v_data_assoc').val(jQuery('#it_epoll_settings_v_data_assoc').val()+ele_id+'='+ele_val+'&');
	});
	//Action CUSTOM TEXTAREA
	jQuery(it_eplediprefx+'voter_submit_btn').on('click',function(){
		var ele_val = prompt("Enter Label", "Vote Now");
		jQuery('#it_epoll_contact_builder_textarea').append('[VOTER_SUBMIT_BTN label="'+ele_val+'"]\n');
		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').append('<div class="it_edb_input_container"><div class="it_edb_submit">'+ele_val+'</div></div>');
		
	});

	jQuery('#it_epoll_contact_builder_textarea_reset').on('click',function(){
		jQuery('#it_epoll_contact_builder_textarea,.it_epoll_msg_tags').text('');
		jQuery('#it_epoll_msg_tags,#it_epoll_settings_reciever_mobile,#it_epoll_settings_reciever_email,#it_epoll_settings_v_data_assoc').val('');

		jQuery('.it_epoll_contact_formbuilder_demo .it_epoll_contact_formbuilder_demo_content').html('');
	});
});