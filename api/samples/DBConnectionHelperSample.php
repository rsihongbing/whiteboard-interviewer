<?php 
	require_once '../Utils/DBConnectionHelper.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8 />
		<title>This is a page that runs PHP</title>
	</head>
	<body>
		<h1>Fetching datas from db...</h1>

	<table border="1">
		<caption>interviews</caption>
		<tr>
			<th>interviews.id</th>
			<th>interviews.title</th>
		</tr>
		<?php
			try {
				DBConnectionHelper::initialize();
				$query = "select * from interviews limit 5";
				$rows = DBConnectionHelper::executeQuery($query);
				foreach ($rows as $row) { ?>
					<tr>
						<td><?=$row["id"]?></td>
						<td><?=$row["title"]?></td>
					</tr>
				<?php }
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}
 		?>
	</table>
	
	<table border="1">
		<caption>participants</caption>
		<tr>
			<th>participants.interview_id</th>
			<th>participants.interviewer_id</th>
			<th>participants.interviewee_id</th>
		</tr>
		<?php
			try {
				DBConnectionHelper::initialize();
				$query = "select * from participants limit 5";
				$rows = DBConnectionHelper::executeQuery($query);
				foreach ($rows as $row) { ?>
					<tr>
						<td><?=$row["interview_id"]?></td>
						<td><?=$row["interviewer_id"]?></td>
						<td><?=$row["interviewee_id"]?></td>
					</tr>
				<?php }
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}
 		?>
	</table>
</body>
</html>