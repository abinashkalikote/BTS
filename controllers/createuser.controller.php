<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['user-role']) == '1'){
    header('location: ./dashboard/');
}

require('../constants/conn.constant.php');

if(isset($_POST['create-user']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['user-role'])){

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $repassword = $conn->real_escape_string($_POST['repassword']);
    $userrole = $conn->real_escape_string($_POST['user-role']);


    $result = $conn->query("SELECT * FROM user_accounts WHERE username LIKE '$username'");
    if($result->num_rows < 1){
        if($password != '' || $repassword != ''){
            if($password == $repassword){
                $hashpw = password_hash($password, PASSWORD_BCRYPT);
                $result = $conn->query("INSERT INTO user_accounts(username, password, user_role) VALUES ('$username', '$hashpw', '$userrole')");
                if($result){
                    // if Username created
                    $_SESSION['usercreated'] = 'Username Created Successfully !';
                    header('location: ../dashboard/user/');
                }else{
                    // if something went wrong
                    $_SESSION['usernotcreated'] = 'Something went wrong !';
                    header('location: ../dashboard/user/');
                }
            }else{
                // if password doesn't matched
                $_SESSION['usernotcreated'] = 'Passwords doesn\'t matched !';
                header('location: ../dashboard/user/');
            }
        }else{
            // if password field's are blank
            $_SESSION['usernotcreated'] = 'Passwords can\'t be blank !';
            header('location: ../dashboard/user/');
        }
    }else{
        // username already created with this username
        $_SESSION['usernotcreated'] = 'User already created with this username !';
        header('location: ../dashboard/user/');
    }


}

?>