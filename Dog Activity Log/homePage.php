<?php
echo "<link href='dogLog.css' rel='stylesheet' type='text/css'>";
echo "<body>";


require_once '../login.php';
$db_server = mysql_connect($host, $username, $password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($dbname)
	or die("Unable to select database: " . mysql_error());

echo '<font size = 30>Dog Activity Log</font>';
echo '<br />Welcome! What would you like to do today? <br>';
echo '<a href="https://samyuravikumar-hour6-csp-samyuravikumar.c9users.io/Dog%20Activity%20Log/exerciseLog.php">View Exercise Log</a> <br>';



echo "</body>";
?>