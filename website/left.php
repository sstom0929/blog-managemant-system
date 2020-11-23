<?php include('db_connect.php'); ?>
<?php
    echo '<div class="left_link">';
    echo '<div class="left_class">';
    echo '<p>所有分類</p>';
    echo '<div class="display_link"><a href="showclass.php?id=0">未分類</a></div>';
    $query="SELECT * FROM class WHERE father = 'NULL'";
    $result=mysqli_query($database,$query);
    while($row=mysqli_fetch_array($result)){
        display_option($row,0);
    }
    function display_option($nowrow,$nowpre){
        global $pre, $database;
        print('<div class="display_link"><a href="showclass.php?id='.$nowrow['id'].'">');
        for($i=1;$i<=$nowpre;$i++){
	       print("-");
	    }
        print($nowrow['name']."</a></div>");
        $query="SELECT * FROM class WHERE father = '".$nowrow['id']."'";
        $result=mysqli_query($database,$query);
        while($row=mysqli_fetch_array($result)){
            display_option($row,$nowpre+1);
        }
    }
    echo "</div>";
    echo "<div class='left_article'>";
    echo '<p>所有文章</p>';
    $query="SELECT * FROM article";
    $result=mysqli_query($database,$query);
    while($row=mysqli_fetch_array($result)){
        print('<div class="display_link"><a href="showarticle.php?id='.$row['id'].'">'.$row['title']."</a></div>");
    }
    echo "</div>";
    echo "<div class='left_page'>";
    echo '<p>所有頁面</p>';
    $query="SELECT * FROM page";
    $result=mysqli_query($database,$query);
    while($row=mysqli_fetch_array($result)){
        print('<div class="display_link"><a href="showpage.php?id='.$row['id'].'">'.$row['title']."</a></div>");
    }
    echo "</div></div>";
?>