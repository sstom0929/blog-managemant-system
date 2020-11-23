<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
	<title>所有文章</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="tablecolor.js"></script>
	<script src="sorttable.js"></script>
	
</head>
<body>
	<?php include('db_connect.php'); ?>
	<?php
		// 若Delete，刪除DB
		if(isset($_POST["delete"])){
            if(isset($_POST['del'])){
                $del_array = $_POST['del'];
                foreach($del_array as $i){
                    $comment_query="DELETE FROM comment WHERE father='".$i."' AND is_article='0'";
                    mysqli_query($database,$comment_query);
				    $query="DELETE FROM page WHERE id='".$i."'";
                    mysqli_query($database,$query);
                }
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="page.php";</script>';
		}
	?>
    <p style='font-size:25px'>所有頁面</p>
    <form action="Allpage.php" method="post">
    <?php
        $query="SELECT * FROM page";
        $result=mysqli_query($database,$query);
        print("<table><thead style='text-align:left'><tr><th style=\"min-width:50px;text-align:center\"><input type=\"checkbox\" onclick=\"check_all(this)\" /></th><th onclick='sortTable(1),table_color()' style=\"min-width:140px\">標題</th><th style=\"min-width:75px;text-align:center;padding-right:20px\">留言數</th><th onclick='sortTable(3),table_color()' style=\"min-width:240px\">發佈時間</th><th></th></tr></thead><tbody>");
        for(;$row=mysqli_fetch_array($result);){
            print("<tr>");
            print("<td style='text-align:center'><input type=\"checkbox\" name=\""."del[]"."\" value=\"". $row['id'] ."\"></td>");
            print("<td style='padding-right:25px'>".$row['title']."</td>");
            $tmp_result = mysqli_query($database, 'SELECT COUNT(*) AS num FROM comment WHERE father="'.$row['id'].'" AND is_article="0";');
            $tmp_num = mysqli_fetch_array($tmp_result);
            print("<td style='text-align:center;padding-right:20px'>".$tmp_num['num']."</td>");
            print("<td>".$row['time']."</td>");	
            print("<td><button style='margin-right:25px' type=\"button\" onclick=\"location.href='./page.php?center_display=new_page&edit=1&id=".$row['id']."'\">編輯</td>");
            print("</tr>");
        }
        print("</tbody></table>");
    ?>
    <p style="font-style: italic; font-weight:300">按下標題或時間進行排序</p>
    <input type="submit" name="delete" value="刪除所選頁面">
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