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

	function demoTitle() {
		$("#interviewTitle").teletype({
			text : 'Testing Interview'
		})
		.trigger('blur');
	}

	function demoDescription() {
		$("#interviewDescription").teletype({
			animDelay : 50,
			text : 'You can put any your interviews description here... As long as you want'
		})
		.trigger('blur');
	}

	function demoWrongInterviewerEmail() {
		$("#interviewerEmail").teletype({
			animDelay : 50,
			text : 'asd.com'
		});

		setTimeout( function() {
			$("#interviewerEmail").trigger('blur');
		} , 400);
	}

	function demoRightInterviewerEmail() {
		$("#interviewerEmail").teletype({
			animDelay : 50,
			text : 'asd@gmail.com'
		})

		setTimeout( function() {
			$("#interviewerEmail").trigger('blur');
		} , 700);
	}

	function demoWrongIntervieweeEmail() {
		$("#intervieweeEmail").teletype({
			animDelay : 50,
			text : 'asd@@com'
		});

		setTimeout( function() {
			$("#intervieweeEmail").trigger('blur');
		} , 850);
	}

	function demoRightIntervieweeEmail() {
		$("#intervieweeEmail").teletype({
			animDelay : 50,
			text : 'asdasd@gmail.com'
		})
		setTimeout( function() {
			$("#intervieweeEmail").trigger('blur');
		} , 850);
	}

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

	function demoTypeDate() {
		$("#interviewDate").teletype({
			text: '2014/03/05'
		});

		setTimeout( function() {
			$("#interviewDate").trigger('blur');
		} , 1050);
	}

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
	
	function demoToggleTime() {
		$('#timeFormToggle').trigger('click');
	}

	function demoTypeTime() {
		$('#interviewTime').teletype({
			text: '23:59'
		});

		setTimeout( function() {
			$("#interviewTime").trigger('blur');
		} , 550);
	}

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

	function demoReset() {
		$("#resetBtn").trigger('click');
	}

	function demoAll() {
		demoTitle();
		setTimeout(demoDescription, 1000);
		setTimeout(demoRightInterviewerEmail(), 1000);
		setTimeout(demoRightIntervieweeEmail(), 1000);
		setTimeout(demoTypeDate(), 1000);
		setTimeout(demoTypeTime(), 1000);
	}

	function demoSubmit() {
		$("#createBtn").trigger('click');
	}


})();

	