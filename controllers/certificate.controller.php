<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');



if(isset($_SERVER['REQUEST_METHOD'])=='GET' && isset($_GET['accid']) && isset($_GET['usdvalue'])){
    $accid = $_GET['accid'];
    $dr = 0;
    $cr = 0;
    $blcamt = 0;
    $counter = 0;
    $usdvalue = $_GET['usdvalue'];

    $data = '<h1 contenteditable="true" style="margin-top: 3rem;display:block;text-align:center;">Ex Development & Commercial Bank Ltd.</h1>
            <h3 contenteditable="true" style="display:block;text-align:center;">Birtamod - 4, Jhapa Nepal.</h3>';

    $data .= '<div style="display:block;text-align:center; font-size: 2rem; margin-top: 2rem;text-decoration:underline;text-underline-offset: 10px;">BALANCE CERTIFICATE</div>';

    $data .= '<br><br><h3 contenteditable="true" style="display:block;text-align:center;">TO WHOM IT MAY CONCERN</h3>';

        // query to show account holder name, account no 
    $q = "SELECT * FROM fin_accounts WHERE account_No='$accid'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            define('ACCNAME',$row['name']);
            define('ACCNO', $row['account_No']);
        }
    }




// query to show opening balance and closing balance

$q = "SELECT * FROM fin_transactions WHERE account_No='$accid' ORDER BY transaction_Date ASC";
$result = $conn->query($q);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

       if($row['remark'] == 'Opening Balance:'){
            define('OPDATE', $row['transaction_Date']);
            define('OPBALANCE', $row['amount']);

        }else{
            if($row['rec_Status']=='A'){
                if($row['drcr'] == 'c'){

                    $cr += (float)$row['amount'];
    
                }else if($row['drcr'] == 'd'){
    
                    $dr += (float)$row['amount'];
                }
            }
       }
    }
    define('CLBALANCE', (float)$cr - (float)$dr + (float)OPBALANCE);
}


$result = $conn->query("SELECT * FROM fin_accounts WHERE account_No='$accid'");
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        define('ACCHOLDER_NAME', $row['name']);
        define('ADDRESS', $row['permanent_Address']);
        define('ACCOUNT_NO', 'BTS2022'.$row['account_No']);
    }
}

$data .='<div class="table">
<table>
    <tr>
        <td>A\C Name</td>
        <td>:</td>
        <td>'.ACCHOLDER_NAME.'</td>
    </tr>
    <tr>
        <td>Address</td>
        <td>:</td>
        <td>'.ADDRESS.'</td>
    </tr>
    <tr>
        <td>Account no:</td>
        <td>:</td>
        <td contenteditable="true">'.ACCOUNT_NO.'</td>
    </tr>
        <tr>
        <td>A\C Type</td>
        <td>:</td>
        <td>Normal Saving</td>
    </tr>
    <tr>
        <td>Currency:</td>
        <td>:</td>
        <td>NPR</td>
    </tr>
</table></div>';



$year = date('Y');
$month = date('M');
$stth = date('S');
$day = date('d');

$data .= '<div class="certificate-text">
    &nbsp;&nbsp;&nbsp;&nbsp;Has a total balance of NPR :  ( '.number_format(CLBALANCE,2).' ) in word Rupess (<span id="notowords"></span><script> document.getElementById("notowords").innerHTML = get_nepali_currency('.CLBALANCE.');</script>) which is equivalent to USD  '.number_format(round(CLBALANCE/$usdvalue, 2, PHP_ROUND_HALF_UP),2).' at the prevailing exchange rate of 1 USD: '.$usdvalue.' ('.$day.'<sup>'.$stth.'</sup> '.$month.' '.$year.')
    This certificate has been issued as per the account holder with out any obligation on the part of <span contenteditable="true">Ex Development & Commercial Bank Ltd.</span>.
</div>';


$data .= '
<table style="width: 100%; margin-top: 5cm;">
    <tr>
        <th style="text-decoration: underline;text-underline-offset: -0.5cm;">Authorised Signature</th>
        <th style="text-decoration: underline;text-underline-offset: -0.5cm;">Authorised Signature</th>
    </tr>
</table>';

$data .='
    <div class="certificate-footer" contenteditable="true">
        <span>For Confirmation of balance or details of account statement, kindly contact us at Ex Development & Commercial Bank Ltd.,</span>
        <span>Birtamod, Jhapa , Nepal, Tel: (977)23-5814582, 5814583, Fax: 23-5814552 or email us at info@msexcelbank.com</span>
    </div>
';
 


echo $data;

// Function to create date as 30-04-2022 from  2022-04-30
function dateconvert($date){
    $opdate = explode('/', $date);
    $newopdate = $opdate[2].'-'.$opdate[1].'-'.$opdate[0];
    return $newopdate;
}
}
?>