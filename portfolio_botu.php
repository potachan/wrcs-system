<?php
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

?>

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

<h1>研究ポートフォリオ</h1>

<div  class="container">
<table class="table table-striped table-bordered table-hover table-condensed">

<thead><tr><th class="col-md-1">日付</th><th class="col-lg-1">時間</th><th class="col-md-10">内容</th></tr></thead>

<?php
  $query = "SELECT * FROM portfolio";
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
  	if( $student_id == $row['student_id']){
      $day = htmlspecialchars($row['day']);
      $comment = htmlspecialchars($row['comment']);
      $research_time = htmlspecialchars($row['research_time']);
      echo "<tr><td>$day</td><td>$research_time 時間</td><td>$comment</td></tr>";
    }
  }
?>

</table>
</div>

 <ul class="nav nav-tabs nav-justified">
    <li><a href="home.php?record">ホーム</a></li>
	<li><a href="record.php?record">記録ページ</a></li>
	<li class="active"><a href="#">ポートフォリオ</a></li>
	<li><a href="logout.php?logout">ログアウト</a></li>
 </ul>


</div>
</body>
</html>

