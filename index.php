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
		die ( "Welcome you next time." );
	}
	echo "<h>Authenrized</h>";
}
// get the trade code from server
// get db connect
require 'db_connect.php';

// get all record from the table
$sql = "SELECT url.url, url.explaination as urlExplaination, keyWord.`key`, keyWord.type, keyWord.explaination as keyWordExplaination, url_keyWord.allowEmpty from url
join url_keyWord on url.id = url_keyWord.urlId
join keyWord on url_keyWord.keyWordId = keyWord.id
ORDER BY url.id";
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
$urls = array ();
foreach ( $record as $item ) {
	array_push ( $urls, $item [url] );
}
$urls = array_unique ( $urls );
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
			<option value="http://123.57.133.183/">http://123.57.133.183/</option>
			<option value="http://localhost/">http://localhost/</option>
			<option value="http://localhost:8080/">http://localhost:8080/</option>
			<option value="http://www.4helper.com/">http://www.4helper.com/</option>
			<option value="https://www.4helper.com/">https://www.4helper.com/</option>
		</select> <select id="url">
			<option>Please choose your action</option>
		<?php
		foreach ( $urls as $url ) {
			echo "<option value=$url>$url</option>";
		}
		
		?>
		</select>
		<button id="setUrl">set url</button>
	</fieldset>
	<fieldset>
		<legend>Key management</legend>
		<p id="setedUrl"></p>
		<form id=form action="" method="post" enctype="multipart/form-data">
			<h5>fix keys</h5>
			<table>
				<tr>
					<td><input name="phoneNumber" value="18611697407" id="phoneNumber" />
						Phone Number</td>
				</tr>
				<tr>
					<td><input name="areaCode" value="86" /> Area Code</td>
				</tr>
				<tr>
					<td><input name="password" /> password</td>
				</tr>
				<tr>
					<td><input name="sessionCode" id="sessionCode" value="">
						sessionCode</td>
					<td></td>
					<td><a href="#" id="getSessionCode">Get sessionCode</a></td>
				</tr>
			</table>
			<hr>
			<h5>keys according url</h5>
			<table id="inputTable">
			</table>
			<hr>
			<h5>files</h5>
			<input name=uploadFile type="file">uploadFile
			<hr>
			<input type="submit">
		</form>

	</fieldset>
	<fieldset>
		<legend>Results</legend>
		<div id="results"></div>
	</fieldset>
</body>
</html>
<script type="text/javascript">
$(function() {
	$("#setUrl").click(setUrl);
	$("#getSessionCode").click(getSessionCode);
	$("#url").change(getKeysByUrl);

	//submit form
	// ajax options modify target
	var options = {
		beforeSubmit : beforeSumbitForm, // pre-submit callback
		success : successFeedBack, // post-submit callback
		dataType : 'json',
		error : showError,
	};
	// submit single helper target
	$("#form").validate({
		submitHandler : function(form) {
			// Submit form by Ajax
			jQuery(form).ajaxSubmit(options);
		}
	});
});


function successFeedBack()
{
	alert("successFeedBack");
}
function beforeSumbitForm()
{
	alert("beforeSumbitForm");
}

//get keys according url
function getKeysByUrl()
{
	var url = $("#url").val();
	//set form action
	setFormAction(url);
	//get key according url
	$.getJSON('getKeyByUrl.php', {url: url}, function(json) {
		//clear table history
		$(".alterKey").remove();
		for(index in json){
			var tr = $("<div class='alterKey'></div>");
			var input = $("<input name='" + json[index]['key'] + "'>"+json[index]['key']+"</br>");
			tr.append(input);
			$("#inputTable").append(tr);
// 			alert("index");
		}
	});
}

function setFormAction(url)
{
	url = "/" + url;
	alert(url);
	$("#form").attr("action", url);
}

//get sessionCode according phoneNumber
function getSessionCode()
{
	var phoneNumber = $("#phoneNumber").val();
	$.getJSON('getSessionCode.php', {phoneNumber:phoneNumber}, function(json) {
		$("#sessionCode").attr("value", json.sessionCode);
	});
}

function successSubmit()
{
	jQuery(form).ajaxSubmit(submitForm);
}
function beforeSubmit()
{
	
}

function setUrl()
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
 	$("#setedUrl").text(myUrl);
}


function showError() {
	alert("please check your network");
}


</script>


