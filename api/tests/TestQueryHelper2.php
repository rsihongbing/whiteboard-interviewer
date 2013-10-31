<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class QueryHelperTest extends UnitTestCase {
        
        function testAddandDropUser() {
        	$helper = new QueryHelper();
        	
        	// add new user
        	$num_rows_before = $this->tcount($helper, "users");
        	$user_id = $helper->add_user('Test', 'test@yahooo.com', NULL , '4254637474', 'Sleeper');
        	$num_rows_after = $this->tcount($helper, "users");
        	
        	// check that numer of rows increases
        	$this->assertEqual($num_rows_before + 1 , $num_rows_after);
        	
        	// check each value
        	$results = $helper->execute("select * from users where id = $user_id ")->fetchAll()[0];
        	$this->assertEqual('Test', $results['name']);
        	$this->assertEqual('test@yahooo.com', $results['email']);
        	$this->assertNull($results['gender']);
        	$this->assertEqual('4254637474', $results['phone']);
        	$this->assertEqual('Sleeper', $results['affiliation']);
        	
        	// delete that user
        	$helper->drop_user($user_id);
        	$num_rows_after_after = $this->tcount($helper, "users");
        	
        	$this->assertEqual($num_rows_after , $num_rows_after_after + 1);
        }
        
        function testAddandDropSession() {
        	$helper = new QueryHelper();
        	
        	// add new session
        	$num_interview_rows_before = $this->tcount($helper, "interviews");
        	$num_schedule_rows_before = $this->tcount($helper, "schedules");
        	$num_validation_rows_before = $this->tcount($helper, "validations");
        	$num_participants_rows_before = $this->tcount($helper, "participants");
        	$interview_id = $helper->create_session('Waddap', date("Y-m-d H:i:s", strtotime("+1 day")), 'EDSd7erbtv', 1, 2);
        	
        	
        	$num_interview_rows_after = $this->tcount($helper, "interviews");
        	$num_schedule_rows_after = $this->tcount($helper, "schedules");
        	$num_validation_rows_after = $this->tcount($helper, "validations");
        	$num_participants_rows_after = $this->tcount($helper, "participants");
        	
        	// check increase by 1
        	$this->assertEqual($num_interview_rows_before + 1 , $num_interview_rows_after);
        	$this->assertEqual($num_schedule_rows_before + 1 , $num_schedule_rows_after);
        	$this->assertEqual($num_validation_rows_before + 1 , $num_validation_rows_after);
        	$this->assertEqual($num_participants_rows_before + 1 , $num_participants_rows_after);
        	
        	
        	// check the value
        	$this->assertEqual('Waddap', $helper->execute("select title from interviews where id = $interview_id")->fetchAll()[0]['title'] );
        	$this->assertEqual(date("Y-m-d H:i:s", strtotime("+1 day")), $helper->execute("select date_prepared from schedules where interview_id = $interview_id")->fetchAll()[0]['date_prepared'] );
        	$this->assertEqual('EDSd7erbtv', $helper->execute("select password from validations where interview_id = $interview_id")->fetchAll()[0]['password'] );
        	$this->assertEqual(1, $helper->execute("select interviewer_id from participants where interview_id = $interview_id")->fetchAll()[0]['interviewer_id'] );
        	$this->assertEqual(2, $helper->execute("select interviewee_id from participants where interview_id = $interview_id")->fetchAll()[0]['interviewee_id'] );

        	// drop seession
        	
        	$helper->drop_session($interview_id);
        }
        
        private function tcount($helper,$table) {
        	return $helper->execute("select count(*) as num from $table")->fetchAll()[0]['num'];
        }
        
        
}

?>