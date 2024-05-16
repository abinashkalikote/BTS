<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');



if($_SERVER['REQUEST_METHOD']=='GET'){
    $accid = $_GET['accid'];
    $dr = 0;
    $cr = 0;
    $q = "SELECT amount, drcr, rec_Status FROM fin_transactions WHERE account_No='$accid'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            
            if($row['rec_Status'] == 'A'){
                if($row['drcr'] == 'd'){
                    $dr += (float)$row['amount'];
                }else if($row['drcr'] == 'c'){
                    $cr += (float)$row['amount'];
                }
            }

        }
        $balance = $cr - $dr;
        $output = '
        <h1>Account Details</h1>
            <hr>
            <div id="currentbalance" style="margin-top: 2rem;">
                <h3 style="color:rgb(2, 129, 76);">Current Balance</h3>
                <div id="showbalance">
                    &nbsp;&nbsp;&nbsp;'.number_format($balance, 2, ".",",").'
                </div>
            </div>';

        
        $query = "SELECT MAX(transaction_Date) AS lasttxndate FROM fin_transactions WHERE account_No='$accid' AND rec_Status<>'D'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $lastxndate = $row['lasttxndate'];
        }

        $output .= '
        <div id="currentbalance" style="margin-top: 2rem;">
                <h4 style="color:rgb(2, 129, 76);">Last Transaction Date</h4>
                <div id="showbalance">
                    &nbsp;&nbsp;&nbsp; '.$lastxndate.'
                </div>
            </div>';
            echo $output;
    }
}


?>