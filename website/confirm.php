<?php include('db_connect.php'); ?>
<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    } 
    if(!isset($_POST['login'])){
        echo '<script>document.location.href="login.php";</script>';
    }else{
        $query_tmp="SELECT * FROM account WHERE account='".$_POST['account']."'";
        $result_tmp=mysqli_query($database,$query_tmp);
        $row_tmp=mysqli_fetch_array($result_tmp);
        if(!$row_tmp['account']){
            echo '<script>alert("帳號或密碼錯誤")</script>';
            echo '<script>document.location.href="login.php";</script>';
        }else{
            if($row_tmp['password'] != $_POST['password']){
                echo '<script>alert("帳號或密碼錯誤")</script>';
                echo '<script>document.location.href="login.php";</script>';
            }else{
                $_SESSION['login'] = "1";
                echo '<script>document.location.href="article.php";</script>';
            }
        }
    }
?>