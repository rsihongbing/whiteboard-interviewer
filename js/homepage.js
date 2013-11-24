(function() {
	var form = new InterviewForm();

	$("#joinButton").click(function(){ 
		$("#joininterviewform").submit(); 
	});

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
				form.initializeTime();
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
			}
		});

	// enable the time pick
	

	

	// buttons event
	$("#createBtn").click(form.submit);
	$("#resetBtn").click(form.initialize);
	$("#newBtn").click(form.reinitialize);
	
	// inputs event
	$('#interviewerEmail').focusout(form.checkInterviewerEmail);
	$('#intervieweeEmail').focusout(form.checkIntervieweeEmail);
	$('#interviewDate')
		.focusout(form.checkDate);

	// time specific 
	$('#interviewTime')
		.val('Anytime')
		.focusout(form.checkTime);

	$('#timeFormToggle').click(function() {
		if ( $('#interviewTime').is(':disabled') ) {
			$('#interviewTime')
				.val('')
				.prop('disabled',false);

			$(this)
				.removeClass('glyphicon-plus')
				.addClass('glyphicon-remove');
		} else {
			form.initializeTime();

			$('#timepicker')
				.datetimepicker('remove');

			$('#interviewTime')
				.val('Anytime')
				.prop('disabled',true);

			$(this)
				.removeClass('glyphicon-remove')
				.addClass('glyphicon-plus');
		}
	});


})();
