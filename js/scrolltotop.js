// Scroll to top of page
console.log("Loaded ScrollToTop.js");

$(document).ready(function() {
	// ms to scroll to top
	var SCROLL_TOP_TIME = 1000;
	// class selector for elements that trigger scrolling
	var SCROLL_TOP_CLASS = "scroll-to-top";

	// Show or hide the sticky footer button
	$(window).scroll(function() {
		if ($(this).scrollTop() > 200) {
			$("." + SCROLL_TOP_CLASS).fadeIn(200);
		} else {
			$("." + SCROLL_TOP_CLASS).fadeOut(200);
		}
	});
	
	// Animate the scroll to top
	$("." + SCROLL_TOP_CLASS).click(function(event) {
		console.log("Scrolling to top, triggered by: " + event);
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, SCROLL_TOP_TIME);
	})
});