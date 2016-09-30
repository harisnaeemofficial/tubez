<?php

// APP & SCRIPT SETTINGS

define('APP_NAME', 'TubeZ');
define('APP_URL', 'http://localhost/tubez/');

define('API_FOLDER', 'api/v1/');
define('API_URL', APP_URL . '/' . API_FOLDER );

// TIMEZONE

$TIMEZONE = "Asia/Kolkata";

// IP ADDRESSES ALLOWED TO USE API

$ALLOWED_IPS = array( '::1', $_SERVER['SERVER_ADDR'] );

// NORMAL SETTINGS

$WEBSITE_HEADING = 'Tube<span class="red">Z</span>';

$WEBSITE_TITLE = APP_NAME . "- Free Online Youtube Video Downloader";
$WEBSITE_DESCRIPTION = "Free online youtube video downloader. Search and download youtube videos in HD.";
$WEBSITE_KEYWORDS = "youtube video downloader, youtube, video, downloader";

// YOUTUBE API SETTINGS

$YOUTUBE_API_DEVELOPER_KEY = '';
$YOUTUBE_SEARCH_MAXRESULTS = 20;