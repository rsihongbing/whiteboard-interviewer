<?php
	// Grap all test cases in the current directory
	$testCases = glob("Test*.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Test Cases</title>
</head>
<body>
	<?php 
		foreach ($testCases as $test) { ?>
			<li><a href="<?= $test ?>"><?= basename($test) ?></a></li>
	<?php } ?>
</body>
</html>