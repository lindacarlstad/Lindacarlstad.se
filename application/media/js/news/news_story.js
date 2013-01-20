
	if($('comment') !== null){
		var commentBox = $('comment'),
			replyInput = $('reply-comment')
			replyTo	   = $('reply-to')
			replyActive = $('reply-active-box');
	
		$$('a.reply').addEvent('click', function(e){
			e.stop();
			var	that = this;
			
			replyInput.set('value', this.get('data-id'));
			replyTo.set('text', that.get('data-name'));
			commentBox.inject(this.getParent('article'), 'after').addClass('reply');
			replyActive.show();
		});
	
		$('cancel-reply').addEvent('click', function(e){
			e.stop();
			replyInput.set('value', '');
			replyTo.set('text', '');
			commentBox.inject($('comments-content'), 'after').removeClass('reply');
			replyActive.hide();
		});
	}