<?php
session_start();

$base_url = 'http://medilogpro.com/';
$GLOBALS['base_url'] = $base_url;
define('BASE_URL', $base_url);

require_once '../app/init.php';

$app = new App;