class ShowMoreShowLess {

	run(elementClass, btn, btnTextMore, btnTextLess)
	{
		let nbOfElement		= 1;
		let elementLength 	= $(elementClass).length;
		let index 			= 1;
		let button			= btn;

		$(elementClass).hide();
		$(elementClass+':lt('+index+')').show();

		$(button).click(function () {
	    	let type = $(this).attr('data-type');
	    	console.log(index);

	    	if (type == '+'){
	    		index = (index + nbOfElement <= elementLength) ? index + nbOfElement : elementLength;
	        	console.log(index);
	        	$(elementClass+':lt('+index+')').show();
	        	if(index == elementLength){
	        		$(button).attr('data-type', '-');
	        		$(button).html(btnTextLess);
	        	}
	    	} else {
	        	index = nbOfElement;
	        	$(elementClass).not(':lt('+index+')').hide();
	        	$(button).attr('data-type', '+');
	        	$(button).html(btnTextMore);
	    	}
	    });
	}
}
