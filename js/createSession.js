/**
 * This JavaScript control the animation and behavior in the "Create Sesion" modal
 * 
 * @author dannych
 */
(function( $ ){
$(document).ready(function() {

	/**
	 * Assign event hander to their corresponding object
	 */

	// buttons event
	$("#createBtn").click(checkForm);
	$("#resetBtn").click(resetForm);
	$("#newBtn").click(reinitializeForm);
	
	// inputs event
	$('#interviewerEmail').focusout(checkEmail);
	$('#intervieweeEmail').focusout(checkEmail);
	$('#interviewDate')
		.focusout(checkDate)
		.val(defaultToday());

	/**
	 * Reset the effect given
	 */
	$.fn.hasNormal = function() {
		$(this).parent().removeClass("has-success has-error");
	};

	/**
	 * Create the effect on the object (input)
	 * when the value of the object is not valid
	 */
	$.fn.hasError = function() {
		$(this).hasNormal();
		$(this).parent().addClass("has-error");
	};

	/**
	 * Create the effect on the object (input)
	 * when the value of the object is valid
	 */
	$.fn.hasSuccess = function() {	
		$(this).hasNormal();
		$(this).parent().addClass("has-success");
	};

	
	/**
	 * Recheck all the elements in the form
	 *
	 * If all the elements are valid then submit the form
	 * otherwise the place where the error is taking placing is shown
	 */
	function checkForm() {
		var erEmail = $('#interviewerEmail');
		var eeEmail = $('#intervieweeEmail');
		var date = $('#interviewDate');

		var checkErEmail = checkEmailValue(erEmail.val());
		var checkEeEmail = checkEmailValue(eeEmail.val());
		var checkSimilar = erEmail.val() != eeEmail.val();
		var checkDate = checkDateValue(date.val());

		if ( checkEeEmail && checkErEmail && checkDate && checkSimilar ) {
			submitForm();
		} else {
			if ( checkErEmail ) {
				erEmail.hasSuccess();
			} else {
				erEmail.hasError();
			}	

			if ( checkEeEmail ) {
				eeEmail.hasSuccess();
			} else {
				eeEmail.hasError();
			}

			if ( checkDate ) {
				date.hasSuccess();
			} else {
				date.hasError();
			}

			if ( !checkSimilar ) {
				erEmail.hasError();
				eeEmail.hasError();
			}
		} 
	}
	
	/**
	 * Check the email inputted by user
	 *
	 * Triggered when user finish inputting the email
	 * 
	 * - Checked the syntax of the email not the validity 
	 * - Checked the similarity of the other email
	 */
	function checkEmail() {
		var i = $(this);
		var email = i.val();
		if (checkEmailValue(email)) {
			i.hasSuccess();
		} else {
			i.hasError();
		}

		checkSimilarEmail()
	}

	/**
	 * Check the value(string) of the email
	 * 
	 * this function do the real work checking the email's syntax
	 */
	function checkEmailValue(email) {
		if (email == null || email == "" ){
			return false;
		}
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(email);
	}

	/**
	 * Check the similarity of the value of all the emails
	 *
	 * Interviewer email cannot be the same as interviewee email
	 */
	function checkSimilarEmail() {
		var email = $('.email');
		
		if ($(email[0]).val() == $(email[1]).val())
			email.each( function() {
				$(this).hasError();
			});
	}

	/**
	 * Check the date syntax and validity
	 *
	 * Triggered when the user finished inputting the date 
	 * in the input field
	 */
	function checkDate() {
		var i = $(this);
		var input_date = i.val();

		if ( checkDateValue(input_date) ) {
			i.hasSuccess();
		} else {
			i.hasError();
		}
	}

	/**
	 * Check the date value (String) 
	 *
	 * this function does the real work of checking the syntax
	 */
	function checkDateValue(datetime) {
		if (datetime == null || datetime == "")
			return false;

		var dateAndTime = parseDateTime(datetime);

		if (dateAndTime == null)
			return false;

		var now = new Date();
		var input = new Date(dateAndTime[1],dateAndTime[2],dateAndTime[3],dateAndTime[4],dateAndTime[5]);

		return  input.getTime() >= now.getTime() ;
	}

	function parseDateTime(datetime) {
		return datetime.match(/(\d{4})-(\d{2})-(\d{2})T(\d{2})\:(\d{2})/);
	}

	/**
 	 * Get the String value of today's date
 	 */
	function defaultToday() {
		var now = new Date();

		var today = now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"T"
			+ now.getHours()+":"+now.getMinutes();

		return today;
	}
	
	/**
	 * Reset all the input field in the form
	 *
	 * executed when "Reset" Button is clicked
	 *
	 * clear all the input fields in the create session form
	 */
	function resetForm() {
		$('#interviewTitle').val('');
		$('#interviewDescription').val('');
		$('#interviewDate')
			.val(defaultToday())
			.hasNormal();
		$("#interviewerEmail")
			.val('')
			.hasNormal();
		$("#intervieweeEmail")
			.val('')
			.hasNormal();
	}
	
	/**
	 * Create a state of the form just like the beginning 
	 *
	 * executed when "New Session" button is clicked
	 *
	 * reinitialize the button states
	 * and reset to blank form
	 */
	function reinitializeForm() {
		$("#resultloading").show('fast');
		$("#formarea").show('slow');
		$("#resultarea").hide();
		$("#resultmessage").hide('slow');
		$("#createBtn").removeAttr("disabled");
		$("#resetBtn").show().removeAttr("disabled");
		
		$("#newBtn").hide();
		
		if ($(this).val() === "true")
			resetForm();
	}
		
	/**	
	 * executed when "Submit" button is clicked and pass all the checking
	 *
	 * change some of the buttons' state
	 * and send request to the web server then show the response
	 */
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
	}
	
	/**
	 * perform the request data from the web server
	 */
	function jqueryFetchRequest() {
		var interviewTitle = encodeURI($('#interviewTitle').val());
		var interviewDescription = encodeURI($('#interviewDescription').val());
		var interviewerEmail = encodeURI($('#interviewerEmail').val());
		var intervieweeEmail = encodeURI($('#intervieweeEmail').val());

		var raw = parseDateTime($('#interviewDate').val());

		var interviewDate = encodeURI(raw[1]+"-"+raw[2]+"-"+raw[3]+" "+raw[4]+":"+raw[5]+":"+"00");

		var parameter = 'title=' + interviewTitle
			+ '&description=' + interviewDescription
			+ '&interviewer_email=' + interviewerEmail
			+ '&interviewee_email=' + intervieweeEmail
			+ '&date_scheduled=' + interviewDate;

		$.post('api/REST.php', parameter, jqueryShowResponse)
			.fail(jqueryShowFailure);
	}
	
	/**
	 * this function is called when the server make a (good/bad) response
	 * good:
	 * - session created successfully
	 * bad:
	 * - bad input from user
	 *
	 * show appropiate message to user in the given area
	 */
	function jqueryShowResponse(data) {
		$("#resultloading").hide();
		$("#newBtn").show();
		var area = $("#resultmessage");
		area.show();
		if( data.code == 1) {
				area.html("Your interview session is succesfully scheduled, please check you email");
				$("#newBtn").val(true);
		} else {
				area.html("Something wrong with your request! \n" + data['failure_reason']);
				$("#newBtn").val(false);
		}
	}
	
	/**
	 * this function is called when there is no response from server
	 * because of:
	 * - bad request(not from user)
	 * - server down
	 *
	 * show appropiate message to user in the given area
	 */
	function jqueryShowFailure() {
		$("#resultloading").hide('fast');
		
		$("#resultmessage").show();
		$("#resultmessage").html("Server Error: Please try again later!");
		$("#newBtn").val(false);
	}
		
});
})( jQuery );