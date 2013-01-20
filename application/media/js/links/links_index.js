		
		var newDocumentSlide = new Fx.Slide($('new-link'), {
			resetHeight: true,
			duration: 'short',
		}).hide();
		
		$('new-link-toggle').addEvent('click', function(e){
			e.stop();
					
			this.toggleClass('cancel');
			
			if(this.hasClass('cancel')){
				newDocumentSlide.slideIn();
				this.set('text', 'Avbryt');
			}
			else{
				newDocumentSlide.slideOut();
				this.set('text', 'Lägg till ny länk');
			}
		});
