<?php
session_start();
if(isset($_SESSION['username'])){
    header('location: ./dashboard/');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transaction Software</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <div id="background" class="particles-js"></div>
    <div id="particles-js"></div>
    <div class="container">
        <div class="login-header">
            Login
        </div>

        <?php
         if(isset($_SESSION['mistakePassword'])){
            echo "<span style='color:red;'>Illegal Login Attemp !</span>";
            unset($_SESSION['mistakePassword']);
        }
        ?>


        <?php
            if(isset($_SESSION['pwchanged'])){
                echo "<span style='color:lightgreen;'>".$_SESSION['pwchanged']."</span>";
                unset($_SESSION['pwchanged']);
            }
        ?>

        <form action="./controllers/login.controller.php" method="post">
            <div class="form-control">
                <!-- <label for="username">Username</label> -->
                <input type="text" name="username" id="username" placeholder="Username" required="required" autofocus>
            </div>
            <div class="form-control">
                <!-- <label for="password">Password</label> -->
                <input type="password" name="password" id="password" placeholder="Password" required="required">
            </div>

            <div class="form-col-2">
                <input type="text" name="logindate" id="logindate" placeholder="Login Date" required="required">
                <button type="submit" name="login" class="login-btn btn-hover" id="login"><i
                        class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp; Log In</button>
            </div>

        </form>
        <div>
            <a href="./changepw.php">Forgot password ?</a>
        </div>

        
        <div class="login-footer">
            <div class="validUpto">
                <b>Expires on </b>
    
                <?php
    
                require('./constants/conn.constant.php');
    
                $result = $conn->query("SELECT * FROM license");
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    echo  $row['validUpto'];
                }
    
                ?>
    
            </div>
            Bank Transaction Software
        </div>
    </div>
</body>
<script src="./assets/js/particles.min.js"></script>
<script>
/* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
particlesJS.load('particles-js', './assets/js/particles.json', function() {
    console.log('callback - particles.js config loaded');
});
</script>
<script>
let logInBtn = document.getElementById('login');
document.getElementsByTagName('form').addEventListener('submit', () => {
    logInBtn.setAttribute('disabled', 'true');
    logInBtn.classList.remove('btn-hover');
});
</script>

<script src="./assets/plugins/nepalidatepicker/jquery.min.js"></script>
<script src="./assets/plugins/nepalidatepicker/nepali.datepicker.v3.7.min.js"></script>
<script>
$(document).ready(() => {
    // function to show current date in while deposit

    let newnepalidate = NepaliFunctions.GetCurrentBsDate()
    let mnth = '';
    let dy = '';
    if (newnepalidate.month < 10) {
        mnth = '0' + newnepalidate.month;
    } else {
        mnth = newnepalidate.month;
    }

    if (newnepalidate.day < 10) {
        dy = '0' + newnepalidate.day;
    } else {
        dy = newnepalidate.day;
    }

    $("#logindate").val(`${newnepalidate.year}/${mnth}/${dy}`);
    console.log(`${newnepalidate.year}/${mnth}/${dy}`);
});
</script>

</html>