<?php include('db_connect.php'); ?>
<?php
    if(!isset($_POST['submit'])){
        echo '<script>document.location.href="index.php";</script>';
    }else{
        $tmpstr = $_POST["content"];
        $tmpstr2 = $_POST["name"];
        if(chop($tmpstr) != "" && chop($tmpstr2) != ""){
            $query="INSERT INTO comment (name,father,content,is_article) VALUES ('".$_POST["name"]."','".$_POST["id"]."','".$_POST["content"]."','".$_POST['is_article']."')";
            mysqli_query($database,$query);
        }else{
            if(chop($tmpstr2) == ""){
                echo '<script>alert("請輸入暱稱")</script>';
            }
            if(chop($tmpstr) == ""){
                echo '<script>alert("請輸入內容")</script>';
            }
        }
        $tmp_type='article';
        if($_POST['is_article'] == '0')
            $tmp_type = 'page';
        echo '<script>document.location.href="show'.$tmp_type.'.php?id='.$_POST['id'].'";</script>';
    }
?>