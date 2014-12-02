<?php
// get db connect
require 'db_connect_blueSky.php';
// get phoneNumber
$phoneNumber = $_GET["phoneNumber"];
// get all record from the table
$sql = "SELECT sessionCode from users where phoneNumber = '$phoneNumber'";
$result = mysql_query ( $sql, $con );
mysql_close ( $con );
$item = mysql_fetch_array ( $result );
if (!$item[sessionCode]) {
	$item[sessionCode] = "cant find sessionCode";
}

//prepare array for json
$array = array(
	"sessionCode" => $item[sessionCode],
);

echo json_encode($array);
