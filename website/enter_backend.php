<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    } 
    if(!isset($_SESSION['login']) || $_SESSION['login'] != "1"){
        echo '<script>alert("尚未登入")</script>';
        echo '<script>document.location.href="login.php";</script>';
    }
?>