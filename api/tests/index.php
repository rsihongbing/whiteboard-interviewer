<?php
	// Grap all test cases in the current directory
	$testCases = glob("Test*.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8 />
		<title>Unit Test index</title>
	</head>
	<body>
		<h1>Test cases:</h1>
		<ul>
			<?php 
			foreach ($testCases as $test) { ?>
				<li><a href="<?= $test ?>"><?= basename($test) ?></a></li>
			<?php } ?>
		</ul>
	</body>
</html>
