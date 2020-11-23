<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php include("website_name.php"); ?></title>
    <link type="text/css" rel="stylesheet" href="website.css">
</head>
<body>
    <div class='main'>
        <div class="menu"><?php include('menu.php'); ?></div>
        <div class="left"><?php include('left.php'); ?></div>
        <div class="center">
            <?php
                if(!isset($_GET['id'])){
                    echo '<script>alert("沒有選擇分類")</script>';
                    echo '<script>document.location.href="index.php";</script>';
                }else{
                    if($_GET['id'] == '0'){
                        $row = array("id"=>"0");
                        echo '<h1>分類: 未分類</h1><br>';
                    }else{
                        $query="SELECT * FROM class WHERE id='".$_GET['id']."'";
                        $result=mysqli_query($database,$query);
                        $row=mysqli_fetch_array($result);
                        if(!$row['name']){
                            echo '<script>alert("分類已被刪除")</script>';
                            echo '<script>document.location.href="index.php";</script>';
                        }
                        echo '<h1>分類: '.$row['name'].'</h1><br>';
                    }
                }
                show_class($row['id']);
                function show_class($input){
                    global $database;
                    $query2="SELECT * FROM article where class='".$input."'";
                    $result2=mysqli_query($database,$query2);
                    while($row=mysqli_fetch_array($result2)){
                        echo '<div class="display_article"><h1><a href="showarticle.php?id='.$row['id'].'">'. $row['title'] .'</a></h1>';
                        $tmp_content = $row['content'];
                        if(strlen($tmp_content) > 60){
                            echo '<div class="article_content"><p>'.substr($tmp_content,0,60).' ...<br><br>'.'<a style="color:#ff4d4d;padding-left:10px" href="showarticle.php?id='.$row['id'].'">'. "閱讀全文" .'</a>'.'</p></div>';
                        }else{
                            echo '<div class="article_content"><p>'.$row['content'].'</p></div>';
                        }
                        echo '分類: ';
                        if($row['class'] != '0'){
                            $query="SELECT * FROM class WHERE id='".$row['class']."'";
                            $result=mysqli_query($database,$query);
                            $tmp=mysqli_fetch_array($result);
                            echo '<a href="showclass.php?id='. $row['class'] .'">'.$tmp['name'].'</a>';
                        }else{
                            echo '<a href="showclass.php?id=0">未分類</a>';
                        }
                        echo '<br><br>發表時間: '.$row['time'];
                        echo '</div>';
                    }
                    if($input != '0'){
                        $query3="SELECT * FROM class where father='".$input."'";
                        $result3=mysqli_query($database,$query3);
                        while($row=mysqli_fetch_array($result3)){
                            show_class($row['id']);
                        }
                    }
                }
                
            ?>
        </div>
    </div>
</body>
</html>