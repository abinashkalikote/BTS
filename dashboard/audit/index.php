<?php require('../../controllers/unauthorized.controller.php');?>
<?php
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != '1'){
    header('location: ../');
}
?>
<?php require('../../constants/conn.constant.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Transaction Software | Audit Transaction</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<style id="table_style" type="text/css">
body {
    font-family: Arial;
    font-size: 10pt;
}

table {
    width: 100%;
    /* border: 1px solid #ccc; */
    border-collapse: collapse;
}

table th {
    background-color: #F7F7F7;
    color: #333;
    font-weight: bold;
}

table thead{
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
    padding: 10px;
}

tbody td{
    padding: 1rem;
}

table th,
table td {
    text-align: left;
    /* border: 1px solid #ccc; */
}

.statement {
    padding: 10px;
}

.userinfo {
    display: flex;
    justify-content: space-between;
}

.userdetail {
    /* margin-left: -5rem; */
}

.counter{
    margin-top: 10px;
    width: 100%;
    font-weight: bolder;
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
    text-align: right;
    padding: 3px 6rem 3px 0;
}

tfoot>tr{
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
}

tfoot tr td{
    padding: 10px;
}

td {
    width: 20%;
}
</style>

<body>
    <div class="container">
        <div class="top-header" style="text-align: left; padding-left: 6%;">
            Audit Transaction
            <div class="quick-button">
                <a href="../member/addMember/">Add Member</a>
                <a href="../deposit/">Deposit</a>
                <a href="../withdraw/">Withdraw</a>
            </div>
        </div>
        <div class="full-body printstatement">
            <div class="form-control">
                <label for="accountno">Account No: <span class="imp">*</span></label>
                <select name="accountno" id="accountno" required="required">
                    <option>--Select Account No:--</option>
                    <?php
                        $q = "SELECT * FROM fin_accounts ORDER BY account_No";
                        $result = $conn->query($q);
                        if($result->num_rows > 0){ while($row = $result->fetch_assoc()){ ?>

                    <option value="<?php echo $row['account_No'] ?>">
                        <?php echo $row['name'].' [BTS2022'.$row['account_No'].']';?></td>

                        <?php
                                }
                            }
                        
                        ?>
                </select>
            </div>

            <input type="button" value="Search" id="statementshow" style="--btn-color:green;">
            <div class="statement" id="statement">

            </div>
        </div>
    </div>
    </div>
</body>
<script src="../../assets/plugins/nepalidatepicker/jquery.min.js"></script>
<script src="../../assets/plugins/sweetalert/sweetalert.min.js"></script>
<script>
$('#statementshow').click(() => {
    showtxn();    
});


let showtxn =  () => {
        let accountno = $('#accountno').val();

        if(accountno == '--Select Account No:--'){
            $('#statement').html('');
        }else{
            $.ajax({
                url: `../../controllers/audittransactions.controller.php?accid=${accountno}&audittxn=1`,
                method: 'GET',
                success: function(result) {
                    $('#statement').html(result);
                },
                beforeSend: function(){
                    $('#statement').html("Loading...");
                }
            });
        }  
    }


let confirmReverse = (txnid, txndate, accid) =>{
    swal(`Are you sure, Want to reverse?`, {
    buttons: {
        cancel: "No",
        catch: {
            text: "Yes",
            value: "catch",
        }
    },
    icon:"warning",
    dangerMode: true
    })
    .then((value) => {
    switch (value) {
    
        case "catch":
        reversetxn(txnid, txndate, accid);
        break;
    
        default:
            return;
    }
    });
}


// function to reverse a transaction
let reversetxn = (txnid, txndate, accid) => {
        $.ajax({
        url: `../../controllers/deletetxn.controller.php`,
        data: {txnid:txnid, txndate:txndate, accid:accid},
        method: 'POST',
        success: function(result) {
            showtxn();
            swal(`${result}`, "", "success");
            // alert(result);
        },
        beforeSend: function(){
            swal('Reversing...');
        }
    });
    }
</script>

</html>
<?php
$conn->close();
?>