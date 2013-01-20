window.addEvent('domready', function(){
 
	function ambience(){
		var canvas = $('ambience');
		var context = canvas.getContext('2d');					
		var sizeX = canvas.width;
		var sizeY = canvas.height;
		var positionX = canvas.width/2-(sizeX/2);
		var positionY = 0;	
		var radgrad = context.createRadialGradient(positionX+(sizeX/2), positionY+(sizeY/2), 0, positionX+(sizeX/2), positionY+(sizeY/2), sizeX/2);
	  	radgrad.addColorStop(0, 'rgba(255,255,255,.9)');
	  	radgrad.addColorStop(0.5, 'rgba(255,255,255,.35)');
	  	radgrad.addColorStop(1, 'rgba(255,255,255,0)');
	  		
	  	context.fillStyle = radgrad;
	  	context.rect(positionX, positionY, sizeX, sizeY);
	  	context.fill();
	}
	ambience();
		
	var calendarPosition = $('calendar').getPosition(),
	    calendarNotes = new Element('div#calendar-notes').inject('calendar', 'after').fade('hide'),
	    calendarNotesTitle = new Element('h4').inject(calendarNotes);
	    calendarNotesPlace = new Element('p').inject(calendarNotes);
	    calendarNotesTime = new Element('time').inject(calendarNotes);
	    calendarNotesPointer = new Element('div#calendar-notes-pointer').inject(calendarNotes, 'before').fade('hide');
	
	function activateCalendarLinks(){
		$$('a.calendarlink').addEvent('click', function(e){
			e.stop();
			
			new Request.HTML({
				url: this.get('href'),
				update: $('calendar'),
				onSuccess: function(){
					activateCalendarLinks();
				}
			}).get();
		});
		
		$$('#calendar-content ol li ol li a').each(function(anchor){
			anchor.addEvents({
				'mouseover': function(){
					calendarNotesTitle.set('text', anchor.get('title'));
					calendarNotesPlace.set('text', anchor.get('data-place'));
					calendarNotesTime.set('text', anchor.get('data-time'));
					calendarNotes.position({
						relativeTo: anchor,
						position: 'upperCenter',
						edge: 'bottomCenter',
						offset: {
							x: 0,
							y: -10,
						},
					});
					
					calendarNotesPointer.position({
						relativeTo: anchor,
						position: 'topCenter',
						edge: 'bottomCenter',
						offset: {
							x: 0,
							y: -5,
						},
					});

					calendarNotes.fade('show');
					calendarNotesPointer.fade('show');
				},
				'mouseleave': function(){
					calendarNotes.fade('hide');
					calendarNotesPointer.fade('hide');
				}
			});
		});
	}
	activateCalendarLinks();
	
	$$('time').each(function(time){	
		time.set('data-text', time.get('text'));
		time.set('data-date', time.get('title'));
		time.erase('title');		
		time.addEvents({
			'mouseover': function(e){
				e.stop();
				this.set('text', time.get('data-date'));
			},
			'mouseout': function(){
				this.set('text', time.get('data-text'));
			}		
		});
	});
	
	
	$$('ul.manage').each(function(ul){
		
		ul.fade('hide');
		
		ul.getParent().addEvents({
			'mouseover': function(){
				ul.fade('show');
			},
			'mouseout': function(){
				ul.fade('hide');
			}
		});
		
	});
	
	$$('.copy-me').addEvent('click', function()
	{
		this.selectRange(0, this.get('value').length);
	});
	
	$('export-calendar').addEvent('click', function(e)
	{
		e.stop();
		$('export-calendar-holder').position({
			relativeTo: $('export-calendar'),
			position: 'centerLeft',
			edge: 'bottomRight',
			offset: {
				x: -15,
				y: 20,
			}
		});
		
		$('export-calendar-holder').toggle();
		
		
	});
		
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

});