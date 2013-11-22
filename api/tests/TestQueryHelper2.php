<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class QueryHelperTest extends UnitTestCase {

	function testCheck() {
		$helper = new QueryHelper();

		$this->assertEqual($helper->check_url('a46qwr803na24'),1);
		$this->assertEqual($helper->check_url("asdasdasd"),0);

		$this->assertEqual($helper->check_password("gj37hadnkds"),1);
		$this->assertEqual($helper->check_password("asd2135jrtk"),1);
		$this->assertEqual($helper->check_password("asdasd"),0);
		
		$this->assertEqual($helper->check_email("dannych@uw.edu"),1);
		$this->assertEqual($helper->check_email('dannych@uw.edu'),1);
		$this->assertEqual($helper->check_email("asdasdasd@asd.aw"),0);
	}
	
	function testSessionValidationInfo() {
		$helper = new QueryHelper();
		$countr = 0;
		
		// existing url
		try {
			$this->expectException($helper->create_session('a46qwr803na24', 'dannych@uw.edu', 'ynamara@uw.edu', 'asd', 'asdasd' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ));
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode() , 0);
			$countr++;	
		}
		
		try {
	 		// same interviewer/ee emails
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'dannych@uw.edu', 'dannych@uw.edu', 'asd', 'asdasd' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 1);
			$countr++;
		}
		
		try {
	 		// same interviewer/ee password
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'dannych@uw.edu', 'ynamara@uw.edu', 'asd', 'asd' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 2);
			$countr++;
		}
		
		try {
	 		// existing interviewer password
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'dannych@uw.edu', 'ynamara@uw.edu', 'gj37hadnkds', 'asdasd' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 4);
			$countr++;
		}
		
		try {
	 		// existing interviewee password
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'dannych@uw.edu', 'ynamara@uw.edu', 'asd', 'asd2135jrtk' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 3);
			$countr++;
		}
		
		try {
			// not exist interviewer email
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'test@uw.edu', 'ynamara@uw.edu', 'asd', 'afwefb' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 5);
			$countr++;
		}
		
		try {
			// not exist interviewer email
			$this->assertFalse($helper->create_session('asdfqwer123423fasd', 'ynamara@uw.edu', 'test2@uw.edu', 'asd', 'afwefb' , date("Y-m-d H:i:s", strtotime("+1 day")), 'asdasdasd', 'qwerqwer' ) );
		} catch (Exception $e) {
			$this->assertEqual( $e->getCode(), 5);
			$countr++;
		}
		
		$this->assertEqual( $countr, 7);
	}
	
	function testGetUser() {
		$helper = new QueryHelper();
		
		$user = $helper->find_user_by_email('dannych@uw.edu');
		
		$this->assertEqual($user['name'], 'Danny Ch');
		
		$user = $helper->find_user_by_email('daasdnnych@uw.edu');
		
		$this->assertNull($user);
	}


	function testAddandDropUser() {
		$helper = new QueryHelper();
			
		// add new user
		$num_rows_before = $this->tcount($helper, "users");
		$helper->add_user('test@yahooo.com', 'Test', NULL , '4254637474');
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
		
		// reset the auto increment
		$num_rows_before += 1;
		$helper->execute("ALTER TABLE `users` AUTO_INCREMENT $num_rows_before");
	}

	function testAddandDropSession() {
		$helper = new QueryHelper();
		$time = date("Y-m-d H:i:s", strtotime("+1 day"));
		// add new session
		$num_interview_rows_before = $this->tcount($helper, "interviews");
		$helper->create_session('vrabstd7', 'dannych@uw.edu' ,  'ynamara@uw.edu', 'asdu4w97vny' , '89uwn5by98', $time , 'Waddap', 'Testing' );


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
		$this->assertEqual(date("Y-m-d H:i:s",strtotime($session['date_scheduled'])), $time );
		
		
		// drop seession
		$helper->drop_session('vrabstd7');
	}

	private function tcount($helper,$table) {
		return $helper->execute("select count(*) as num from $table")->fetchAll()[0]['num'];
	}


}

?>