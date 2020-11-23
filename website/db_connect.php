<?php
	include('db_setting.php');
?>
<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    }
    // Connect to the database.
    if(!($database=mysqli_connect("localhost",$username,$password))){
        echo "<script>alert(\"Can\'t connect to Database\");</script>";
        die();
    }
    if(!mysqli_select_db($database,$database_name)){
        echo '<script>alert("Can\'t connent to '.$database_name.'")</script>';
        die();
    }
?>