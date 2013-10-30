<?php
    require_once '../Utils/QueryHelper.php';

	$helper = new QueryHelper();
	
	try {
		$interviewer = $helper->add_user('Inter', 'Viewer', 'interviewer@test.edu', 'M', '4254638074', 'Interviewer');
		$interviewee = $helper->add_user('Inter', 'Viewee', 'interviewee@test.edu', 'F', '4254637065', 'Jobless');
		$interview = $helper->create_session('Test interview query 1', date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdaw423v4', $interviewer, $interviewee);
	} catch (PDOException $ex) {
        echo $ex->getMessage();
    }
?>