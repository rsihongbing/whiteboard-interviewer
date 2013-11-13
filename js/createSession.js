$(document).ready(function() {

	// assign event listener to corresponding button
	// inside the create session window
	$("#createBtn").click(submitForm);
	$("#resetBtn").click(resetForm);
	$("#newBtn").click(reinitializeForm);
	
	defaultToday();
	
	
	function defaultToday() {
		var now = new Date();
 
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);

		today = now.getFullYear()+"-"+(month)+"-"+(day) ;

		$('#interviewDate').val(today);
	}
	
	// executed when "Reset" Button is clicked
	//
	// clear all the input fields in the create session form
	function resetForm() {	
		$("#interviewTitle").val("");
		$("#interviewDescription").val("");
		//$("#interviewDescription").html("");
		$("#interviewDate").val("");
		
		// disabled for alpha release
		//$("#interviewerEmail").val("");
		//$("#intervieweeEmail").val("");
		
		defaultToday();
	}
	
	// executed when "New Session" button is clicked
	//
	// reinitialize the button states
	// and reset to blank form
	function reinitializeForm() {
		$("#formarea").show('slow');
		$("#resultarea").hide('slow');
		$("#createBtn").removeAttr("disabled");
		$("#resetBtn").show().removeAttr("disabled");		
		
		$("#newBtn").hide();
		
		resetForm();
	}
		
	// executed when "Submit" button is clicked
	//
	// change some of the buttons' state
	// and send request to the web server then show the response
	function submitForm() {
		// show loading .gif and close the form
		// and disabling "Submit" button
		$("#formarea").hide('slow');
		$("#resultarea").show('slow');
		$("#createBtn").attr("disabled","disable");
		$("#resetBtn").attr("disabled","disable");	
		
		// fetch data
		jqueryFetchRequest();
		
		// after (successfully/failed) fetching
		// show "Create New Session" button
		$("#resetBtn").hide();
		$("#newBtn").show();
	}
	
	// perform the request data from the web server
	function jqueryFetchRequest() {
		$.post("api/REST.php", $("#interviewform").serialize(), jqueryShowResponse)
			.fail(jqueryShowFailure);
	}
	
	// this function is called when the server make a (good/bad) response
	// good:
	// - session created successfully
	// bad:
	// - bad input from user
	function jqueryShowResponse(data) {
		$("#resultloading").hide('fast');
		
		var area = $("#resultmessage");
		
		if( data.code == 1) {
				area.html("Your interview session is succesfully scheduled");
		} else {
				area.html("Something wrong with your request");
		}
	}
	
	// this function is called when there is no response from server
	// because of:
	// - bad request(not from user)
	// - server down
	function jqueryShowFailure() {
		$("#resultloading").hide('fast');
		
		$("#resultmessage").html("Server Error: Please try again later!");
	}
			
	function afterFetch() {
				
	}
			
	// old codes:
	// references...		
	function fetchRequest() {
		var xmlhttp;
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}	
					
		xmlhttp.onload = showResponse;
		xmlhttp.open("POST","api/REST.php",true);
				
		var title = encodeURIComponent($("#interviewTitle").val());
		var description = encodeURIComponent($("#interviewDescription").val());
		var interviewerEmail = encodeURIComponent($("#interviewerEmail").val());
		var intervieweeEmail = encodeURIComponent($("#intervieweeEmail").val());
		var date = encodeURIComponent($("#interviewDate").val());
				
		var parameters="interviewer_email="+interviewerEmail+"&interviewee_email="+intervieweeEmail+"&date_scheduled="+date+"&title="+title+"&description="+description;
				
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				
		xmlhttp.send(parameters);
	}
			
			
			
	function showResponse() {
		// hide loading .gif
		$("#resultloading").hide('fast');
	
		var area = $("#resultmessage");
		if( this.status == 200 ) {
			var json = JSON.parse(this.responseText);
			
			if( json.code == 1) {
				area.html("Your interview session is succesfully scheduled");
			} else {
				area.html("Something wrong with your request");
			}
		}
	}
});