<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style type="text/css">
		body{
			font-family:Microsoft JhengHei;
		}
        html {
            background-color: #f2f2f2;
        }
        .login {
            text-align: center;
            margin-top: 250px;
            display: table;
            margin: auto;
        }
        .center {
            margin-top: 200px;
        }
	</style>
</head>
<body>
  <div class="center">
      <div class="login">
          <form action="confirm.php" method="POST">
              <h1>登入後台</h1><br>
              帳號:&nbsp;&nbsp;<input type="text" name="account"><br><br>
              密碼:&nbsp;&nbsp;<input type="password" name="password"><br><br><br>
              <input type="submit" name="login" value="登入">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type ="button" onclick="javascript:location.href='index.php'" value="回首頁">
          </form>
      </div>
  </div>
</body>
</html>