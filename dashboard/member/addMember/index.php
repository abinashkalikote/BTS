<?php require('../../../controllers/unauthorized.controller.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banking Transaction Software | Add Member</title>
    <link rel="stylesheet" href="../../../assets/css/style.css" />
    <link rel="stylesheet" href="../../../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.css">
</head>
<style>
    .table{
        width: auto;
        text-align: left;
    }
    .table tr td{
        width: 460px;
    }

    .reset:hover{
        background-color: rgb(224, 14, 14) !important;
        cursor: pointer !important;
    }
</style>
<body>
    <div class="container">
        <div class="top-header" style="text-align: left; padding-left: 6%">
            Add Member
            <div class="quick-button">
                <a href="../">View Members</a>
                <a href="">Add Member</a>
                <a href="../../statement/">View Statement</a>
            </div>
        </div>

        <div class="full-body">
            <div class="msg">
                <?php
                if(isset($_SESSION['memberadded'])){
                    echo "<span id='popupmsg' class='popupmsg' style='background-color: lightgreen;color:green; box-shadow:0 0 10px green;'>".$_SESSION['memberadded']."<span id='close'>X</span></span> ";
                    unset($_SESSION['memberadded']);
                }else if(isset($_SESSION['membernotadded'])){
                    echo "<span id='popupmsg' class='popupmsg' style='color:red; box-shadow:0 0 10px red;'>".$_SESSION['membernotadded']."<span id='close'>X</span></span>  ";
                    unset($_SESSION['membernotadded']);
                }
            ?>
            </div>
            <div class="addmemberform">
                <form action="../../../controllers/addmember.controller.php" method="post">


                    <table class="table">
                        <tr>
                            <td>
                                <div class="form-control">
                                    <input type="text" name="fullname" id="name" placeholder="Name" required="require" />
                                </div>
                            </td>
                            <td>
                                <div class="form-control">
                                    <input type="text" name="dob" minlength="10" required="requied" id="dob"
                                        placeholder="Account Open Date: YYYY/MM/DD" /> <!-- class="date-picker" -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-control">
                                    <input type="text" name="paddress" id="paddress" placeholder="Permanant Address"
                                        required="required" />
                                </div>
                            </td>
                            <td>
                                <div class="form-control">
                                    <input type="text" name="taddress" id="taddress" placeholder="Temporary Address" />
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="form-control">
                                    <input type="tel" name="mobileno" id="mobielno" placeholder="+977-98********" value="+977-98"
                                        required="required" />
                                </div>
                            </td>
                            <td>
                                <div class="form-control">
                                    <input type="text" name="openingblc" id="openingblc" placeholder="Opening Amount"
                                        required="required" />
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="form-control">
                                    <input type="reset" value="Reset" name="reset" id="addmember" class="reset" style="background-color: red;"/>
                                </div>
                                <div class="form-control">
                                    <input type="submit" value="Add Member" name="addmember" id="addmember" class="addmember" />
                                </div>
                            </td>
                        </tr>
                    </table>








                </form>
            </div>
        </div>
    </div>
</body>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="../../../assets/plugins/nepalidatepicker/nepali-date-picker.js"></script> -->

<script>
let clsbtn = document.getElementById('close');
let popupmsg = document.getElementById('popupmsg');

clsbtn.addEventListener('click', () => {
    popupmsg.classList.add('hide');
});

// jQuery(document).ready(function () {
//   $(".date-picker").nepaliDatePicker();
// });
</script>


<script src="../../../assets/plugins/nepalidatepicker/jquery.min.js"></script>
<script src="../../../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.js"></script>
<script>
$(document).ready(() => {
    $("#dob").nepaliDatePicker({
        dateFormat: "YYYY/MM/DD",
        ndpYear: true,
        ndpMonth: true,
        disableBefore: "2076/01/01",
        language: "english"
    });

    // Recently not used
//     let date = {year: `<?php echo date('Y');?>`, month: `<?php echo date('m');?>`, day: `<?php echo date('d');?>`}
//    let newnepalidate = NepaliFunctions.AD2BS(date);
//    let mnth = '';
//    let dy = '';
//    if(newnepalidate.month < 10){
//     mnth = '0'+newnepalidate.month;
//    }
   
//    if(newnepalidate.day < 10){
//     dy = '0'+newnepalidate.day;
//    }

//     $("#dob").val(`${newnepalidate.year}/${mnth}/${dy}`);
});
</script>

</html>