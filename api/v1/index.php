<?php

require('../../config.php');

class response {
	var $status;
	var $status_message;
	var $data;
	var $title;
	var $thumbnail;
}

date_default_timezone_set( $TIMEZONE );

if(!in_array($_SERVER['REMOTE_ADDR'], $ALLOWED_IPS)) {
	print json_encode(array("status" => "error", "status_message" => "Not allowed"));
	exit();
}

if(isset($_GET['v'])) {

	if(preg_match('\?v=', $_GET['v'])) {
		$vtag = explode("?v=", $_GET['v'])[1];
	}
	else {
		$vtag = $_GET['v'];
	}

	if(strlen($vtag) < 5) {
		print json_encode(array("status" => "error", "status_message" => "Invalid Link"));
		exit();
	}

	$cmd = "youtube-dl --skip-download --print-json " . $vtag;

	$jsondata = json_decode(shell_exec($cmd));

	$response = new response();

	$response->status = "ok";
	$response->status_message = "ok";
	$response->data = array();
	$response->title = $jsondata->title;
	$response->thumbnail = $jsondata->thumbnail;

	foreach($jsondata->formats as $format) {
		$row = array("format" => $format->format, "format_note" => $format->format_note, "url" => $format->url);
		array_push($response->data, $row);
	}

	print json_encode($response);
}
else {

	print json_encode(array("status" => "error", "status_message" => "Invalid Request"));
}