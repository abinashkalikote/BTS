<?php require('../../controllers/unauthorized.controller.php');?>
<?php require('../../constants/conn.constant.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Transaction Software | Interest Calculation</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.css">
</head>

<body>
    <div class="container">
        <div class="top-header" style="text-align: left; padding-left: 6%;">
            Deposit
            <div class="quick-button">
                <a href="../withdraw/">Withdraw</a>
                <a href="../deposit/">Deposit</a>
                <a href="../statement/">View Statement</a>
            </div>
        </div>

        <div class="full-body">
            <div class="depositsection">
                <div class="depositform">
                    <h2 style="color: rgb(187, 187, 187);">Interest Calculation</h2><span
                        style="color:lightgray;">Provide Account No. to Calculate Interest.</span>

                    <div class="depoform">
                        <form action="../../controllers/calculateInterest.controller.php" method="post">
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
                                <label for="interestcheckbox">Give your Own Date?<span class="imp"></span></label>
                                <input type="checkbox" id="interestcheckbox">
                            </div>



                            <div class="form-control calculationupto">
                                <label for="calculationupto">Interest Calculation upto (YYYY/MM/DD)<span class="imp"> *</span></label>
                                <input type="text" name="calculationupto" id="calculationupto" placeholder="YYYY/MM/DD">
                            </div>

                            <div class="form-control">
                                <label for="interestrate">Interest Rate (%)<span class="imp"> *</span></label>
                                <input type="text" name="interestrate" id="interestrate" placeholder="Interest Rate %"
                                    required="required" value="0">
                            </div>

                            <div class="form-control">
                                <label for="taxrate">Tax Rate (%)<span class="imp"> *</span></label>
                                <input type="text" name="taxrate" id="taxrate" placeholder="Tax Rate %"
                                    required="required" value="0">
                            </div>



                            <div class="form-control">
                                <input type="submit" name="calculateinterest" id="processdepositbtn"
                                    value="Calculate Interest" disabled>
                            </div>
                    </div>
                    </form>

                    <div class="msg">
                        <?php
                        if(isset($_SESSION['interestcalculated'])){
                            echo "<span id='popupmsg' class='popupmsg' style='color:green; box-shadow:0 0 10px green;'>".$_SESSION['interestcalculated']."<span id='close'>X</span></span> ";
                            unset($_SESSION['interestcalculated']);
                        }else if(isset($_SESSION['interestnotcalculated'])){
                            echo "<span id='popupmsg' class='popupmsg' style='color:red; box-shadow:0 0 10px red;'>".$_SESSION['interestnotcalculated']."<span id='close'>X</span></span>  ";
                            unset($_SESSION['interestnotcalculated']);
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
    $("#calculationupto").nepaliDatePicker({
        dateFormat: "YYYY/MM/DD",
        ndpYear: true,
        ndpMonth: true,
        disableBefore: "2076/01/01",
        language: "english"
    });

    // function to show current date in while Calulate Interest
    let date = {year: `<?php echo date('Y');?>`, month: `<?php echo date('m');?>`, day: `<?php echo date('d');?>`}
    let newnepalidate = NepaliFunctions.AD2BS(date);
    let mnth = '';
    let dy = '';
    if(newnepalidate.month < 10){
        mnth = '0'+newnepalidate.month;
    }
    
    if(newnepalidate.day < 10){
        dy = '0'+newnepalidate.day;
    }
    
    $("#").val(`${newnepalidate.year}/${mnth}/${dy}`);
});


</script>

<script>
    // $(document).ready(()=>{
        
        $(".calculationupto").hide();
        $("#interestcheckbox").change(()=>{
            let check = $("#interestcheckbox").is(':checked');
            if(check == true){
                $(".calculationupto").slideToggle(300);
            }else{
                $(".calculationupto").slideToggle(300);
        }
        })
    // })
</script>

</html>