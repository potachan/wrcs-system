<?php

session_start();
if( isset($_SESSION['user']) != "") {
	// ログイン済みの場合はリダイレクト
	header("Location: home.php");
}

// DBとの接続
include_once 'dbconnect.php';
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>週報作成支援システム</title>
<link rel="stylesheet" href="style.css">

<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="col-xs-12 col-md-6 col-md-offset-3">

<?php
// signupがPOSTされたときに下記を実行
if(isset($_POST['signup'])) {

	$username = $mysqli->real_escape_string($_POST['username']);
	$student_id = $mysqli->real_escape_string($_POST['student_id']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$password = password_hash($password, PASSWORD_BCRYPT);

	// POSTされた情報をDBに格納する
	$query = "INSERT INTO users(username,student_id,password) VALUES('$username','$student_id','$password')";

	if($mysqli->query($query)) {  ?>
		<div class="alert alert-success" role="alert">登録しました</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}
} ?>

<form method="post">
	<h2 class="visible-xs" align="center">会員登録フォーム</h2>
	<h1 class="hidden-xs">会員登録フォーム</h1>
	<div class="form-group">
		<input type="text" class="form-control" name="username" placeholder="ユーザー名" required />
	</div>
	<div class="form-group">
		<input input pattern="[1-9][0-9]*" maxlength="6" minlength="6" class="form-control" name="student_id" placeholder="学生番号6桁" required />
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required />
	</div>
	<button type="submit" class="btn btn-default" name="signup">会員登録する</button>
	<br>　<br>
	<a href="index.php">ログインはこちら</a>
</form>

</div>
</body>
</html>