<?php

    define('HOST','localhost');
    define('USERNAME','root');
    define('PASSWORD','');
    define('DB','bank');

    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    if($conn->connect_error){
        echo "Something Error !";
    }
?>