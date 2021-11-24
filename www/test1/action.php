<?php 

// var_dump($_POST); 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$str = <<<EOD
   ${_POST["myId"]} <br /> ${_POST["myFile"]} <br /> ${_POST["mySign"]}
EOD;

echo $str;

$myId=$_POST["myId"]; 
$myFile=$_POST["myFile"];
$mySign=$_POST["mySign"];

if (!file_exists($myId)) {
    if (!mkdir($myId, 0777, true)) {
        die('Не удалось создать директории...');
    }
        
}


$myfile = file_put_contents(join(DIRECTORY_SEPARATOR, array($myId, 'myFile')), $myFile.PHP_EOL ,  LOCK_EX);
$mySign = file_put_contents(join(DIRECTORY_SEPARATOR, array($myId, 'mySign')), $mySign.PHP_EOL ,  LOCK_EX);


http_response_code(202);
?>