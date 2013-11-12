<?php
    require_once '../Utils/QueryHelper.php';

	$helper = new QueryHelper();
	
	try {
		// create session
		$helper->add_user('InterViewer', 'interviewer@test.edu', 'M', "4254638074");
		$helper->add_user('InterViewee', 'interviewee@test.edu', 'F', "4254637065");
		$interview = $helper->create_session('vrabstd7', 'Testing Interview', 'Testing', 'dannych@uw.edu' , 'asdu4w97vny',  'ynamara@uw.edu' , '89uwn5by98', date("Y-m-d H:i:s", strtotime("+1 day")));
		
		// delete created session
		$interviewer = $helper->find_user_by_email('interviewer@test.edu')['id'];
		$interviewee = $helper->find_user_by_email('interviewee@test.edu')['id'];
		
		$helper->drop_session('vrabstd7');
		$helper->drop_user($interviewer);
		$helper->drop_user($interviewee);
		
	} catch (PDOException $ex) {
        echo $ex->getMessage();
    }
?>