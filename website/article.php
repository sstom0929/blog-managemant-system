<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
    <meta charset="UTF-8">
    <title>後臺管理</title>
    <link type="text/css" rel="stylesheet" href="backend.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".parent").mouseover(function(){
                $("ul", this).css("visibility","visible");
            });
            $(".parent").mouseleave(function(){
                $("ul", this).css("visibility","hidden");
            });
        });
    </script>
    <?php
        if(isset($_GET["center_display"])){
            echo '<script>
                $(document).ready(function(){
                    $(".now").removeClass("now");
                    $("#'.$_GET["center_display"].'").addClass("now");
                });
            </script>';
        }
    ?>
</head>
<body>
   <div class="main">
       <div class="left">
           <ul class="parent">
               <li>
                   <a href="index.php">回首頁</a>
               </li>
           </ul>
           <ul class="parent">
               <li>
                   <a href="indexconfig.php">選單設定</a>
               </li>
           </ul>
           <ul class="nowul">
               <li>
                   <a href="article.php">管理文章</a>
                   <ul class="float">
                       <li><a href="article.php">全部文章</a></li>
                       <li><a href="article.php?center_display=new_article">新增文章</a></li>
                       <li><a href="article.php?center_display=tag">分類</a></li>
                   </ul>
               </li>
           </ul>
           <ul class="child">
               <li class="now" id="all_article"><a href="article.php">全部文章</a></li>
           </ul>
           <ul class="child">
               <li id="new_article"><a href="article.php?center_display=new_article">新增文章</a></li>
           </ul>
           <ul class="child">
               <li id="tag"><a href="article.php?center_display=tag">分類</a></li>
           </ul>
           <ul class="parent">
               <li>
                   <a href="page.php">管理頁面</a>
                   <ul class="float">
                       <li><a href="page.php">全部頁面</a></li>
                       <li><a href="page.php?center_display=new_page">新增頁面</a></li>
                   </ul>
               </li>
           </ul>
           <ul class="parent">
               <li><a href="comment.php">管理留言</a></li>
           </ul>
           <ul class="parent">
               <li>
                   <a href="logout.php">登出</a>
               </li>
           </ul>
       </div> 
       <div class="center">
           <?php
               if(isset($_GET["edit"]) && $_GET["edit"] == '1'){
                   if(!isset($_GET["id"])){
                       echo '<script>alert("未選擇頁面")</script>';
                       echo '<script>document.location.href="article.php";</script>';
                   }else{
                       include('editarticle.php');
                   }
               }else{
                   if(isset($_GET["center_display"]) && $_GET["center_display"] == 'tag'){
                       include('class.php');
                   }
                   if(isset($_GET["center_display"]) && $_GET["center_display"] == 'new_article'){
                       include('textedit.php');
                   }
                   if(!isset($_GET["center_display"])){
                       include('allarticle.php');
                   }
               }
           ?>
       </div>
   </div>
</body>
</html> 