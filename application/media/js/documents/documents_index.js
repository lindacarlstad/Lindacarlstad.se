		
		var newDocumentSlide = new Fx.Slide($('new-document'), {
			resetHeight: true,
			duration: 'short',
		}).hide();
		
		$('new-document-toggle').addEvent('click', function(e){
			e.stop();
					
			this.toggleClass('cancel');
			
			if($('new-document-toggle').hasClass('cancel')){
				newDocumentSlide.slideIn();
				this.set('text', 'Avbryt');
			}
			else{
				newDocumentSlide.slideOut();
				this.set('text', 'Lägg till nytt dokument');
			}
		});
