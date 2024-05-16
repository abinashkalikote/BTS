<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');



if(isset($_SERVER['REQUEST_METHOD'])=='GET' && isset($_GET['accid'])){
    $accid = $_GET['accid'];
    $dr = 0;
    $cr = 0;
    $blcamt = 0;
    $counter = 0;

    $data = '    <h1  contenteditable="true">Grima Bikas Bank Ltd.</h1>
    <div class="userinfo">
    <div class="userdetail" contenteditable="true">
        <pre>';


        // query to show account holder name, account no 
    $q = "SELECT * FROM fin_accounts WHERE account_No='$accid'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            define('ACCNAME',$row['name']);
            define('ACCNO', $row['account_No']);
        }
    }

   $data .= 
'<b>Electronic Account Statement</b>   
Account Name:    <span id="accountname">'.strtoupper(ACCNAME).'</span>
Account Number: BTS2022'.ACCNO.'
Interest Rate: 7%
Currency Code:  NPR
    </pre>
</div>';


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


$query = "SELECT MAX(transaction_Date) AS lasttxndate FROM fin_transactions WHERE account_No='$accid' AND rec_Status<>'D'";
$result = $conn->query($query);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $lastxndate = $row['lasttxndate'];
}


$data .= 
'<div class="userdate" contenteditable="true">
    <pre>
    <b>From '.OPDATE.' TO '.$lastxndate.'</b>  
    Opening Balance:
    '.number_format(OPBALANCE,2,'.',',').'
    Closing Balance:
    '.number_format(CLBALANCE, 2, '.', ',').'
    </pre>
</div>
</div>';





$data .= '
<table cellspacing="0" border="0">
<thead>
    <tr>
    <th>Transaction Date</th>
        <th>Description</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Balance</th>
    </tr>
</thead>
<tbody>';



// query to show statment of the account

$q = "SELECT * FROM fin_transactions WHERE account_No='$accid' ORDER BY transaction_Date ASC";
$result = $conn->query($q);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

       if($row['remark'] == 'Opening Balance:'){
        $blcamt += (float)$row['amount'];
        $data .= 
        '<tr>
            <td>'.dateconvert($row['transaction_Date']).'</td>
            <td>'.$row['remark'].'</td>
            <td>-</td>
            <td>-</td>
            <td>'.number_format($blcamt,2,'.',',').'</td>
        </tr>';
    
        }else{
           if($row['rec_Status'] == 'A'){
            if($row['drcr'] == 'c'){

                $blcamt += (float)$row['amount'];
                $data .= 
                '<tr>
                    <td>'.dateconvert($row['transaction_Date']).'</td>
                    <td>'.$row['remark'].'</td>
                    <td>-</td>
                    <td>'.number_format($row['amount'],2,'.',',').'</td>
                    <td>'.number_format($blcamt,2,'.',',').'</td>
                </tr>';

            }else if($row['drcr'] == 'd'){

                $blcamt -= (float)$row['amount'];
                $data .= 
                '<tr>
                    <td>'.dateconvert($row['transaction_Date']).'</td>
                    <td>'.$row['remark'].'</td>
                    <td>'.number_format($row['amount'],2,'.',',').'</td>
                    <td>-</td>
                    <td>'.number_format($blcamt,2,'.',',').'</td>
                </tr>';
            }
           }
       }
       if($row['rec_Status']=='A'){
           $counter++;
       }
    }
    $data .= 
    '<tr>
        <td></td>
        <td>Closing Balance:</td>
        <td></td>
        <td></td>
        <td>'.number_format(CLBALANCE,2,'.',',').'</td>
    </tr>';

}


}







$data .= '</tbody>
<tr class="lastrow">
    <td colspan="4">Total Records:</td>
    <td>'.$counter.'</td>
</tr>
<tr class="lastrow">
    <td colspan="4">Report generated on:</td>
    <td contenteditable="true">'.date('F d, Y').'</td>
</tr>
</table>';


$data .= '</div>';
echo $data;

// Function to create date as 30-04-2022 from  2022-04-30
function dateconvert($date){
    $opdate = explode('/', $date);
    $newopdate = $opdate[2].'-'.$opdate[1].'-'.$opdate[0];
    return $newopdate;
}
?>