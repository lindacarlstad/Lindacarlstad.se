
	var helpButton = $('help-button'),
		helpContent = $('help-content').position({
   			relativeTo: helpButton,
   			position: 'upperLeft',
   			edge: 'upperRight',
   			offset: {
   				x: -25,
   				y: -100,
   			}
		}).hide();

	new Form.AutoGrow('text');
	
	new MooIndent($('text'));
	
	new Autocompleter.Request.JSON('tags', '/ajax/tags/', {
			'postVar': 'query',
			'minLength': 1,
			'selectMode': 'type-ahead',
			'multiple': true,
			'delay': 250,
			'autoTrim': true,
		});
	
	helpButton.addEvent('click', function(e){
		this.toggleClass('active');
		
		if(this.hasClass('active')){
			helpContent.show();
		}
		else{
			helpContent.hide();
		}
	});
	
	var previewLength = 0;
	
	var updatePreview = function(){	
		var textLength = $('text').get('value').length;
					
		if(previewLength > 0 !== textLength){
			var myHTMLRequest = new Request.HTML({
				method: 'post',
				url:'/ajax/textinate/',
				update: $('preview-content'),
			}).post('text='+$('text').get('value'));
			previewLength = textLength;
		}
	}
	
	updatePreview.periodical(2500);
	
