

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>週報作成システム</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<form method="post">
	<h1>ログインフォーム</h1>
	<div class="form-group">
		<input input pattern="[1-9][0-9]*" maxlength="6" minlength="6" class="form-control" name="student_id" placeholder="学籍番号6桁" required />
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required />
	</div>
	<button type="submit" class="btn btn-default" name="login">ログインする</button>
	<a href="register.php">会員登録はこちら</a>
</form>

</div>
</body>
</html>