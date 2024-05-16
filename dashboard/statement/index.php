<?php require('../../controllers/unauthorized.controller.php');?>
<?php require('../../constants/conn.constant.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Transaction Software | Statement</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<style id="table_style" type="text/css">
@page{
    margin: 0.25in 0.25in 0.25in 0.3in;
}

body {
    font-family: Arial;
    font-size: 9pt;
}

table {
    width: 100%;
    /* border: 1px solid #ccc; */
    border-collapse: collapse;
}

table th {
    background-color: #F7F7F7;
    color: #333;
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
    font-weight: bold;
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
    text-align: right;
    padding: 3px 6rem 3px 0;
}

.lastrow{
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
}

.lastrow td{
    padding: 10px;
}

td {
    width: 20%;
}
</style>

<body>
    <div class="container">
        <div class="top-header" style="text-align: left; padding-left: 6%;">
            Statement
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
                <input type="button" value="Print" onclick="PrintTable()" style="--btn-color: blue;" id="printbtn">
            <div class="statement" id="statement">

            </div>
        </div>
    </div>
    </div>
</body>
<script src="../../assets/plugins/nepalidatepicker/jquery.min.js"></script>
<script>



$("#printbtn").hide();
$('#accountno').change(()=>{
    let accountno = $('#accountno').val();
    if(accountno == '--Select Account No:--'){
        $("#printbtn").hide();
    }
})


$('#statementshow').click(() => {
    let accountno = $('#accountno').val();

    if(accountno == '--Select Account No:--'){
        $('#statement').html('');
        $("#printbtn").hide();
    }else{
        $("#printbtn").show();
        $.ajax({
        url: `../../controllers/statement.controller.php?accid=${accountno}`,
        method: 'GET',
        success: function(result) {
            $('#statement').html(result);
        },
        beforeSend: function(){
            $('#statement').html("Loading...");
        }
    });
    }  
});
</script>



<!-- Function to print a statement -->
<script type="text/javascript">
function PrintTable() {
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Account Statement</title>');

    //Print the Table CSS.
    var table_style = document.getElementById("table_style").innerHTML;
    printWindow.document.write('<style type = "text/css">');
    printWindow.document.write(table_style);
    printWindow.document.write('</style>');
    printWindow.document.write('</head>');

    //Print the DIV contents i.e. the HTML Table.
    printWindow.document.write('<body>');
    var divContents = document.getElementById("statement").innerHTML;
    printWindow.document.write(divContents);
    printWindow.document.write('</body>');

    printWindow.document.write('</html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

</html>