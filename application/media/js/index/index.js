		
	$$('#feedfilter li a').addEvent('click', function(e){
		e.stop();
		$$('#feedfilter li a').removeClass('active');
		this.addClass('active');
		
		new Request.HTML({
			url: this.get('href'),
			update: $('setcontent'),
		}).get();
	});
	
	if($('create-new-status-update') !== 'Null'){
	
		var newStatusUpdateButton 	= $('create-new-status-update'),
			statusUpdateForm 		= $('messageform'),
			submitStatusUpdateForm	= $('submit-messageform'),
			statusUpdateFormSlide	= new Fx.Slide($(statusUpdateForm), {
				resetHeight: true,
				duration: 'short',
			}).hide();
		
		new Form.AutoGrow('status-update-textarea');
		
		newStatusUpdateButton.addEvent('click', function(e){
			e.stop();
					
			this.toggleClass('cancel');
			
			if(newStatusUpdateButton.hasClass('cancel')){
				statusUpdateFormSlide.slideIn();
				this.set('text', 'Avbryt');
			}
			else{
				statusUpdateFormSlide.slideOut();
				this.set('text', 'Skapa uppdatering');
			}
		});
		
		//SEND FORM
		statusUpdateForm.addEvent('submit', function(e){
			e.stop();
		});
		
		submitStatusUpdateForm.addEvent('click', function(e){
			e.stop();
			statusUpdateForm.set('send', {
				url: '/forum/add/',
				link: 'cancel',
				onSuccess: function(response){
					$('setcontent').set('html', response);
					$('tags-base').set('value', '');
					$('status-update-textarea').set('text', '');
					statusUpdateFormSlide.slideOut();
					newStatusUpdateButton.set('text', 'Skapa uppdatering').removeClass('cancel');
				},
			}).send();
		});	
	
	
		new Autocompleter.Request.JSON('tags-base', '/ajax/tags/', {
			'postVar': 'query',
			'minLength': 1,
			'selectMode': 'type-ahead',
			'multiple': true,
			'delay': 250,
			'autoTrim': true,
		});
	}
