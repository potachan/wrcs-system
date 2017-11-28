<?php
date_default_timezone_set('Asia/Tokyo');

session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}

// ユーザーIDからユーザー名を取り出す
$query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);

$result = $mysqli->query($query);
if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}

// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
	$username = $row['username'];
	$student_id = $row['student_id'];
}

// データベースの切断
$result->close();

$date = date('w');
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>週報作成システム</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
</head>
<body>
<div class="col-xs-12 col-md-6 col-md-offset-3">

<h2 class="visible-xs" align="center">プロフィール</h2>
<h1 class="hidden-xs">プロフィール</h1>
<ul>
	<li>名前：<?php echo $username; ?></li>
</ul>
<p>
<font size="5", color="red"><?php if($w == 5) echo "今日は月曜です！先週の週報は送りましたか？"?></font>
</p>

 <ul class="nav nav-tabs nav-justified">
    <li class="active"><a href="#">ホーム</a></li>
	<li><a href="record.php?record">記録ページ</a></li>
	<li><a href="portfolio.php?portfolio">ポートフォリオ</a></li>
	<li><a href="other.php?">他者の記録</a></li>
	<li><a href="logout.php?logout">ログアウト</a></li>
 </ul>





</div>
</body>
</html>
