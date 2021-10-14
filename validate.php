<?php
require_once('rfc6238.php');

$secretkey = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
$email = strval($_POST['email']);
$password = strval($_POST['password']);
$otp = $_POST['otp'];

function logError(){
    $tanggal=date('M j H:i:s');
    system("echo " . $tanggal . " GAGAL " . $_SERVER['REMOTE_ADDR'] . " >> /var/www/html/log/report");
}

if(TokenAuth6238::verify($secretkey,$otp)){
    if($email == "tes@tes.com" && $password == "pass"){
        return http_response_code(200);
    }else{
        logError();
        return http_response_code(401);
    }
}else{
    logError();
    return http_response_code(401);  
}
?>