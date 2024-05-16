<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transaction Software</title>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <div id="background" class="particles-js"></div>
    <div id="particles-js"></div>
    <div class="container">
        <div class="login-header">
            Change Password
        </div>
        
        <?php
         if(isset($_SESSION['pwnotchanged'])){
            echo "<span style='color:red;'>".$_SESSION['pwnotchanged']."</span>";
            unset($_SESSION['pwnotchanged']);
        }
        ?>

        <form action="./controllers/changepw.controller.php" method="post" autocomplete="off">
            <div class="form-control">
                <!-- <label for="username">Username</label> -->
                <input type="text" name="username" id="username" placeholder="Username" required="required" autofocus>
            </div>
            <div class="form-control">
                <!-- <label for="password">Password</label> -->
                <input type="password" name="newpassword" id="password" placeholder="New Password" required="required">
            </div>

            <div class="form-control">
                <!-- <label for="password">Password</label> -->
                <input type="password" name="repassword" id="password" placeholder="Repeat Password" required="required">
            </div>

            <button type="submit" name="changepw" class="changepw-btn btn-hover" id="login"><i class="fa fa-pencil"></i>&nbsp;&nbsp; Change Password</button>

        </form>
        <div>
            <a href="./">Have password, Log in ?</a>
        </div>
        <div class="login-footer">
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
    document.getElementsByTagName('form').addEventListener('submit', ()=>{
        logInBtn.setAttribute('disabled','true');
        logInBtn.classList.remove('btn-hover');
    });
</script>
</html>
