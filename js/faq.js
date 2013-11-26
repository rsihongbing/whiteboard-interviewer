
/* AJAX loads json data for FAQ into mainpage */

$(document).ready(function() {
	console.log("Loaded JS Component: faq.js");
	console.log("\tThis component will fail to load in chrome local file access, will be fine on HTTP server");
	var faqURL = "docs/faq.json";
	

	$.getJSON(faqURL, function (data) {
		console.log("\t faq.js: in $.getJSON");
		
		 var items = [];
		 var list = data.faq;
		$.each(list, function(key, element ) {
				items.push( "<blockquote><p>" + element.q + "</p><small> " + element.a + "</small></blockquote>" );
		});
		$( "<div/>", {
			html: items.join( "" )
		}).appendTo("#faq");

	});
});