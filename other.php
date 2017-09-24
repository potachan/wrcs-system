<?php
date_default_timezone_set('Asia/Tokyo');

session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}

include_once 'dbconnect.php';

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

?> 

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>週報作成支援システム</title>
<link rel="stylesheet" type="text/css" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
</head>
<body>

<div class="col-xs-12 col-md-6 col-md-offset-3">

<h2 class="visible-xs" align="center">週間研究ポートフォリオ</h2>
<h1 class="hidden-xs">週間研究ポートフォリオ</h1>

<table class="table table-striped table-bordered table-hover table-condensed">

<tr><th class="col-md-1 col-xs-3">学籍番号</th><th class="col-md-1 col-xs-3">氏名</th></tr>

<?php
  $query = "SELECT * FROM users";
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
      $username = $row['username'];
      $student_id = $row['student_id'];
      echo "<tr><td>$student_id</td><td><a href=\"other_portfolio.php?select_id=$student_id?select_name=&username\">$username</a></td></tr>";
  }
?>

</table>

 <ul class="nav nav-tabs nav-justified">
    <li><a href="home.php?">ホーム</a></li>
	<li><a href="record.php?record">記録ページ</a></li>
	<li><a href="portfolio.php?portfolio">ポートフォリオ</a></li>
	<li class="active"><a href="#">他者の記録</a></li>
	<li><a href="logout.php?logout">ログアウト</a></li>
 </ul>


</div>
</body>
</html>

