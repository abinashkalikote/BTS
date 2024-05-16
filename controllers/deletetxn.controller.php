<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');


if(isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['txnid']) && isset($_POST['txndate']) && isset($_POST['accid'])){

    $result = $conn->query("SELECT * FROM interest_calculation WHERE account_no={$_POST['accid']} AND rec_Status='A'");
    
    if($result->num_rows > 0){
        $result = $conn->query("SELECT MAX(date_to) as MaxDate, transaction_ID FROM interest_calculation WHERE account_no={$_POST['accid']} AND rec_Status='A'");
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            define('LASTINTERESTCALCULATEDDATE', $row['MaxDate']);
            define('TXNID', $row['transaction_ID']);
        }

        if(LASTINTERESTCALCULATEDDATE > $_POST['txndate']){
            //Interest won't reversed because Interest Calculation date is more than txn
            echo "Transaction can't be reversed !";
        }else if($_POST['txnid'] < TXNID){
            echo "Transaction can't be reversed !";
        }else{
            //Interest will be reversed because Interest Calculation date is less than txn
            $result = $conn->query("UPDATE fin_transactions SET rec_Status='D' WHERE transaction_ID='".$_POST['txnid']."'");
            $result = $conn->query("UPDATE interest_calculation SET rec_Status='D' WHERE transaction_ID='".$_POST['txnid']."'");
            if($result){
                echo "Transaction has been reversed successfully !";
            }else{
                echo "Something Went Wrong";
            }
        }


    }else{
        $result = $conn->query("UPDATE fin_transactions SET rec_Status='D' WHERE transaction_ID='".$_POST['txnid']."'");
        $result = $conn->query("UPDATE interest_calculation SET rec_Status='D' WHERE transaction_ID='".$_POST['txnid']."'");
        if($result){
            echo "Transaction has been reversed successfully !";
        }else{
            echo "Something Went Wrong";
        }
    }
    

}










/*$result = $conn->query("UPDATE fin_transactions SET rec_Status='D' WHERE transaction_ID='".$_GET['txnid']."'");
        $result = $conn->query("UPDATE interest_calculation SET rec_Status='D' WHERE transaction_ID='".$_GET['txnid']."'");
        if($result){
            echo "Transaction has been reversed successfully !";
        }else{
            echo "Something Went Wrong";
        }*/
?>


