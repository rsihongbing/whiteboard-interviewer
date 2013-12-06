(function() {
	'use strict';

	window.setTimeout( function() {
		$("#test-container").hide('slow');
	}, 4500);

	// sleep for 5 seconds
	// to give for browsing the website or tests
	window.setTimeout( function() {
		$("#main-createBtn").trigger("click");
	}, 5000);

	// run all the demo with appropiate delay
	window.setTimeout(demoTitle, 6000);
	window.setTimeout(demoDescription, 7000);

	window.setTimeout(demoWrongInterviewerEmail, 9000);
	window.setTimeout(demoWrongIntervieweeEmail, 10000);
	window.setTimeout(demoSameEmail, 11000);

	window.setTimeout(demoRightInterviewerEmail, 13000);
	window.setTimeout(demoRightIntervieweeEmail, 14000);

	window.setTimeout(demoTypeDate,15000);
	window.setTimeout(demoChooseDate, 17000);

	window.setTimeout(demoToggleTime, 18000);
	window.setTimeout(demoChooseTime, 19000);
	window.setTimeout(demoTypeTime, 21000);

	window.setTimeout(demoReset, 23000);

	window.setTimeout(demoAll, 24000);

	// window.setTimeout(demoSubmit, 30000);

	/**
	 * Make type writing effect
	 */
	$.fn.teletype = function(opts){
	    var $this = this,
	        defaults = {
	            animDelay: 100
	        },
	        settings = $.extend(defaults, opts);

	    // reset the value
	    $this.val('');

	    $.each(settings.text.split(''), function(i, letter){
	        setTimeout(function(){
	            $this.val($this.val() + letter);
	        }, settings.animDelay * i);
	    });

	    return $this;
	};

	/**
	 * Typing title in the interview title input box
	 */
	function demoTitle() {
		$("#interviewTitle").teletype({
			text : 'Testing Interview'
		})
		.trigger('blur');
	}

	/**
	 * Typing description in the form
	 */
	function demoDescription() {
		$("#interviewDescription").teletype({
			animDelay : 50,
			text : 'You can put any your interviews description here... As long as you want'
		})
		.trigger('blur');
	}

	/**
	 * Typing wrong interviewer  email 
	 */
	function demoWrongInterviewerEmail() {
		$("#interviewerEmail").teletype({
			animDelay : 50,
			text : 'asd.com'
		});

		setTimeout( function() {
			$("#interviewerEmail").trigger('blur');
		} , 400);
	}

	/**
	 * Typing valid interviewer email
	 */
	function demoRightInterviewerEmail() {
		$("#interviewerEmail").teletype({
			animDelay : 50,
			text : 'asd@gmail.com'
		})

		setTimeout( function() {
			$("#interviewerEmail").trigger('blur');
		} , 700);
	}

	/**
	 * Typing invalid interviewee email
	 */
	function demoWrongIntervieweeEmail() {
		$("#intervieweeEmail").teletype({
			animDelay : 50,
			text : 'asd@@com'
		});

		setTimeout( function() {
			$("#intervieweeEmail").trigger('blur');
		} , 850);
	}

	/**
	 * Typing valid interviewee email
	 */
	function demoRightIntervieweeEmail() {
		$("#intervieweeEmail").teletype({
			animDelay : 50,
			text : 'asdasd@gmail.com'
		})
		setTimeout( function() {
			$("#intervieweeEmail").trigger('blur');
		} , 850);
	}

	/**
	 * Typing same email for interviewer and interviewee
	 */
	function demoSameEmail() {
		$("#interviewerEmail").teletype({
			animDelay : 50,
			text : 'same@gmail.com'
		})


		$("#intervieweeEmail").teletype({
			animDelay : 50,
			text : 'same@gmail.com'
		});

		setTimeout( function() {
			$("#intervieweeEmail").trigger('blur');
			$("#interviewerEmail").trigger('blur');
		} , 700);
	}

	/**
	 * Typing interview Date
	 */
	function demoTypeDate() {
		$("#interviewDate").teletype({
			text: '2014/03/05'
		});

		setTimeout( function() {
			$("#interviewDate").trigger('blur');
		} , 1050);
	}

	/**
	 * Choosing interview date from the calendar
	 */
	function demoChooseDate() {
		$("#interviewDate").val('');

		$(".glyphicon-calendar").trigger('click');

		setTimeout(function() {
			$('.year.active').trigger('click');
		}, 1000);
		setTimeout(function() {
			$('.month.active').trigger('click');
		}, 1000);
		setTimeout(function() {
			$('.day.active').trigger('click');
		}, 1000);
	}
	
	/**
	 * Toggle the interview time field
	 */
	function demoToggleTime() {
		$('#timeFormToggle').trigger('click');
	}

	/**
	 * Typing interview time
	 */
	function demoTypeTime() {
		$('#interviewTime').teletype({
			text: '23:59'
		});

		setTimeout( function() {
			$("#interviewTime").trigger('blur');
		} , 700);
	}

	/**
	 * Choosing interview time from the calendar
	 */
	function demoChooseTime() {
		$('#interviewTime').val('');
		$(".glyphicon-time").trigger('click');

		setTimeout(function() {
			$('.hour.active').trigger('click');
		}, 1000);
		setTimeout(function() {
			$('.minute.active').trigger('click');
		}, 1000);
	}

	/**
	 * Clicking reset button
	 */
	function demoReset() {
		$("#resetBtn").trigger('click');
	}

	/**
	 * Do all the demo without delay (in parallel)
	 */
	function demoAll() {
		demoTitle();
		demoDescription();
		demoRightInterviewerEmail();
		demoRightIntervieweeEmail();
		demoTypeDate();
		setTimeout(function() {
			demoTypeTime();
		},1150)
		
	}

	/**
	 * Clicking submit button
	 */
	function demoSubmit() {
		$("#createBtn").trigger('click');
	}


})();

	