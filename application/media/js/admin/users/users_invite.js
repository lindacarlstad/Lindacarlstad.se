
	function CloneEvent(clone){
		clone.getElement('input').addEvent('focus', function(e){
			var newEl = clone.clone().inject('invite-content');			
			newEl.getElement('input').set('value', '');
			
			this.removeEvents('focus', function(){});
			
			CloneEvent(newEl);
		});
	}
	
	CloneEvent($('invite-inputs'));
