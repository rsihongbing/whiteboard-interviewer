/**
 * This file initialize the form and datetime clicker
 * in the index.html
 *
 */
(function() {
	'use strict';	

	// initialize the form
	var form = new InterviewForm()
	form.reinitialize();
	
	// reinitialize the form when 'Create Session' is clicked
	$('#main-createBtn').click(form.reinitialize);


	// $("#joinButton").click(function(){ 
	// 	$("#joininterviewform").submit(); 
	// });

  // enable the date pick
	$('#datepicker')
		.datetimepicker({
			autoclose: true,
			maxView: 4,
			startView: 4,
			minView: 2,
			todayBtn: true,
			todayHighlight: true,
			startDate: new Date(),
			forceParse: false
		})
		.on('changeDate', function(ev) {
			form.checkDate();

			var year = ev.date.getFullYear();
			var month = ev.date.getMonth();
			var date = ev.date.getDate();

			if ( !$('#interviewTime').is(':disabled') ) {
				$('#timepicker')
					.datetimepicker('remove')
					.datetimepicker({
						autoclose: true,
						maxView: 1,
						startView: 1,
						minuteStep: 5,
						forceParse: false,
						startDate: new Date(year,month,date+1),
						endDate: new Date(year,month,date+1,23,59)
					})
					.on('hide', form.checkTime);

				form.initializeTime();
			}
		});

	// enable the time pick

	// initial state of time pick 
	$('#interviewTime')
		.val('Anytime')
		.focusout(form.checkTime);

	// toggle for time pick
	$('#timeFormToggle').click(form.toggleTime);

	// buttons event
	$("#createBtn").click(form.submit);
	$("#resetBtn").click(form.initialize);
	$("#newBtn").click(form.reinitialize);
	
	// inputs event
	$('#interviewerEmail').focusout(form.checkInterviewerEmail);
	$('#intervieweeEmail').focusout(form.checkIntervieweeEmail);
	$('#interviewDate')
		.focusout(form.checkDate);

})();
