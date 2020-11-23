<!DOCTYPE html>
<html>
<head>
    <?php include('enter_backend.php'); ?>
	<title>編輯頁面</title>
	<meta charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<style type="text/css">
		#body{
			height: 100%;
		}
		.editbutton{
			height: 34px;
			width: 34px;
			padding: 3px;
			background-color: #e6e6e6;
			border: 2px solid #e6e6e6;
			background-position: center center;
			background-repeat: no-repeat;
		}
		.editbutton:hover{
			background-color: #ffffff;
			border: 2px solid #000000;
			border-radius: 5px;
		}
        .p_text{
            margin-top: 8px;
            margin-bottom: 8px;
            font-size: 18px;
        }
	</style>
</head>
<body>
	<?php include('db_connect.php'); ?>
	<?php $id=$_GET["id"]; ?>
	<?php		
		// 若Submit，修改DB
		if(isset($_POST["submit"])){
			$tmpstr = strip_tags($_POST["content"]);
            $tmpstr2 = $_POST["title"];
			if(chop($tmpstr) != "" && chop($tmpstr2) != ""){
                $query="UPDATE page SET title='".$_POST["title"]."',content='".$_POST["content"]."' WHERE id=".$id;
                mysqli_query($database,$query);
                echo '<script>$("form").submit(function(e) {e.preventDefault();});</script>';
                echo '<script>document.location.href="page.php";</script>';
            }else{
                if(chop($tmpstr2) == ""){
                    echo '<script>alert("請輸入標題")</script>';
                    echo '<script>document.location.href="page.php";</script>';
                }
                if(chop($tmpstr) == ""){
                    echo '<script>alert("請輸入內容")</script>';
                    echo '<script>document.location.href="page.php";</script>';
				}
			}
		}
	?>
	<?php
		$query="SELECT * FROM page WHERE id=".$id;
		$row=mysqli_fetch_array(mysqli_query($database,$query));
        if(!$row['title']){
            echo '<script>alert("無此頁面")</script>';
            echo '<script>document.location.href="page.php";</script>';
        }
		$title=$row['title'];
		$content=$row['content'];
	?>
	<p class='p_text'>標題</p>
	<input type="text" id="text_title" style="width:240px; height: 1.2em; border: 1.5px solid #000000;" value='<?php echo $title ?>'>
	<p class='p_text'>內容</p>
		<div style="background-color: #e6e6e6; margin: 10px 0px; margin-right: 50px; height: 450px;">
			<div style="padding: 5px 10px;">
				<button class="editbutton" type="button" title="粗體 (Ctrl+B)" onclick="document.execCommand('bold')" style="background-image: url(image/cc/black/png/font_bold_icon&24.png);"></button>
				<button class="editbutton" type="button" title="斜體 (Ctrl+I)" onclick="document.execCommand('italic')" style="background-image: url(image/cc/black/png/font_italic_icon&24.png);"></button>
				<button class="editbutton" type="button" title="底線 (Ctrl+U)" onclick="document.execCommand('underline')" style="background-image: url(image/cc/black/png/font_underline_icon&24.png);"></button>
				<button class="editbutton" type="button" title="項目符號列表" onclick="document.execCommand('insertUnorderedList')" style="background-image: url(image/cc/black/png/list_bullets_icon&24.png);"></button>
				<button class="editbutton" type="button" title="編號清單" onclick="document.execCommand('insertOrderedList')" style="background-image: url(image/cc/black/png/list_num_icon&24.png);"></button>
				<button class="editbutton" type="button" title="靠左" onclick="document.execCommand('justifyLeft')" style="background-image: url(image/cc/black/png/align_left_icon&24.png);"></button>
				<button class="editbutton" type="button" title="置中" onclick="document.execCommand('justifyCenter')" style="background-image: url(image/cc/black/png/align_center_icon&24.png);"></button>
				<button class="editbutton" type="button" title="靠右" onclick="document.execCommand('justifyRight')" style="background-image: url(image/cc/black/png/align_right_icon&24.png);"></button>
			</div>
			<div style="padding: 5px 10px;">
				<button class="editbutton" type="button" title="增加縮排" onclick="document.execCommand('indent')" style="background-image: url(image/cc/black/png/indent_increase_icon&24.png);"></button>
				<button class="editbutton" type="button" title="減少縮排" onclick="document.execCommand('outdent')" style="background-image: url(image/cc/black/png/indent_decrease_icon&24.png);"></button>
				<button class="editbutton" type="button" title="復原" onclick="document.execCommand('undo')" style="background-image: url(image/cc/black/png/undo_icon&24.png);"></button>
			    <button class="editbutton" type="button" title="取消復原" onclick="document.execCommand('redo')" style="background-image: url(image/cc/black/png/redo_icon&24.png);"></button>
			    <button class="editbutton" type="button" title="加入連結" onclick="$('#span_a').css('display','inline');" style="background-image: url(image/cc/black/png/link_icon&24.png);"></button>
                    <span id="span_a" style="display: none;">
                        <input  size="45px" type="text" id="input_a" placeholder="在此輸入網址...(重新選取欲加入連結的文字再按確認)">
                        <button onclick="CreateLink()">確認</button>
                        <button onclick="$('#span_a').css('display','none');">取消</button>
                        <script>
                            function CreateLink(){
                                if($("#input_a").val()){
                                    document.execCommand("createLink",false,$("#input_a").val());
                                    $('#span_a').css('display','none');
                                    $('#input_a').attr('value','');
                                }
                                else
                                    window.alert("請輸入網址");
                            }
                        </script>
                    </span>
			</div>
			<div style="padding: 5px 10px;margin-left:8px;padding-bottom:0px">
				字體顏色: <input type="color" onchange="document.execCommand('foreColor',false,this.value)" style="padding: 0px; height: 24px;">&nbsp;&nbsp;&nbsp;背景顏色: <input type="color" onchange="document.execCommand('backColor',false,this.value)" style="padding: 0px; height: 24px;">字體大小: <select onchange="document.execCommand('FontSize',false,this.value)" style="padding: 0px; height: 24px;width:45px">
				    <?php
                        for($i=1;$i<8;$i++){
                            print('<option value="'. $i .'">'.'h'.(8 - $i)."</option>");
                        }
                    ?>
				</select>
			</div>
			<div id="text_content" contenteditable="true" style="border: 1.5px solid #000000; height: 57%; padding: 10px;margin: 10px 20px;margin-top:3px;overflow: scroll;">
				<?php echo $content; ?>
			</div>
		</div>
		<div>
			<form action="editpage.php?id=<?php echo $id; ?>" method="post">
				<input id="submit" type="submit" name="submit" value="修改">
				<input id="title" type="hidden" name="title">
				<input id="content" type="hidden" name="content">
				<script>
					$(document).ready(function(){
						$("#submit").click(function(){
							$("#title").val($("#text_title").val());	
							$("#content").val($("#text_content").html());
						});
					});
				</script>
			</form>
		</div>
</body>
</html>