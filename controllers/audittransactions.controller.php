<?php
require('./unauthorized.controller.php');
require('../constants/conn.constant.php');



if(isset($_SERVER['REQUEST_METHOD'])=='GET' && isset($_GET['accid']) && isset($_GET['audittxn'])==1){
    $accid = $_GET['accid'];
    $dr = 0;
    $cr = 0;
    $blcamt = 0;
    $counter = 0;
    $data = '';


// query to show Opening Date,  opening balance and closing balance

$q = "SELECT * FROM fin_transactions WHERE account_No='$accid' ORDER BY transaction_Date ASC";
$result = $conn->query($q);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

        if($row['remark'] == 'Opening Balance:'){
            define('OPDATE', $row['transaction_Date']);
            define('OPBALANCE', $row['amount']);

        }else{             
            if($row['rec_Status'] == 'A'){
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






$data .= '
<table cellspacing="0" border="1">
<thead>
    <tr>
    <th>Transaction Date</th>
        <th>Description</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Balance</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>';



// query to show statment of the account

$q = "SELECT * FROM fin_transactions WHERE account_No='$accid' ORDER BY transaction_Date ASC";
$result = $conn->query($q);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

        if($row['rec_Status']=='A'){
            if($row['remark'] == 'Opening Balance:'){
                $blcamt += (float)$row['amount'];
                $data .= 
                '<tr>
                    <td>'.$row['transaction_Date'].'</td>
                    <td>'.$row['remark'].'</td>
                    <td>-</td>
                    <td>-</td>
                    <td>'.number_format($blcamt,2,'.',',').'</td>
                    <td></td>
                </tr>';
            
                }else{
                    if($row['drcr'] == 'c'){
        
                        $blcamt += (float)$row['amount'];
                        $data .= 
                        '<tr>
                            <td>'.$row['transaction_Date'].'</td>
                            <td>'.$row['remark'].'</td>
                            <td>-</td>
                            <td>'.number_format($row['amount'],2,'.',',').'</td>
                            <td>'.number_format($blcamt,2,'.',',').'</td>
                            <td><a href="#" onclick="confirmReverse('.$row['transaction_ID'].', \''.$row['transaction_Date'].'\', '.$accid.')">Reverse</a></td>
                        </tr>';
        
                    }else if($row['drcr'] == 'd'){
        
                        $blcamt -= (float)$row['amount'];
                        $data .= 
                        '<tr>
                            <td>'.$row['transaction_Date'].'</td>
                            <td>'.$row['remark'].'</td>
                            <td>'.number_format($row['amount'],2,'.',',').'</td>
                            <td>-</td>
                            <td>'.number_format($blcamt,2,'.',',').'</td>
                            <td><a href="#" onclick="confirmReverse('.$row['transaction_ID'].', \''.$row['transaction_Date'].'\', '.$accid.')">Reverse</a></td>
                        </tr>';
                    }
               }
        }
       $counter++;
    }
    $data .= 
    '<tr style="color: black !important; font-weight: bolder;">
        <td colspan="2">Closing Balance:</td>
        <td>'.number_format($dr, 2, '.', ',').'</td>
        <td>'.number_format($cr+OPBALANCE, 2, '.', ',').'</td>
        <td>'.number_format(CLBALANCE,2,'.',',').'</td>
    </tr>';

}


}







$data .= '</tbody></table>';


$data .= '</div>';
echo $data;

// Function to create date as 30-04-2022 from  2022-04-30
function dateconvert($date){
    $opdate = explode('/', $date);
    $newopdate = $opdate[2].'-'.$opdate[1].'-'.$opdate[0];
    return $newopdate;
}

?>