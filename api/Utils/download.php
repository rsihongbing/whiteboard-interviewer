<?php

if(empty($_POST['filename']) || empty($_POST['content'])){
	exit;
}

$filename = $_POST['filename'];

header("Cache-Control: ");
header("Content-type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'"');

echo $_POST['content'];

?>
