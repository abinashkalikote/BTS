<?php
session_start();
require('../constants/base_url.constant.php');
require('../constants/conn.constant.php');

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $logindate = $_POST['logindate'];
    
    $q = "SELECT * FROM user_accounts WHERE username = '".$username."'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $hashedPassword = $row['password'];
            $userrole = $row['user_role'];
            $user_ID = $row['user_ID'];
        }
        
        $result = $conn->query("SELECT * FROM license");
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $orgName = $row['orgName'];
            $validupto = $row['validUpto'];
        }
        if(password_verify($password, $hashedPassword) == TRUE){
            $_SESSION['username'] = $username;
            $_SESSION['user_ID'] = $user_ID;
            $_SESSION['logindate'] = $logindate;
            $_SESSION['user_role'] = $userrole;
            $_SESSION['orgName'] = $orgName;
            $_SESSION['validUpto'] = $validupto;
            
            if($logindate <= $validupto){
                header('location: ../dashboard/');
            }else{
                session_destroy();
                header('location: ../lic.php?licupdate=expired');
            }

        }else{
            $_SESSION['mistakePassword'] = 'Mistake Password';
            header('location: ../');
        }
    }else{
        $_SESSION['mistakePassword'] = 'Mistake Username';
        header('location: ../');
    }
}

?>