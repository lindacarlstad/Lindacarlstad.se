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
var MooIndent = new Class({

	Implements: [Options],

	options: {

	},

	initialize: function(element, options){
	
		element.addEvent('keydown', function(e){
		
			//all content in input
			var val = element.value;
				
			switch(e.code){
				
				case 9: // tab
				var startTime = $time();
					if(this.getSelectedText()){ //is there selected text?
						e.stop();
						
						if(e.shift){
						//------------------------------------------------------------
						// shift-tab unindentation
						//------------------------------------------------------------
		
							var scrollPos = this.getScroll();
											
							//start, end of selection
							var start = this.getSelectionStart(), end = this.getSelectionEnd();
							
							//portion of up-to-the-selection start
							var beforeSelection = val.substring(0,start);
							
							//portion beyond selection end
							var afterSelection = val.substring(end);
							
							// locate the loaction of the last line break before the selection(marking th begining of the first selected line)
							var firstBreak = (beforeSelection.lastIndexOf('\n')) ? beforeSelection.lastIndexOf('\n') : 0;
							
							// locate the loaction of the first line break after the selection(marking the of the last selected line)
							var lastBreak = (val.indexOf('\n', end -1) != -1) ? val.indexOf('\n', end-1) : val.length;
							
							//dont include the line break in the first line. If it is the begining of the file, do not move
							var lineBegining = (firstBreak == 0) ? 0: firstBreak +1;
							
							//content of the area that is before the first selected line. (need to preserve it)
							var beforeChange = val.substring(0, lineBegining);
							
							//content of the area that is after the last selected line. (need to preserve it)
							var afterChange = val.substring(lastBreak);
							
							//content from begining of first selected, to end of last selected.
							//this is what we will be manipulating
							var newText = val.substring(lineBegining, lastBreak);
													
							//the loc of the end of the selection, so we can end selection at this point again
							var leftOff = val.substring(lastBreak).length
							
							//check if there are any lines indented in the selection
							if(newText.match(/^(\t| )+/gm)){
							
								var replacement = ''; //holder
								
								var lines = newText.split('\n'); //create an array of each line
								$each(lines, function(value, i){ //iterate thought them
										
									// if there is no non-whitespace character on that line, we act differently
									// split the white space from the data
									var splitAt = value.indexOf(value.match(/[\S]/));
									if(splitAt != -1){
										var whiteSpace = value.substring(0, splitAt);
										var textPortion = value.substring(splitAt);
									}else{
										var whiteSpace = value;
										var textPortion = '';
									}
									
									//convert all the tabs to 4 spaces (so left with only spaces)								
									whiteSpace = whiteSpace.replace(new RegExp("\t", 'gm'), "    ");
									//if less than 3 spaces, remove them
									if(whiteSpace.length < 4) whiteSpace = '';
									//convert 4 spaces to a tab
									whiteSpace = whiteSpace.replace(new RegExp("    ", 'gm'), "\t");
									//remove the first tab
									whiteSpace = whiteSpace.substring(1);
									//add a crage return if not the last line of the selection
									var lineEnding = (i != lines.length-1)? '\n': '';
									//put it all together again
									replacement += (whiteSpace+textPortion+lineEnding);
									//alert(whiteSpace+textPortion+lineEnding);
									
								});
								//add the head and foot back on	
								var changeTo = beforeChange+replacement+afterChange;
								//calculate where to place the selection
								var endCursor = changeTo.length - leftOff;
								//set the text to the new reduced tab version
								this.set('value', changeTo);
								//highlight the correct area of text again, and scroll back to the correct area.
								//this.selectRange(firstBreak+1, endCursor);
								this.selectRange(firstBreak+1, firstBreak+1+replacement.length);
								this.scrollTo(scrollPos.x, scrollPos.y);
							
							}
							//alert($time() - startTime);
							break;
						}
						
						
						//------------------------------------------------------------
						// tab indentation
						//------------------------------------------------------------
		
						var scrollPos = this.getScroll();
						
						//start, end of selection
						var start = this.getSelectionStart(), end = this.getSelectionEnd();
						
						//find the begining of the line, or file
						var beforeSelection = val.substring(0,start);
						
						// locate the loaction of the 
						var firstBreak = (beforeSelection.lastIndexOf('\n')) ? beforeSelection.lastIndexOf('\n') : 0;
		
						var lastBreak = (val.indexOf('\n', end -1) != -1) ? val.indexOf('\n', end-1) : val.length;
						
						var newText = val.substring(0, firstBreak);
											
						newText += val.substring(firstBreak, lastBreak).replace(new RegExp("\n", 'gi'), "\n\t");
						
						newText += val.substring(lastBreak);
						var returnMatches = val.substring(firstBreak, lastBreak).match(/(\n)/gm);
							
							
						$(this).set('value',  newText);
							
						// }
						
						this.selectRange(firstBreak+1,lastBreak+returnMatches.length);
						//reset scrollbar position
						this.scrollTo(scrollPos.x, scrollPos.y);
						
					}else{
						e.stop();
						//save scrollbar positions
						var scrollPos = this.getScroll();
				
						$(this).insertAtCursor(String.fromCharCode(9), false);
						
						//reset scrollbar position
						this.scrollTo(scrollPos.x, scrollPos.y);
					}
					//alert($time() - startTime);
					break;
				
				case 13:
				var startTime = $time();
				//------------------------------------------------------------
				// return yeilds auto indent
				//------------------------------------------------------------
					e.stop();
					var scrollPos = this.getScroll();
					
					//get the cursor position
					var cursorPos = this.getCaretPosition();
					
					//select everything up to that point
					var beforeSelection = val.substring(0, cursorPos);
						
					// search backwards for the first line break. This is the begining of that line
					var firstBreak = (beforeSelection.lastIndexOf('\n')) ? beforeSelection.lastIndexOf('\n') : 0;
					
					//select firstBreak (the begining) and cursorPos (the end) of the line
					var  lineSelect = val.substring(firstBreak+1, cursorPos)
					
					//look at that line, was there any indentation (tabs or spaces) at the begining? If so, grab it
					var indent = (lineSelect.match(/^(\t| )+/gm)) ? lineSelect.match(/^(\t| )+/gm) : '';
					
					//return to the next line, place that indent (if there was one) on that line.
					this.insertAtCursor('\n'+indent, false);
					
					this.scrollTo(scrollPos.x, scrollPos.y);
			//alert($time() - startTime);	
			break;
			  
			}
			
		
		});
	
	
	
	}
});

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
	

});