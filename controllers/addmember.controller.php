<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['addmember'])){
    $fullname = $conn->real_escape_string(strip_tags($_POST['fullname']));
    $dob = $conn->real_escape_string($_POST['dob']);
    $padress = $conn->real_escape_string(strip_tags($_POST['paddress']));
    $taddress = $conn->real_escape_string(strip_tags($_POST['taddress']));
    $mobileno = $conn->real_escape_string(strip_tags($_POST['mobileno']));
    $openingblc = $conn->real_escape_string(strip_tags($_POST['openingblc']));


    $q = "INSERT INTO fin_accounts(name, permanent_Address, temporary_Address, mobile_No, dob) 
        VALUES('".$fullname."','".$padress."','".$taddress."','".$mobileno."','".$dob."')";
    
    $result = $conn->query($q);
    $uid = '';


    if($result === TRUE){

        // To Generate Transaction ID 
        $q = "SELECT * FROM fin_transactions";
        $result = $conn->query($q);
        if($result->num_rows > 0){
            $q = "SELECT MAX(transaction_ID) as txnID FROM fin_transactions";
            $result = $conn->query($q);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                define("TRANSACTION_ID", $row['txnID']+1);
            }
        }else{
            define("TRANSACTION_ID", 1);
        }
        
        // Inserting opening balance transaction 
        $rs = $conn->query('SELECT MAX(account_No) AS maxacc FROM fin_accounts');
        if($rs->num_rows > 0){
            $row = $rs->fetch_assoc();
            $uid = $row['maxacc'];
        }
        $query = "INSERT INTO fin_transactions(account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID)
            VALUES('$uid', 'c', '$openingblc', 'Opening Balance:', 'A', '$dob', '".TRANSACTION_ID."')";
        $conn->query($query);


        $_SESSION['memberadded'] = "Member Added Successfully !";
        header('location: ../dashboard/member/addMember/');
    }else{
        $_SESSION['membernotadded'] = "Member Not Added, Something Wrong !";
        header('location: ../dashboard/member/addMember/');
    }
    
}


?>