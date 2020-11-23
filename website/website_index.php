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
                $query2="SELECT * FROM article";
                $result2=mysqli_query($database,$query2);
                while($row=mysqli_fetch_array($result2)){
                    echo '<div class="display_article"><h1><a href="showarticle.php?id='.$row['id'].'">'. $row['title'] .'</a></h1>';
                    $tmp_content = $row['content'];
                    if(strlen($tmp_content) > 60){
                        echo '<div class="article_content">'.substr(strip_tags($tmp_content),0,60).' ...<br><br>'.'<a style="color:#ff4d4d;padding-left:10px" href="showarticle.php?id='.$row['id'].'">'. "閱讀全文" .'</a>'.'</div>';
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
            ?>
        </div>
    </div>
</body>
</html>