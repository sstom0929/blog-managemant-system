<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>showarticle</title>
    <?php include('db_connect.php'); ?>
    <style type="text/css">
        div.entry {
            float: left;
            min-width: 100px;
            max-width: 160px;
            word-break: break-all;
            z-index: 1000;
        }
        div.right_menu {
            float: right;
            width: 80px;
        }
        div.right_menu a {
            text-align: center;
            display: block;
            height: 100%;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        div.right_menu a:hover {
            color: white;
            background-color: grey;
        } 
        .entry_span {
            visibility: hidden;
            position: absolute;
            top: -10em;
        }
        span {
            z-index: 9999;
        }
        span div{
            background-color: #e6e6e6 !important; 
            border: 1px solid #d9d9d9;
        }
        div.menu_block {
            background-color: #f2f2f2;
            text-align: center;
        }
        div.menu_block:hover {
            color: white;
            background-color: grey !important;
        }
        [href] {
            text-decoration: none;
            color: inherit;
        }
        div.menu_block a {
            display: block;
            height: 100%;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-left: 8px;
            padding-right: 8px;
        }
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".entry").children("span").addClass("entry_span");
            $(".entry").mouseover(function(){
                $("span", this).removeClass("entry_span");
                $(".center").css("z-index","-1");
                $(".left").css("z-index","-1");
            });
            $(".entry").mouseleave(function(){
                $("span", this).addClass("entry_span");
                $(".center").css("z-index","10");
                $(".left").css("z-index","11");
            });
        });
    </script>
</head>
<body>
    <?php
        $query="SELECT * FROM menu WHERE father='0'";
        $result=mysqli_query($database,$query);
        if($result){
            while($row=mysqli_fetch_array($result)){
                print("<div class='entry'>");
                $query="SELECT * FROM menu WHERE father='". $row['id'] ."'";
                $result2=mysqli_query($database,$query);
                if($row['url'] == 'no_url'){
                    print("<div class='menu_block'><a>". $row['name'] ."</a></div><span>");
                }else{
                    print("<div class='menu_block'><a href='".$row['url']."'>". $row['name'] ."</a></div><span>");
                }
                while($child_row=mysqli_fetch_array($result2)){
                    if($child_row['url'] == 'no_url'){
                        print("<div class='menu_block'><a>". $child_row['name'] ."</a></div>");
                    }else{
                        print("<div class='menu_block'><a href='".$child_row['url']."'>". $child_row['name'] ."</a></div>");
                    }
                }
                print('</span></div>');
            }
        }
    ?>
    <?php
        if(isset($_SESSION['login']) && $_SESSION['login'] == "1"){
            echo '<div class="right_menu">
                  <a href="logout.php">登出</a>
                  </div>';
        }
    ?>
    <div class="right_menu">
        <a href="article.php">後臺管理</a>
    </div>
    <div class="right_menu">
        <a href="index.php">回首頁</a>
    </div>
</body>
</html>