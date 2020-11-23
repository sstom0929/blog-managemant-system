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
            margin-top: 80px;
        }
	</style>
</head>
<body>
  <div class="center">
      <div class="login">
          <form action="setting_confirm.php" method="POST">
              <h1>網站設定</h1><br>
              資料庫帳號:&nbsp;&nbsp;<input type="text" name="db_account" required><br><br>
              資料庫密碼:&nbsp;&nbsp;<input type="password" name="db_password" required><br><br>
              資料庫名稱:&nbsp;&nbsp;<input type="text" name="db_name" required><br><br><br><br>
              網站名稱:&nbsp;&nbsp;<input type="text" name="website_name" required><br><br>
              設定帳號:&nbsp;&nbsp;<input type="text" name="account" required><br><br>
              設定密碼:&nbsp;&nbsp;<input type="password" name="password" required><br><br>
              確認密碼:&nbsp;&nbsp;<input type="password" name="confirm_password" required><br><br><br>
              <input type="submit" name="submit" value="確認">
          </form>
      </div>
  </div>
</body>
</html>