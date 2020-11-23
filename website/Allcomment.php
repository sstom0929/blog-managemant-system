<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
	<title>所有文章</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="sorttable.js"></script>
	<script src="tablecolor.js"></script>
</head>
<body>
	<?php include('db_connect.php'); ?>
	<?php
		if(isset($_POST["delete"])){
            if(isset($_POST['del'])){
                $del_array = $_POST['del'];
                foreach($del_array as $i){
				    $query="DELETE FROM comment WHERE id='".$i."'";
                    mysqli_query($database,$query);
                }
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="comment.php";</script>';
		}
	?>
    <p style='font-size:25px'>所有留言</p>
    <form action="Allcomment.php" method="post">
    <?php
        $query="SELECT * FROM comment";
        $result=mysqli_query($database,$query);
        print("<table><thead style='text-align:left'><tr><th style=\"min-width:50px;text-align:center\"><input type=\"checkbox\" onclick=\"check_all(this)\" /></th><th onclick='sortTable(1),table_color()' style=\"min-width:140px\">留言者</th><th  style=\"min-width:140px;max-width:300px;padding-right:25px\">內容</th><th onclick='sortTable(3),table_color()' style=\"min-width:140px\">留言文章/頁面</th><th onclick='sortTable(4),table_color()' style=\"min-width:240px\">發佈時間</th></tr></thead><tbody>");
        for(;$row=mysqli_fetch_array($result);){
            print("<tr>");
            print("<td style='text-align:center'><input type=\"checkbox\" name=\""."del[]"."\" value=\"". $row['id'] ."\"></td>");
            print("<td style='padding-right:25px'>".$row['name']."</td>");
            print("<td style='word-break: break-all;min-width:140px;max-width:300px;padding-right:25px'>".$row['content']."</td>");
            if($row['is_article'] != '0'){
                $temp = mysqli_query($database,'SELECT * FROM article WHERE id="'. $row['father'] .'"');
                $tmp = mysqli_fetch_array($temp);
                $tmp_name = $tmp['title'];
                print("<td style='padding-right:32px'><a href='showarticle.php?id=".$row['father']."'>".$tmp_name."(文章)</a></td>");
            }else{
                $temp = mysqli_query($database,'SELECT * FROM page WHERE id="'. $row['father'] .'"');
                $tmp = mysqli_fetch_array($temp);
                $tmp_name = $tmp['title'];
                print("<td style='padding-right:32px'><a href='showpage.php?id=".$row['father']."'>".$tmp_name."(頁面)</a></td>");
            }
            print("<td>".$row['time']."</td>");
            print("</tr>");
        }
        print("</tbody></table>");
    ?>
    <p style="font-style: italic; font-weight:300">按下留言者,留言文章/頁面或時間進行排序</p>
    <input type="submit" name="delete" value="刪除所選留言">
    </form>
    <script>
        function check_all(obj){ 
            var checkboxs = Array();
            checkboxs = $("[type='checkbox']");
            for(var i=0;i<checkboxs.length;i++){
                checkboxs[i].checked = obj.checked;
            } 
        }
        $("[type='checkbox']").click(function(){
            if((this).checked == false){
                checkboxs = $("[type='checkbox']");
                checkboxs[0].checked = false;
            }
            if((this).checked == true){
                checkboxs = $("[type='checkbox']");
                var tmp_check = true;
                for(var i=1;i<checkboxs.length;i++){
                    if(checkboxs[i].checked == false){
                        tmp_check = false;
                        break;
                    }
                }
                if(tmp_check)
                    checkboxs[0].checked = true;
            }
        });
    </script>
</body>
</html>