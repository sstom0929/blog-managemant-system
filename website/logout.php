<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    }
    if(isset($_SESSION['login'])){
        unset($_SESSION['login']);
        echo '<script>alert("已登出")</script>';
    }
    echo '<script>document.location.href="index.php";</script>';
?>