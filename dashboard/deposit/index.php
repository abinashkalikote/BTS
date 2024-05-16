<?php require('../../controllers/unauthorized.controller.php');?>
<?php require('../../constants/conn.constant.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Transaction Software | Deposit</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.css">
</head>

<body>
    <div class="container">
        <div class="top-header" style="text-align: left; padding-left: 6%;">
            Deposit
            <div class="quick-button">
                <a href="../withdraw/">Withdraw</a>
                <a href="../statement/">View Statement</a>
            </div>
        </div>

        <div class="full-body">
            <div class="depositsection">
                <div class="depositform">
                    <h2 style="color: rgb(187, 187, 187);">Cash Deposit</h2><span style="color:lightgray;">Provide
                        Account No. to Deposit Cash.</span>

                    <div class="depoform">
                        <form action="../../controllers/depositwithdrawamount.php" method="post">
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

                            <div class="form-control">
                                <label for="amount">Amount<span class="imp">*</span></label>
                                <input type="text" name="amount" id="amount" required="required" placeholder="0.00">
                            </div>

                            <div class="form-control">
                                <label for="transactiondate">Date(YYYY-MM-DD)<span class="imp">*</span></label>
                                <input type="text" name="transactiondate" minlength="10" maxlength="10" id="transactiondate"
                                    placeholder="YYYY/MM/DD" required="required" value="<?php echo $_SESSION['logindate']; ?>">
                            </div>

                            <div class="form-control">
                                <label for="remark">Remark<span class="imp"></span></label>
                                <input type="text" name="remark" id="remark">
                            </div>

                            <div class="form-control">
                                <input type="submit" name="processdeposit" id="processdepositbtn"
                                    value="Process Deposit" disabled>
                            </div>
                    </div>
                    </form>

                    <div class="msg">
                        <?php
                if(isset($_SESSION['amountdeposited'])){
                    echo "<span id='popupmsg' class='popupmsg' style='color:green; box-shadow:0 0 10px green;'>".$_SESSION['amountdeposited']."<span id='close'>X</span></span> ";
                    unset($_SESSION['amountdeposited']);
                }else if(isset($_SESSION['amountnotdeposited'])){
                    echo "<span id='popupmsg' class='popupmsg' style='color:red; box-shadow:0 0 10px red;'>".$_SESSION['amountnotdeposited']."<span id='close'>X</span></span>  ";
                    unset($_SESSION['amountnotdeposited']);
                }
            ?>
                    </div>
                </div>

                <div class="userstatus" id="userstatus">

                </div>
            </div>
        </div>
    </div>
</body>
<script src="../../assets/plugins/nepalidatepicker/jquery.min.js"></script>
<script>

    $("#close").click(()=>{
        $("#popupmsg").addClass('hide');
    });


$('#accountno').change(() => {
    let accountno = $('#accountno').val();
    if(accountno == '--Select Account No:--'){
        $("#processdepositbtn").attr('disabled', 'true');
    }else{
        $("#processdepositbtn").removeAttr('disabled');
    }
    $.ajax({
        url: `../../controllers/accountbalanceamt.controller.php?accid=${accountno}`,
        method: 'GET',
        success: function(result) {
            $('#userstatus').html(result);
        }
    });
});
</script>

<script src="../../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.js"></script>
<script>
$(document).ready(() => {
    $("#transactiondate").nepaliDatePicker({
        dateFormat: "YYYY/MM/DD",
        ndpYear: true,
        ndpMonth: true,
        disableBefore: "2076/01/01",
        language: "english"
    });

    
    // function to show current date in while deposit
    
   let newnepalidate = NepaliFunctions.GetCurrentBsDate()
   let mnth = '';
   let dy = '';
   if(newnepalidate.month < 10){
    mnth = '0'+newnepalidate.month;
   }else{
    mnth = newnepalidate.month;
   }
   
   if(newnepalidate.day < 10){
    dy = '0'+newnepalidate.day;
   }else{
    dy = newnepalidate.day;
   }

    // $("#transactiondate").val(`${newnepalidate.year}/${mnth}/${dy}`);
});
</script>

</html>