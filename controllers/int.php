<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');

if(isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['calculateinterest'])){

    $accountno = $_POST['accountno'];
    $calculationupto = $_POST['calculationupto'];
    $interestrate = $_POST['interestrate'];
    $taxrate = $_POST['taxrate'];


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


    // Interest Calculation Started
    if($interestrate != 0){
        // current balance check 
        $dr = 0;
        $cr = 0;
        $q = "SELECT amount, drcr, rec_Status FROM fin_transactions WHERE account_No='$accountno' AND rec_Status='A'";
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
            define('BALANCEAMOUNT', $balance);
        }

        if(BALANCEAMOUNT != 0){
            // check wheter there is a data in interest_calculation table associate with account no or not
            $result = $conn->query("SELECT * FROM interest_calculation WHERE account_no='$accountno' AND rec_Status='A'");
            if($result->num_rows > 0){
                // echo "Transaction is in interest table";
                $result = $conn->query("SELECT MAX(date_to) as interestcalculatedupto FROM `interest_calculation` WHERE account_no='$accountno' AND rec_Status='A'");
                if($result->num_rows > 0){

                    $row = $result->fetch_assoc();
                    // defining last interest calculation date
                    define('INTERESTCALCULATEDUPTO',$row['interestcalculatedupto']);

                    // defining last transaction date according to user date send from form
                    if($calculationupto != NULL){
                        define('LASTTRANSACTIONDATE',$calculationupto);
                    }else{
                        // fetching last transaction date of associate account
                        $q = "SELECT MAX(transaction_Date) as lasttransactiondate FROM fin_transactions WHERE account_No='$accountno' AND rec_Status='A'";
                        $result = $conn->query($q);
                        if($result->num_rows > 0){
                            $row = $result->fetch_assoc();
                            define('LASTTRANSACTIONDATE',$row['lasttransactiondate']);
                        }
                    }


                    if(LASTTRANSACTIONDATE == INTERESTCALCULATEDUPTO){
                        $_SESSION['interestnotcalculated'] = "Interest already calculated till today !";
                        header('location: ../dashboard/interest/');
                    }else{
                        // fetching number of days between the INTERESTCALCULATEDUPTO date and LASTTRANSACTIONDATE date
                        $result = $conn->query("SELECT count(*) as totaldays FROM nepali_date WHERE NepaliDate BETWEEN '".INTERESTCALCULATEDUPTO."' AND '".LASTTRANSACTIONDATE."'");
                        if($result->num_rows > 0){
                            $row = $result->fetch_assoc();
                            define('TOTALDAYS', $row['totaldays']);
        
                            $interest = ((BALANCEAMOUNT * $interestrate * TOTALDAYS)/36500);
                            $finalinterest = round($interest, 2, PHP_ROUND_HALF_UP);
                            $tax = round($finalinterest*$taxrate/100, 2, PHP_ROUND_HALF_UP);
        
                            
                            // query to insert into interest_calculation table
                            $q = "INSERT INTO interest_calculation(account_no, date_from, date_to, interest_amount, tax_amount, Remarks, rec_Status, transaction_ID) VALUES ('$accountno', '".INTERESTCALCULATEDUPTO."', '".LASTTRANSACTIONDATE."', '$finalinterest', '$tax', 'Interest Deposited (".INTERESTCALCULATEDUPTO." to ".LASTTRANSACTIONDATE.")', 'A', '".TRANSACTION_ID."')";
                            
                            $result = $conn->query($q);
        
        
                            // query to insert interest deposited transaction in fin_transactions
                            $q = "INSERT INTO fin_transactions (account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID) VALUES ('$accountno', 'c', '$finalinterest', 'Interest Deposited (".INTERESTCALCULATEDUPTO." to ".LASTTRANSACTIONDATE.")', 'A', '".LASTTRANSACTIONDATE."', '".TRANSACTION_ID."')";
        
                            $result = $conn->query($q);
        
        
                            if($tax != 0 || $tax != NULL || $tax != 0.00){
                                // query to insert tax withdraw transaction in fin_transactions
                                $q = "INSERT INTO fin_transactions (account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID) VALUES ('$accountno', 'd', '$tax', 'Tax Withdrawn ".$taxrate."%', 'A', '".LASTTRANSACTIONDATE."', '".TRANSACTION_ID."')";
                                $result = $conn->query($q);
                            }
                            
                            if($result){
                                $_SESSION['interestcalculated'] = "Interest Calculated !";
                                header('location: ../dashboard/interest/');
                            }
                                
        
                        }else{
                            $_SESSION['interestnotcalculated'] = "Interest Not Calculated Due to Same Date !";
                            header('location: ../dashboard/interest/');
                        }
        
                    }
                }
            }else{
                // echo "Not transaction in interest table";
                if($calculationupto != NULL){
                    $q = "SELECT MIN(transaction_Date) as minimumdate FROM fin_transactions WHERE account_No='$accountno' AND rec_Status='A'";
                    $result = $conn->query($q);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        define('MINIMUMDATE',$row['minimumdate']);
                    }
                    define('LASTTRANSACTIONDATE',$calculationupto);
                }else{
                    $q = "SELECT MIN(transaction_Date) as minimumdate, MAX(transaction_Date) as maximumdate FROM fin_transactions WHERE account_No='$accountno' AND rec_Status='A'";
                    $result = $conn->query($q);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        define('MINIMUMDATE',$row['minimumdate']);
                        define('LASTTRANSACTIONDATE', $row['maximumdate']);
                    }
                }

                if(MINIMUMDATE == LASTTRANSACTIONDATE){
                    $_SESSION['interestnotcalculated'] = "Interest Not Calculated !";
                    header('location: ../dashboard/interest/');
                }else{
                    // fetching number of days between the INTERESTCALCULATEDUPTO date and LASTTRANSACTIONDATE date
                    $q = "SELECT count(*) as totaldays FROM nepali_date WHERE NepaliDate BETWEEN '".MINIMUMDATE."' AND '".LASTTRANSACTIONDATE."'";
                    $result = $conn->query($q);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        define('TOTALDAYS', $row['totaldays']);
        
                        $interest = ((BALANCEAMOUNT * $interestrate * TOTALDAYS)/36500);
                        $finalinterest = round($interest, 2, PHP_ROUND_HALF_UP);
                        $tax = round($finalinterest*$taxrate/100, 2, PHP_ROUND_HALF_UP);
                        
        
                        // query to insert into interest_calculation table
                        
                        $result = $conn->query("INSERT INTO interest_calculation(account_no, date_from, date_to, interest_amount, tax_amount, Remarks, rec_Status, transaction_ID) VALUES ('$accountno', '".MINIMUMDATE."', '".LASTTRANSACTIONDATE."', '$finalinterest', '$tax', 'Interest Deposited (".MINIMUMDATE." to ".LASTTRANSACTIONDATE.")', 'A', '".TRANSACTION_ID."')");
        
        
                        // query to insert interest deposited transaction in fin_transactions
                        
                        $result = $conn->query("INSERT INTO fin_transactions (account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID) VALUES ('$accountno', 'c', '$finalinterest', 'Interest Deposited (".MINIMUMDATE." to ".LASTTRANSACTIONDATE.")', 'A', '".LASTTRANSACTIONDATE."', '".TRANSACTION_ID."')");
        
                        if($tax != 0 || $tax != NULL || $tax != 0.00){
                            // query to insert tax withdraw transaction in fin_transactions
                            $result = $conn->query("INSERT INTO fin_transactions (account_No, drcr, amount, remark, rec_Status, transaction_Date, transaction_ID) VALUES ('$accountno', 'd', '$tax', 'Tax Withdrawn ".$taxrate."%', 'A', '".LASTTRANSACTIONDATE."', '".TRANSACTION_ID."')");
                        }
        
                        
                        if($result){
                            $_SESSION['interestcalculated'] = "Interest Calculated !";
                            header('location: ../dashboard/interest/');
                        }
                    }
                }

                
            }            
        }else{
            $_SESSION['interestnotcalculated'] = "You don't have a balance to Calculate Interest !";
            header('location: ../dashboard/interest/');
            // echo "You don't have enough balance to Calculate Interest ";
        }
    }else{
        $_SESSION['interestnotcalculated'] = "Provide Interest Rate !";
        header('location: ../dashboard/interest/');
        // echo "Provide Interest Rate";
    }
}
?>