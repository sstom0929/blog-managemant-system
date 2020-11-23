<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php include("website_name.php"); ?></title>
    <link type="text/css" rel="stylesheet" href="website.css">
    <?php include('db_connect.php'); ?>
</head>
<body>
    <div class='main'>
        <div class="menu"><?php include('menu.php'); ?></div>
        <div class="left"><?php include('left.php'); ?></div>
        <div class="center">
            <?php
                if(!isset($_GET['id'])){
                    echo '<script>alert("沒有選擇頁面")</script>';
                    echo '<script>document.location.href="index.php";</script>';
                }else{
                    $query="SELECT * FROM page WHERE id='".$_GET['id']."'";
                    $result=mysqli_query($database,$query);
                    $row=mysqli_fetch_array($result);
                    if(!$row['content']){
                        echo '<script>alert("頁面已被刪除")</script>';
                        echo '<script>document.location.href="index.php";</script>';
                    }
                }
                echo '<div class="display_article"><h1><a>'. $row['title'] .'</a></h1>';
                echo '<div class="article_content"><p>'.$row['content'].'</p></div>';
                echo '發表時間: '.$row['time'];
                echo '</div>';
                echo '<h2>所有留言:</h2><br>';
                $comment_query="SELECT * FROM comment WHERE father='".$row['id']."' AND is_article='0'";
                $comment_result=mysqli_query($database,$comment_query);
                while($comment_row=mysqli_fetch_array($comment_result)){
                    echo '<div class="display_comment">';
                    echo '<p>留言者: '.$comment_row['name'].'</p>';
                    echo '<p>留言內容: </p>';
                    echo '<div class="comment_content">'.$comment_row['content'].'</div>';
                    echo '<p>留言時間: '.$comment_row['time'].'</p>';
                    echo '</div>';
                }
            ?>
            <form action="new_comment.php" method="POST" style="padding-bottom:60px">
                <h2>發表留言:</h2>
                暱稱:<br><input type="text" name="name" style="width:70%"><br><br>
                內容:<br>
                <textarea id="comment" rows="10" cols="50"></textarea><br><br>
                <input type="submit" name="submit" value="送出" onclick="save_content()">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input id="comment_content" type="hidden" name="content" value="">
                <input type="hidden" name="is_article" value="0">
            </form>
            <script>
                function save_content(){
                    $("#comment_content").val($("#comment").val());
                }
            </script>
        </div>
    </div>
</body>
</html>