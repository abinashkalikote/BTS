<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');

if(isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['processdeposit'])){
    $accountno = $_POST['accountno'];
    $amount = $conn->real_escape_string($_POST['amount']);
    $transactiondate = $conn->real_escape_string($_POST['transactiondate']);
    $remark = $conn->real_escape_string($_POST['remark']);

    
    if($remark == NULL){
        $remark = 'Amount Deposit ';
    }

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

    // c for cash deposit 
    $drcr = 'c';
    // A for active transaction
    $rec_Status = 'A';

    $q = "INSERT INTO fin_transactions(account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID)
        VALUES ('".$accountno."','".$drcr."','".$amount."','".$remark."', '".$rec_Status."' ,'".$transactiondate."', '".TRANSACTION_ID."')";
    
    $result = $conn->query($q);


    if($result === TRUE){
        $_SESSION['amountdeposited'] = "Amount Deposited Successfully !";
        header('location: ../dashboard/deposit/');
    }else{
        $_SESSION['amountnotdeposited'] = "Amount Not Deposited, Something Wrong !";
        header('location: ../dashboard/deposit/');
    }

}





if(isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['processwithdraw'])){
    $accountno = $_POST['accountno'];
    $amount = $conn->real_escape_string($_POST['amount']);
    $transactiondate = $conn->real_escape_string($_POST['transactiondate']);
    $remark = $conn->real_escape_string($_POST['remark']);


    if($remark == NULL){
        $remark = 'Amount Withdraw ';
    }


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

    // c for cash deposit 
    $drcr = 'd';
    
    // A for active transaction
    $rec_Status = 'A';


    // function to check whether he/she has or not a money in his account
    $q = "SELECT amount, drcr FROM fin_transactions WHERE account_No='$accountno' AND rec_Status='A'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['drcr'] == 'd'){
                $dr += (float)$row['amount'];
            }else if($row['drcr'] == 'c'){
                $cr += (float)$row['amount'];
            }

        }
        $accbalancecheck = $cr - $dr;


        // if not balance in account
    if($accbalancecheck <= 0 || $accbalancecheck < $amount){
        $_SESSION['amountnotwithdraw'] = "Insufficient Balance !!";
        header('location: ../dashboard/withdraw/');

        // if balance is sufficient in balance
    }else{
        $q = "INSERT INTO fin_transactions(account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID)
            VALUES ('".$accountno."','".$drcr."','".$amount."','".$remark."','".$rec_Status."','".$transactiondate."', '".TRANSACTION_ID."')";
            
            $result = $conn->query($q);
            
            if($result === TRUE){
            $_SESSION['amountwithdraw'] = "Amount Witdraw Successfully !";
                header('location: ../dashboard/withdraw/');
            }else{
                $_SESSION['amountnotwithdraw'] = "Amount Not Withdraw, Something Wrong !";
                header('location: ../dashboard/withdraw/');
            }
    }

    }
}
?>