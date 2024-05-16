<?php
session_start();
if(!isset($_SESSION['username']) && !isset($_SESSION['user_role']) || $_SESSION['user_role']!= '1'){
    header('location: ../../');
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
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
    <div id="background" class="particles-js"></div>
    <div class="container">
        <div class="login-header">
            Create User
        </div>
        
        <?php
         if(isset($_SESSION['usernotcreated'])){
            echo "<span style='color:red;'>".$_SESSION['usernotcreated']."</span>";
            unset($_SESSION['usernotcreated']);
        }
        ?>

        
        <?php
            if(isset($_SESSION['usercreated'])){
                echo "<span style='color:green;'>".$_SESSION['usercreated']."</span>";
                unset($_SESSION['usercreated']);
            }
        ?>

        <form action="../../controllers/createuser.controller.php" method="post">
            <div class="form-control">
                <!-- <label for="username">Username</label> -->
                <input type="text" name="username" id="username" placeholder="Username" required="required" minlength="3" maxlength="20" autofocus>
            </div>

            <div class="form-control">
                <!-- <label for="password">Password</label> -->
                <input type="password" name="password" id="password" placeholder="Password" minlength="1" maxlength="9" required="required">
            </div>

            <div class="form-control">
                <!-- <label for="repassword">repassword</label> -->
                <input type="password" name="repassword" id="repassword" placeholder="Repeat Password" minlength="1" maxlength="9"  required="required">
            </div>

            <div class="select">
                <select class="user-role" name="user-role" id="user-role" required="required" style="width: 340px; padding: 10px; border-radius: 10px;">
                    <option value="1">Admin</option>
                    <option value="2">user</option>
                </select>
            </div>

            <div class="form-control">
                <button type="submit" name="create-user" class="login-btn btn-hover" id="create-user"><i class="fa-solid fa-user-secret"></i>&nbsp;&nbsp; Create User</button>
            </div>

        </form>
    </div>
</body>
<script>
    let logInBtn = document.getElementById('create-user');
    document.getElementsByTagName('form').addEventListener('submit', ()=>{
        logInBtn.setAttribute('disabled','true');
        logInBtn.classList.remove('btn-hover');
    });
</script>

<script src="./assets/plugins/nepalidatepicker/jquery.min.js"></script>
</html>
