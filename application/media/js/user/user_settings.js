
	$$('section#middle h3').each(function(header){
		
		var slider = new Fx.Slide(header.getNext('fieldset'), {
			duration: 'short',
		}).hide();
		
		header.addEvent('click', function(){
			slider.toggle();
		}).setStyle('cursor', 'pointer');
	});