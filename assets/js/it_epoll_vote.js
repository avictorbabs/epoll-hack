jQuery(document).ready(function() {
	jQuery('.it_epoll_survey-item').each(function(){
		var it_epoll_item = jQuery(this);
		jQuery(this).find('#it_epoll_survey-confirm-button').click(function(){
			jQuery(it_epoll_item).parent().find('.it_epoll_survey-item').each(function(){
				var it_epoll_multivote = jQuery(it_epoll_item).parent().find('#it_epoll_multivoting').val();

				if(!it_epoll_multivote){
					jQuery(this).find('#it_epoll_survey-vote-button').val('...');
					jQuery(this).find('#it_epoll_survey-vote-button').attr('disabled','yes');
					jQuery(this).find('.it_epoll_card_front .it_epoll_survey-progress-fg').fadeIn(100);
					jQuery(this).find('.it_epoll_card_back').removeClass('it_epoll_card_back_visible');
					jQuery(this).find('#it_epoll_otp_confirm_vote').removeClass('it_epoll_card_hidden');
				}
			});
			jQuery(it_epoll_item).find('.it_epoll_card_front .it_epoll_survey-progress-fg').fadeOut(100);
			jQuery(it_epoll_item).find('#it_epoll_otp_confirm_vote').addClass('it_epoll_card_back_visible');
			jQuery(it_epoll_item).find('.it_epoll_card_front').addClass('it_epoll_card_hidden');
		});

		jQuery(this).find('#it_epoll_survey-vote-button').click(function(){
		
			
			jQuery(it_epoll_item).parent().find('.it_epoll_survey-item').each(function(){
				var it_epoll_multivote = jQuery(this).find('#it_epoll_multivoting').val();
				if(!it_epoll_multivote){
					jQuery(this).find('#it_epoll_survey-vote-button').val('...');
					jQuery(this).find('#it_epoll_survey-vote-button').attr('disabled','yes');
				}
			});

			var it_epoll_btn  = jQuery(this);	
			jQuery(it_epoll_item).find('.it_epoll_spinner').fadeIn();
			//console.log(it_epoll_item);

			var data = {
				'action': 'it_epoll_vote',
				'option_id': jQuery(it_epoll_item).find('#it_epoll_survey-item-id').val(),
				'poll_id': jQuery(it_epoll_item).find('#it_epoll_poll-id').val() // We pass php values differently!
			};
	
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(it_epoll_ajax_obj.ajax_url, data, function(response) {
				
				var it_epoll_json = jQuery.parseJSON(response);
		        
		        jQuery(it_epoll_item).parent().find('.it_epoll_survey-item').each(function(){
		        	
		        	var it_epoll_multivote = jQuery(this).find('#it_epoll_multivoting').val();
				if(!it_epoll_multivote){
		        	jQuery(this).find('#it_epoll_survey-vote-button').addClass('it_epoll_scale_hide');
		        }
		        var it_epoll_multivoteData = it_epoll_json.multivote;
		        if(!it_epoll_multivoteData){
		        	 jQuery(this).find('#it_epoll_survey-vote-button').addClass('it_epoll_scale_hide');	
		        }
		       
		    	});

				jQuery(it_epoll_item).find('.it_epoll_survey-progress-fg').attr('style','width:'+it_epoll_json.total_vote_percentage+'%');
				jQuery(it_epoll_item).find('.it_epoll_survey-progress-label').text(it_epoll_json.total_vote_percentage+'%');
				jQuery(it_epoll_item).find('.it_epoll_survey-completes').text(it_epoll_json.total_opt_vote_count+' / '+it_epoll_json.total_vote_count);		
				
				setTimeout(function(){
					jQuery(it_epoll_btn).addClass('it_epoll_scale_show');
					jQuery(it_epoll_btn).val("Voted");
					jQuery(it_epoll_btn).toggleClass("it_epoll_green_gradient");
					jQuery(it_epoll_item).find('.it_epoll_spinner').toggleClass("it_epoll_spinner_stop");	
					jQuery(it_epoll_item).find('.it_epoll_spinner').toggleClass("it_epoll_drawn");
				},300);

				
			});
	
		});

	});

	jQuery('.it_epoll_pop_close').click(function(){
		jQuery('.it_epoll_pop_container').fadeOut();
	});

});