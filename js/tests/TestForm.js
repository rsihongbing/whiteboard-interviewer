(function(){
	

	var $_title = $('#interviewTitle');
	var $_description = $('#interviewDescription');
	var $_interviewerEmail = $('#interviewerEmail');
	var $_intervieweeEmail = $('#intervieweeEmail');
	var $_date = $('#interviewDate');
	var $_time = $('#interviewTime');

	function testAll() {
		testInitialize();
		testCheckInterviewerEmail();
		testCheckIntervieweeEmail();
	}

	function testInitialize() {
		$.fn.isNormal = function() {
			return !$(this).hasClass('has-error') && !$(this).hasClass('has-success');
		}

		var form = new InterviewForm();
		form.initialize();

		test("Test initial values", function() {
			equal($_title.val(), '', "The title must be empty" );	
			equal($_description.val(), '', "The description must be empty");
			equal($_intervieweeEmail.val(), '', "The interviewee's email must be empty");
			equal($_interviewerEmail.val(), '', "The interviewer's email must be empty");
			equal($_date.val(), '', "The date must be empty");
			// equal($_time.val(), 'Anytime', "The time must be Anytime");
		});
		form.initialize();

		test("Test checking the state effects", function() {
			ok($_interviewerEmail.isNormal(), "The interviewer email field must be normal");
			ok($_intervieweeEmail.isNormal(), "The interviewee email field must be normal");
			ok($_date.isNormal(), "The date field must be normal");
			ok($_time.isNormal(), "The time field must be normal");
		});
		form.initialize();
	}

	function testCheckInterviewerEmail() {
		var form = new InterviewForm();

		var check1 = function(email) {
			$_interviewerEmail.val(email);
			var result = form.checkInterviewerEmail();
			$_interviewerEmail.val('');
			return result;
		}

		form.initialize();

		test("Test valid interviewer email", function() {
			ok(check1("dannych@uw.edu"),"dannych@uw.edu is valid");
			ok(check1("ynamara@gmail.com"),"ynamara@gmail.com is valid");
			ok(check1("asd123@lycos.my"),"asd123@lycos.my is valid");
		});

		form.initialize();

		test("Test invalid interviewer email", function() {
			ok(!check1("asdasdasd"),"asdasdasd is NOT valid");
			ok(!check1("asdasdasd@asdasdasd"),"asdasdasd@asdasdasd is NOT valid");
			ok(!check1("asdlycos.my"),"asdlycos.my is NOT valid");
		});

		form.initialize();

		test("Similar email to interviewee email", function() {
			$_intervieweeEmail.val("dannych@uw.edu");
			$_interviewerEmail.val("dannych@uw.edu");

			ok(!form.checkInterviewerEmail(),"Interviewer email and interviewee email can NOT be the same");
		});

		form.initialize();
		
	}

	function testCheckIntervieweeEmail() {
		var form = new InterviewForm();
		form.initialize();

		var check2 = function(email) {
			$_intervieweeEmail.val(email);
			var result = form.checkIntervieweeEmail();
			$_intervieweeEmail.val('');
			return result;
		}

		test("Test valid  interviewee email", function() {
			ok(check2("123asdasd@uasdw.edu"),"dannych@uw.edu is valid");
			ok(check2("yasd@uw.edu"),"yasd@uw.edu is valid");
			ok(check2("tjong@live.com"),"tjong@live.com is valid");
		});

		form.initialize();

		test("Test invalid interivewee email", function() {
			ok(!check2("@"),"@ is NOT valid");
			ok(!check2("<script>alert(1)</script>"),"<script>alert(1)</script> is NOT valid");
			ok(!check2("<body src=# onload='alert(1)'>"),"<body src=# onload='alert(1)'> is  NOT valid");
		});

		form.initialize();

		test("Similar email to interviewer email", function() {
			$_intervieweeEmail.val("dannych@uw.edu");
			$_interviewerEmail.val("dannych@uw.edu");

			ok(!form.checkIntervieweeEmail(),"Interviewer email and interviewee email can NOT be the same");
		});

		form.initialize();
	}

	testAll();
})();
