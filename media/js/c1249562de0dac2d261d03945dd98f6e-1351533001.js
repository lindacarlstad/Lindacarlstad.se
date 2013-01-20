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

	new Form.AutoGrow('text');
});