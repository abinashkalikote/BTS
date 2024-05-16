<?php
session_start();
require('./constants/conn.constant.php');


if(isset($_POST['licenseUpdate'])){
    $orgname = $_POST['orgname'];
    
    $data = $_POST['license'];
    $chiper = "AES-128-CBC";
    $key = "BTSLIC@123456@Forever**&&^^";
    $options = 0;
    $iv = "IISLOVECODINGPHP";
    
    $ddata = openssl_decrypt($data, $chiper, $key, $options, $iv);
    $exp = explode("@", $ddata);
    
    if($exp[0] == $orgname){
        $result = $conn->query("UPDATE license SET `orgName`='$exp[0]', `validUpto`='$exp[1]', `license`='$data', recDate=NOW()");
        header("Location: ./");
    }else{
        $_SESSION['licnotchanged'] = "License not valid !";
        header('location: ./lic.php');

    }
}else{
    header('location: ./');
}


?>