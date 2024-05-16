<?php require('../controllers/unauthorized.controller.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transaction Software | Dashbaord</title>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.css">
</head>
<style>
#watch, #date{
    width: 100%;
  font-family: 'Seven Segment' !important;
}

@media only screen and (max-width: 960px) {
    body{
        display: none !important;
    }
}

</style>
<body>
    <div class="container">
        <div class="top-header">
            Banking Transaction Software 7.1
        </div>
        <div class="bodySection">
            <div class="navbar">
                <h2>B.T.S.</h2>
                <div class="time" id="time">
                    <span id="watch">10:27 PM</span>
                    <span id="date"><?php echo $_SESSION['logindate']; ?></span>
                </div>
                <div class="linkGroup">
                    <a href="./view/" target="view" class="dashboard">Dashboard</a>
                    <a href="./member/" target="view"><i class="fa fa-user-plus"></i>Member</a>
                    <a href="./deposit/" target="view"><i class="fa fa-dollar"></i>Deposit</a>
                    <a href="./withdraw/" target="view"><i class="fa fa-credit-card"></i>Withdraw</a>
                    <a href="./statement/" target="view"><i class="fa fa-book"></i>Statement</a>
                    <a href="./interest/" target="view"><i class="fa-solid fa-money-bill"></i>Interest</a>
                    <a href="./certificate/" target="view"><i class="fa-solid fa-file-lines"></i>Certificate</a>
                    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == '1'){ ?>
                    <a href="./audit/" target="view"><i class="fa fa-pencil"></i>Audit</a>
                    <a href="./user/" class="create-user" target="view"><i class="fa fa-user-shield"></i>Create user</a>
                    <?php }?>
                    <a href="../controllers/logout.controller/" class="logout"><i class="fa fa-right-from-bracket"></i>Log Out</a>
                </div>
            </div>
            <div class="view">
                <iframe src="./view/" frameborder="0" name="view" id="iframe"></iframe>
            </div>
        </div>
    </div>
    <!-- <a href="../controllers/logout.controller.php">Log out</a> -->
</body>
<!-- <script src="../assets/js/time.js"></script> -->
<script>
    
function getTimeDate(){
    let time = document.getElementById('watch');
    
    let date = new Date();
        
    let hour = date.getHours();
    let ampm = hour > 11 ? 'PM' : 'AM';
    hour = hour >= 12 ? hour-12 : hour;
    hour = hour <= 9 ? `0${hour}`:hour;

    let minute = date.getMinutes();
    minute = minute <= 9 ? `0${minute}`:minute;

    let second = date.getSeconds();
    second = second <= 9 ? `0${second}`:second;


    time.innerHTML = `${hour}:${minute}:${second} ${ampm}`;
}

setInterval(getTimeDate, 1000);;

</script>
<script src="../assets/plugins/nepalidatepicker/jquery.min.js"></script>
</html>