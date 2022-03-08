<?php
// If video url is submitted
if(!empty($_POST['file']) && !empty($_POST['url'])){
	// YouTube video file info
	$downloadURL = $_POST['url'];
	$fileName = $_POST['file'];
	$fileName = preg_replace('/[^A-Za-z0-9.\_\-]/', '', basename($fileName));
	
	// Define header for force download
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$fileName");
	header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: binary");
	
	// Read the file
	readfile($downloadURL);
}
exit;
?>