<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
	<title>分類</title>
	<meta charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="tablecolor.js"></script>
</head>
<body>
	<?php include('db_connect.php'); ?>
	<?php
        
		// 若Submit，傳入DB
        $errormsg = "";
		if(isset($_POST["form1"])){
            $tmpstr = $_POST["name"];
            if(chop($tmpstr) != ""){
                if($_POST["father"]=="NULL")
				    $query="INSERT INTO class (name, father) VALUES ('".$_POST["name"]."','NULL')";
                else
				    $query="INSERT INTO class (name, father) VALUES ('".$_POST["name"]."','".$_POST["father"]."')";	
			    //print("<p>".$query."</p>");
			    // 防呆
                if(!mysqli_query($database,$query)){
				    $errormsg = "無法將資料存入資料庫";
                }
            }else{
                $errormsg = "請輸入分類名稱";
            }
            if($errormsg != ""){
                echo '<script>alert("'. $errormsg .'")</script>';   
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="article.php?center_display=tag";</script>';
		}
		// 若Delete，刪除DB
		if(isset($_POST["form2"])){
            if(isset($_POST['del'])){
                $del_array = $_POST['del'];
                foreach($del_array as $i){
				    del($i);
                }
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="article.php?center_display=tag";</script>';
		}
        function del($input){
            global $database;
            $query="UPDATE article SET class = '0' WHERE class = '". $input ."'";
            mysqli_query($database,$query);
            $tmp = mysqli_query($database,"SELECT * FROM class WHERE id = '". $input ."'");
            $temp = mysqli_fetch_array($tmp);
            $query="UPDATE class SET father = '". $temp['father'] ."' WHERE father = '". $input ."'";
            mysqli_query($database,$query);
            mysqli_query($database,"DELETE FROM class WHERE id='".$input."'");
        }
	?>
	
	<form class="add_class_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?center_display=tag";?>">
		<!-- 新增分類 -->
		<div class="add_class_form">
			<span style='font-size:22px'>新增分類</span><br> <input type="text" name="name"><br>
			<span style='font-size:22px'>上層分類</span><br>
			<select name="father">
				<option value="NULL">無</option>
				<?php
                    $query="SELECT * FROM class WHERE father = 'NULL'";
                    $result=mysqli_query($database,$query);
                    while($row=mysqli_fetch_array($result)){
                        display_option($row,0);
                    }
                    function display_option($nowrow,$nowpre){
                        global $database;
                        print('<option value="'. $nowrow['id'] .'">');
                        for($i=1;$i<=$nowpre;$i++){
                            print("-");
                        }
                        print($nowrow['name']."</option>");
                        $query="SELECT * FROM class WHERE father = '".$nowrow['id']."'";
                        $result=mysqli_query($database,$query);
                        while($row=mysqli_fetch_array($result)){
                            display_option($row,$nowpre+1);
                        }
                    }
                ?>
			</select><br>
			<input name="form1" type="submit" value="新增">
		</div>
    </form>
    <form class="del_class_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?center_display=tag";?>">
		<!-- 刪除分類 -->
		<div class="del_class_form">
			<?php
				// 印出主分類
				$query="SELECT * FROM class WHERE father='NULL'";
				$result=mysqli_query($database,$query);
				print("<table><thead><tr><th style=\"min-width:40px\"><input type=\"checkbox\" onclick=\"check_all(this)\" /></th><th style=\"min-width:200px\">名稱</th></tr></thead><tbody>");
                $pre = "";
				for(;$row=mysqli_fetch_array($result);){
				    display_checkbox($row,0);
				}
				print("</tbody></table>");
                function display_checkbox($nowrow,$nowpre){
                    global $database;
                    print("<tr><td style='text-align:center'><input type=\"checkbox\" name=\"del[]\" value=\"". $nowrow['id'] ."\"></td><td style='padding-left:25px;padding-right:25px'>");
	       		    for($i=1;$i<=$nowpre;$i++){
	                    print("-");
	        	    }
	        		print($nowrow['name']."</td></tr>");
                    $query="SELECT * FROM class WHERE father = '".$nowrow['id']."'";
                    $result=mysqli_query($database,$query);
				    while($row=mysqli_fetch_array($result)){
                        display_checkbox($row,$nowpre+1);
                    }
                }
			?>
			<input name="form2" type="submit" value="刪除">
		</div>
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
    </form>
</body>
</html>