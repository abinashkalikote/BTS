<?php 
session_start();
require('../constants/conn.constant.php');

if(isset($_POST['changepw']) && isset($_POST['username']) && isset($_POST['newpassword']) && isset($_POST['repassword'])){

    $username =  $conn->real_escape_string($_POST['username']);
    $newpassword =  $conn->real_escape_string($_POST['newpassword']);
    $repassword =  $conn->real_escape_string($_POST['repassword']);
    
    $result = $conn->query("SELECT * FROM user_accounts WHERE username LIKE '$username'");
    if($result->num_rows > 0){
        // if username found
        $row = $result->fetch_assoc();
        $userID = $row['user_ID'];
        
        // check whether the password are same or not
        if($newpassword == $repassword){
            // if password matched
            $finalpassword = password_hash($newpassword, PASSWORD_DEFAULT);
            $result = $conn->query("UPDATE user_accounts SET password='$finalpassword' WHERE user_ID='$userID'");
            if($result){
                // if password changed successfully
                $_SESSION['pwchanged'] = "Password Changed Successfully !";
                header('location: ../');
            }else{
                // if password not matched
                $_SESSION['pwnotchanged'] = "Something Went Wrong !";
                header('location: ../changepw.php');
            }
        }else{
            // if password not matched
        $_SESSION['pwnotchanged'] = "Password not matched !";
        header('location: ../changepw.php');
        }
    }else{
        // If username not found
        $_SESSION['pwnotchanged'] = "Username not found !";
        header('location: ../changepw.php');
    }
}else{
    header('location: ../');
}

$conn->close();
?>