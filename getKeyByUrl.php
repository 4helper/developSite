<?php

// get the trade code from server
// get db connect
require 'db_connect.php';
$url = $_GET ["url"];
// $url = "webservicehelper/blockContactByPhoneNumber";
// get all record from the table
$sql = "SELECT keyWord.key from keyWord WHERE id in (
SELECT keyWordId from url_keyWord WHERE urlId =
(SELECT id from url where url = '$url'
))";
$result = mysql_query ( $sql, $con );
mysql_close ( $con );

// put the record to an array
$record = array ();

// do {
// $item = mysql_fetch_array ( $result );
// // put the record to record array
// array_push ( $record, $item );
// }while ($item);
while ( $item = mysql_fetch_array ( $result ) ) {
	// put the record to record array
	array_push ( $record, $item );
}
$keys = array ();
$fixKeys = array (
		'phoneNumber',
		'areaCode',
		'password',
		'sessionCode' 
);
foreach ( $record as $item ) {
	if (! in_array ( $item [key], $fixKeys )) {
		$key = array (
				"key" => $item [key] 
		);
		array_push ( $keys, $key );
	}
}
echo json_encode ( $keys );
?>


