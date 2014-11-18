<?php 
if (! isset ( $_SERVER ['PHP_AUTH_USER'] )) {
	header ( 'WWW-Authenticate: Basic realm="Ready Gooo"' );
	header ( 'HTTP/1.0 401 Unauthorized' );
	echo 'Welcome you next time.';
	exit ();
} else {
	$user = $_SERVER ['PHP_AUTH_USER'];
	$password = $_SERVER ['PHP_AUTH_PW'];
	if ($user != 'readygo' || $password != 'readygooo1408') {
		header ( 'WWW-Authenticate: Basic realm="My Realm"' );
		header ( 'HTTP/1.0 401 Unauthorized' );
		die("Welcome you next time.");
	}
	echo "<h>Authenrized</h>";
}
?>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<h1>Ready Go Develop Site</h1>
	<h2>
		<a href="index.php">Test mock Management</a>
	</h2>
	<h1>Develop URL</h1>

	<p>Test account: +86 18611690000</p>
	<p>password: qaz</p>
	
<?php
// get the trade code from server
// get db connect
require 'db_connect.php';

// get all record from the table
$sql = "SELECT url.url, url.explaination as urlExplaination, keyWord.`key`, keyWord.type, 
		keyWord.explaination as keyWordExplaination, 
		url_keyWord.allowEmpty, url.status
		from url
join url_keyWord on url.id = url_keyWord.urlId
join keyWord on url_keyWord.keyWordId = keyWord.id
ORDER BY url.id";

$result = mysql_query ( $sql, $con );
mysql_close ( $con );

// put the record to an array
$record = array ();

while ( $item = mysql_fetch_array ( $result ) ) {
	// put the record to record array
	array_push ( $record, $item );
}

?>
		
<fieldset>
		<legend>Url record</legend>
		<table border="1" cellpadding="10">
			<tr>
				<th>URL</th>
				<th>URLexplaination</th>
				<th>Key</th>
				<th>Type</th>
				<th>KeyWordExplaination</th>
				<th>AllowEmpty</th>
			</tr>
<?php
foreach ( $record as $item ) {
	if ($item [status] == "overTime") {
		echo "<tr style='color:red'>
<td>$item[url]</td>
<td>$item[urlExplaination]</td>
<td>$item[key]</td>
<td>$item[type]</td>
<td>$item[keyWordExplaination]</td>
<td>$item[allowEmpty]</td>
</tr>";
	} else {
		echo "<tr>
<td>$item[url]</td>
<td>$item[urlExplaination]</td>
<td>$item[key]</td>
<td>$item[type]</td>
<td>$item[keyWordExplaination]</td>
<td>$item[allowEmpty]</td>
</tr>";
	}
}
?>
</table>
	</fieldset>
</body>
</html>

