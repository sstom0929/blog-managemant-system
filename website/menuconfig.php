<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
    <meta charset="UTF-8">
    <title>後臺管理</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="tablecolor.js"></script>
</head>
<body>
    <?php include('db_connect.php'); ?>
    <?php
        $errormsg = "";
		if(isset($_POST["form1"])){
            $tmpstr = $_POST["name"];
            if(chop($tmpstr) != ""){
                if($_POST["father"]=="NULL")
				    $query="INSERT INTO menu (name, father, url) VALUES ('".$_POST["name"]."','0','". $_POST["url"] ."')";
                else
				    $query="INSERT INTO menu (name, father, url) VALUES ('".$_POST["name"]."','".$_POST["father"]."','".$_POST["url"]."')";
			    //print("<p>".$query."</p>");
			    // 防呆
                if(!mysqli_query($database,$query)){
				    $errormsg = "無法將資料存入資料庫";
                }
            }else{
                $errormsg = "請輸入選單名稱";
            }
            if($errormsg != ""){
                echo '<script>alert("'. $errormsg .'")</script>';   
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="indexconfig.php";</script>';
		}
        if(isset($_POST["form2"])){
            if(isset($_POST['del'])){
                $del_array = $_POST['del'];
                foreach($del_array as $i){
				    del($i);
                }
            }
            echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
            echo '<script>document.location.href="indexconfig.php";</script>';
		}
        function del($input){
            global $database;
            $tmp_result = mysqli_query($database,"SELECT * FROM menu WHERE father = '". $input ."'");
            while($tmprow=mysqli_fetch_array($tmp_result)){
                mysqli_query($database,"DELETE FROM menu WHERE id='".$tmp_row['id']."'");
            }
            mysqli_query($database,"DELETE FROM menu WHERE id='".$input."'");
        }
    ?>
    <form class="add_class_form" method="post" action="menuconfig.php">
        <span style='font-size:22px'>選單名稱</span><br> <input type="text" name="name"><br>
        <span style='font-size:22px'>上層選單</span><br>
        <select name="father">
            <option value="NULL">無</option>
            <?php
                $query="SELECT * FROM menu WHERE father = '0'";
                $result=mysqli_query($database,$query);
                while($row=mysqli_fetch_array($result)){
                    print('<option value="'. $row['id'] .'">'.$row['name']."</option>");
                }
            ?>
        </select><br>
        <span style='font-size:22px'>選單連結</span><br>
        <select name="url">
            <option value="no_url">無</option>
            <?php
                $query="SELECT * FROM class WHERE father = 'NULL'";
                $result=mysqli_query($database,$query);
                while($row=mysqli_fetch_array($result)){
                    display_option($row,0);
                }
                function display_option($nowrow,$nowpre){
                    global $database;
                    print('<option value="showclass.php?id='. $nowrow['id'] .'">');
                    for($i=1;$i<=$nowpre;$i++){
                        print("-");
                    }
                    print($nowrow['name']."(分類)</option>");
                    $query="SELECT * FROM class WHERE father = '".$nowrow['id']."'";
                    $result=mysqli_query($database,$query);
                    while($row=mysqli_fetch_array($result)){
                        display_option($row,$nowpre+1);
                    }
                }
                $query="SELECT * FROM article";
                $result=mysqli_query($database,$query);
                while($row=mysqli_fetch_array($result)){
                    print('<option value="showarticle.php?id='. $row['id'] .'">'.$row['title']." (文章)"."</option>");
                }
                $query="SELECT * FROM page";
                $result=mysqli_query($database,$query);
                while($row=mysqli_fetch_array($result)){
                    print('<option value="showpage.php?id='. $row['id'] .'">'.$row['title']." (頁面)"."</option>");
                }
            ?>
        </select><br>
        <input name="form1" type="submit" value="新增">
    </form>
    <form class="del_class_form" method="post" action="menuconfig.php">
    <?php
        $query="SELECT * FROM menu WHERE father='0'";
        $result=mysqli_query($database,$query);
        print("<table><thead><tr><th style=\"min-width:40px\"><input type=\"checkbox\" onclick=\"check_all(this)\" /></th><th style=\"min-width:200px\">名稱</th></tr></thead><tbody>");
        if($result){
            while($row=mysqli_fetch_array($result)){
                $query="SELECT * FROM menu WHERE father='". $row['id'] ."'";
                $result2=mysqli_query($database,$query);
                print("<tr><td style='text-align:center'><input type=\"checkbox\" name=\"del[]\" value=\"". $row['id'] ."\"></td><td style='padding-left:25px;padding-right:25px'>".$row['name']."</td></tr>");
                while($child_row=mysqli_fetch_array($result2)){
                    print("<tr><td style='text-align:center'><input type=\"checkbox\" name=\"del[]\" value=\"". $child_row['id'] ."\"></td><td style='padding-left:25px;padding-right:25px'>"."-".$child_row['name']."</td></tr>");
                }
            }
        }
        print("</tbody></table>");
    ?>
    <p style="font-style: italic; font-weight:300">刪除主選單將會刪除其下所有子選單</p>
    <input name="form2" type="submit" value="刪除">
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