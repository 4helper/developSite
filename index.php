<?php 
//get the trade code from server
//get db connect
require 'db_connect.php';

//get all record from the table
$sql = "SELECT url.url, url.explaination as urlExplaination, keyWord.`key`, keyWord.type, keyWord.explaination as keyWordExplaination, url_keyWord.allowEmpty from url
join url_keyWord on url.id = url_keyWord.urlId
join keyWord on url_keyWord.keyWordId = keyWord.id
ORDER BY url.id";
$result = mysql_query($sql, $con);
mysql_close ( $con );

// put the record to an array
$record = array ();

// do {
// 	$item = mysql_fetch_array ( $result );
// 	// put the record to record array
// 	array_push ( $record, $item );
// }while ($item);
while ( $item = mysql_fetch_array ( $result ) ) {
	// put the record to record array
	array_push ( $record, $item );
}
$urls = array();
foreach ($record as $item){
	array_push ( $urls, $item[url] );
}
$urls=array_unique($urls);
?>


<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/js/jquery-1.9.1.js" type="text/javascript"></script>
<script src="/js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script src="/js/jquery.form.min.js" type="text/javascript"></script>
<script src="/js/jquery.validate.js" type="text/javascript"></script>
</head>
<body>
	<h1>Ready Go Develop Site</h1>
	<h2>
		<a href="developUrl.php">Develop URL</a>
	</h2>
	<h2>Test mock Management</h2>

	<fieldset>
		<legend>Url</legend>
		<select id="server" name="server address">
			<option value="http://192.168.1.120/">http://192.168.1.120/</option>
			<option value="http://localhost/">http://localhost/</option>
			<option value="http://www.4helper.com/">http://www.4helper.com/</option>
			<option value="https://www.4helper.com/">https://www.4helper.com/</option>
		</select> <select id="url">
		<?php
foreach ( $urls as $url ) {
	echo "<option value=$url>$url</option>";
}

?>
		</select>
		<button id="submit">set url</button>
	</fieldset>
	<fieldset>
		<legend>Key management</legend>
		<p id="setUrl"></p>
		<form id=form action="" method="post" enctype="multipart/form-data">
			<input name="phoneNumber" value="18611697407">Phone Number<br> <input
				name="areaCode" value="86">Area Code<br> <input name="password"
				value="qaz">Password<br> <input name="newPassword">newPassword<br> <input
				name="target_name">target_name<br> <input name="target_content">target_content<br>
			<input name="target_end_time">target_end_time<br> <input
				name="receiver">receiver<br> <input name="target_id">target_id<br> <input
				name="target_status">target_status<br> <input name="eventIdentifier">eventIdentifier<br>
			<input name="sessionCode">sessionCode<br> <input
				name="blockPhoneNumber">blockPhoneNumber<br> <input name="status">status<br>
			<input name="action">action<br> <input name="deviceCode">deviceCode<br>
			<input name="deviceToken">deviceToken<br> <input name="imageUpload"
				type="file">imageUpload<br> <input name="members">members<br> <input
				name="thumb">thumb<br> <input name="helperPhoneNumber">helperPhoneNumber<br>
			<input name="notificationNumber">notificationNumber<br> 
			<input name="checkPhoneNumber">checkPhoneNumber<br> 
			<input name="platForm">platForm<br> 
			<input
				name="fileName">fileName<br> <input type="submit">
		</form>

	</fieldset>
</body>
</html>
<script type="text/javascript">
$(function() {
	$("#submit").click(submitForm);
});
function successSubmit()
{
	jQuery(form).ajaxSubmit(submitForm);
}
function beforeSubmit()
{
	
}

function submitForm()
{
	var myServer = $("#server").val();
	var myUrl = myServer + $("#url").val();
// 	// ajax options modify target
// 	var submitForm = {
// 		beforeSubmit : beforeSubmit, // pre-submit callback
// 		success : successSubmit, // post-submit callback
// 		dataType : 'json',
// 		error : showError,
// 	};
// 	// submit single helper target
// 	$("#form").ajaxSubmit(submitForm);
 	$("#form").attr("action", myUrl) ;
 	$("#setUrl").text(myUrl);

}
function showError() {
	alert("please check your network");
}


</script>


