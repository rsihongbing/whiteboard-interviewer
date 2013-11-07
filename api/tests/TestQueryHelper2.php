<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class QueryHelperTest extends UnitTestCase {

	function testCheck() {
		$helper = new QueryHelper();

		$this->assertFalse($helper->check_url("a46qwr803na24"));
		$this->assertTrue($helper->check_url("asdasdasd"));

		$this->assertFalse($helper->check_password("gj37hadnkds"));
		$this->assertFalse($helper->check_password("asd2135jrtk"));
		$this->assertTrue($helper->check_password("asdasd"));
	}
	
	function testGetUser() {
		$helper = new QueryHelper();
		
		$user = $helper->find_user_by_email('dannych@uw.edu');
		
		$this->assertEqual($user['name'], 'Danny Ch');
	}


	function testAddandDropUser() {
		$helper = new QueryHelper();
			
		// add new user
		$num_rows_before = $this->tcount($helper, "users");
		$user_id = $helper->add_user('Test', 'test@yahooo.com', NULL , '4254637474');
		$num_rows_after = $this->tcount($helper, "users");
			
		// check that numer of rows increases
		$this->assertEqual($num_rows_before + 1 , $num_rows_after);
			
		// check each value
		$results = $helper->find_user_by_email('test@yahooo.com');
		$this->assertEqual('Test', $results['name']);
		$this->assertEqual('test@yahooo.com', $results['email']);
		$this->assertNull($results['gender']);
		$this->assertEqual('4254637474', $results['phone']);
			
		// delete that user
		$helper->drop_user($results['id']);
		$num_rows_after_after = $this->tcount($helper, "users");
			
		$this->assertEqual($num_rows_after , $num_rows_after_after + 1);
	}

	function testAddandDropSession() {
		$helper = new QueryHelper();

		// add new session
		$num_interview_rows_before = $this->tcount($helper, "interviews");
		$interview_url = $helper->create_session('vrabstd7', 'Waddap', 'Testing', 'dannych@uw.edu' , 'asdu4w97vny',  'ynamara@uw.edu' , '89uwn5by98', date("Y-m-d H:i:s", strtotime("+1 day")) );


		$num_interview_rows_after = $this->tcount($helper, "interviews");

		// check increase by 1
		$this->assertEqual($num_interview_rows_before + 1 , $num_interview_rows_after);

		// check the value
		$session = $helper->get_session('vrabstd7');
		
		$this->assertEqual($session['url'],'vrabstd7' );
		$this->assertEqual($session['title'],'Waddap' );
		$this->assertEqual($session['description'],'Testing' );
		$this->assertEqual($session['interviewer_id'],1 );
		$this->assertEqual($session['interviewer_password'],'asdu4w97vny' );
		$this->assertEqual($session['interviewee_id'],2 );
		$this->assertEqual($session['interviewee_password'],'89uwn5by98' );
		$this->assertEqual($session['date_scheduled'], date("Y-m-d H:i:s", strtotime("+1 day")) );
		
		
		// drop seession
		$helper->drop_session($interview_url);
	}

	private function tcount($helper,$table) {
		return $helper->execute("select count(*) as num from $table")->fetchAll()[0]['num'];
	}


}

?>