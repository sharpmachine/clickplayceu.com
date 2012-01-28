// Modified jquery tool tip plugin
// Works great with wordpress sites
// Read more here : http://shailan.com

jQuery(document).ready(function() {

	// OPTIONS
	tooltipElement = ".tooltip";
	distanceFromMouse = 20;
	tooltipId = "tooltip"; // For styling, Do not use #

	//Tooltips
	var tip;
	jQuery(tooltipElement).hover(function(){ 
		//Caching the tooltip and removing it from container; then appending it to the body
		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "" + this.t : "";
		jQuery("body").append("<p id='"+tooltipId+"'>"+ c +"</p>");								 
		tip = jQuery("#" + tooltipId);
		tip.fadeIn("fast");	
	}, function() {
		this.title = this.t;	
		jQuery("#" + tooltipId).hide().remove();
	}).mousemove(function(e) {
		  tip = jQuery("#" + tooltipId);
		  var mousex = e.pageX + distanceFromMouse; //Get X coodrinates
		  var mousey = e.pageY + distanceFromMouse; //Get Y coordinates
		  var tipWidth = tip.width(); //Find width of tooltip
		  var tipHeight = tip.height(); //Find height of tooltip

		 //Distance of element from the right edge of viewport
		  var tipVisX = jQuery(window).width() - (mousex + tipWidth);
		  var tipVisY = jQuery(window).height() - (mousey + tipHeight);

		if ( tipVisX < distanceFromMouse ) { //If tooltip exceeds the X coordinate of viewport
			mousex = e.pageX - tipWidth - distanceFromMouse;
			tip.css({  top: mousey, left: mousex });
		} if ( tipVisY < distanceFromMouse ) { //If tooltip exceeds the Y coordinate of viewport
			mousey = e.pageY - tipHeight - distanceFromMouse;
			tip.css({  top: mousey, left: mousex });
		} else {
			tip.css({  top: mousey, left: mousex });
		}
	});

});