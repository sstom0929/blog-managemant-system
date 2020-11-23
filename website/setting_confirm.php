<?php
    if(isset($_POST['submit'])){
        if(!($database=mysqli_connect("localhost",$_POST['db_account'],$_POST['db_password']))){
            echo "<script>alert(\"Can\'t connect to Database\");</script>";
            echo '<script>document.location.href="setting.php";</script>';
        }else
        if(mysqli_select_db($database,$_POST['db_name'])){
            echo '<script>alert("此資料庫已存在")</script>';
            echo '<script>document.location.href="setting.php";</script>';
        }else
            if(!mysqli_query($database,"CREATE DATABASE ".$_POST['db_name'])){
                echo '<script>alert("Can\'t create or connent to '.$_POST['db_name'].'")</script>';
                echo '<script>document.location.href="setting.php";</script>';
            
        }else
        if(chop($_POST['website_name']) == ""){
            mysqli_query($database,"DROP DATABASE ".$_POST['db_name']);
            echo "<script>alert(\"網站名稱不可為空白\");</script>";
            echo '<script>document.location.href="setting.php";</script>';
        }else
        if(chop($_POST['account']) == ""){
            mysqli_query($database,"DROP DATABASE ".$_POST['db_name']);
            echo "<script>alert(\"帳號不可為空白\");</script>";
            echo '<script>document.location.href="setting.php";</script>';
        }else
        if(chop($_POST['password']) == ""){
            mysqli_query($database,"DROP DATABASE ".$_POST['db_name']);
            echo "<script>alert(\"密碼不可為空白\");</script>";
            echo '<script>document.location.href="setting.php";</script>';
        }else
        if($_POST['password'] != $_POST['confirm_password']){
            mysqli_query($database,"DROP DATABASE ".$_POST['db_name']);
            echo "<script>alert(\"兩次密碼不相同\");</script>";
            echo '<script>document.location.href="setting.php";</script>';
        }else{
        $file = fopen("db_setting.php", "w");
        $txt = '<?php
                $username="'.$_POST['db_account'].'";
                $password="'.$_POST['db_password'].'";
                $database_name="'.$_POST['db_name'].'";
                ?>';
        fwrite($file, $txt);
        fclose($file);
        $file = fopen("website_name.php", "w");
        $txt = '<?php
                echo "'.$_POST['website_name'].'";
                ?>';
        fwrite($file, $txt);
        fclose($file);
        $file = fopen("index.php", "w");
        $txt = '<?php header("location: website_index.php")?>';
        fwrite($file, $txt);
        fclose($file);
        mysqli_select_db($database,$_POST['db_name']);
        $sql = "CREATE TABLE IF NOT EXISTS menu 
            (
            id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            name varchar(30),
            father int,
            url tinytext
            )";
        mysqli_query($database,$sql);
        $sql = "CREATE TABLE IF NOT EXISTS class 
                (
                id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                name varchar(30),
                father int
                )";
        mysqli_query($database,$sql);
        $sql = "CREATE TABLE IF NOT EXISTS article 
                (
                id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                title tinytext,
                class int,
                content text,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
        mysqli_query($database,$sql);
        $sql = "CREATE TABLE IF NOT EXISTS page 
                (
                id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                title tinytext,
                content text,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
        mysqli_query($database,$sql);
        $sql = "CREATE TABLE IF NOT EXISTS comment 
                (
                id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                name tinytext,
                content text,
                is_article int,
                father int,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
        mysqli_query($database,$sql);
        $sql = "CREATE TABLE IF NOT EXISTS account 
                (
                account varchar(50) PRIMARY KEY NOT NULL,
                password varchar(50) NOT NULL
                )";
        mysqli_query($database,$sql);
        $query="INSERT INTO account (account, password) VALUES ('".$_POST["account"]."','".$_POST["password"]."')";
        mysqli_query($database,$query);
        echo '<script>alert("網站設定完成")</script>';
        echo '<script>document.location.href="index.php";</script>';
        }
    }
?>