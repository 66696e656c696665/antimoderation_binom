<?php
include 'binom_click_api.php';
$unic_token = $unic_token;
//echo phpinfo();

//echo '<html><pre>';
//var_dump($getClick->DataClick['geo']['ip']['ip']);
//$getClick->DataClick['campaign']["binom_cloak_bot"];
//echo var_dump(get_defined_vars());
//echo '</pre></html>';


$white = stripos('qqq'.$getClick->DataClick['landing']['name'], 'white');

if (!$_GET[$unic_token] || stripos('qqq'.$_GET[$unic_token], '{')){
	include('./white.php');
	exit();
}

$black_box = check_blackbox($getClick->DataClick['geo']['ip']['ip']);


$limit_clicks = 15;

$dbname = './unics.db';

$token = $_GET[$unic_token];


if(!file_exists($dbname)){
	$db=new SQLite3($dbname);
	$sql="CREATE TABLE stats(id INTEGER PRIMARY KEY, token TEXT, clicks INTEGER, ping INTEGER)";
	$db->query($sql);
} else {
    $db=new SQLite3($dbname);
}

$sql = "SELECT * FROM stats WHERE token = '$token'";
$result = $db->querySingle($sql, true);
if ($result){
	$sql = "UPDATE stats SET clicks = clicks + 1 WHERE token = '$token'";
    $result = $db->exec($sql);
} else {
	$requare = "INSERT INTO stats(token, clicks) VALUES('$token', 1)";
	$db->exec($requare);
}

$sql = "SELECT * FROM stats WHERE token = '$token'";
$result = $db->querySingle($sql, true);
$unics = $result['clicks'];
if ($unics > $limit_clicks && $black_box && !$white){
	$getClick->getLanding();
} else {
	include('./white.php');
}	
	
?>