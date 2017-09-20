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
<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>週報作成支援システム</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
</head>
<body>

<div class="col-xs-12 col-md-6 col-md-offset-3">


<?php
// signupがPOSTされたときに下記を実行
if(isset($_POST['record'])) {

	$research_time = $mysqli->real_escape_string($_POST['research_time']);
	$comment = $mysqli->real_escape_string($_POST['comment']);

	$today = date("Ymd");
	$diff = "SELECT * FROM portfolio WHERE day = '$today' AND student_id = '$student_id'";
	$stmt = $mysqli->query($diff);

	// ユーザー情報の取り出し
	while ($row = $stmt->fetch_assoc()) {
		$oma = $row['day'];
	}

	// データベースの切断
	$stmt->close();

	// POSTされた情報をDBに格納する
	if(isset($oma)) {
		$query = "INSERT INTO mogemoge(comment) VALUES('俺はもうabcd')";
		//$query = "UPDATE portfolio SET research_time = '$research_time', comment='$comment' WHERE day = '$today' AND student_id = '$student_id'";
		//echo "ok";
	} else {

		$query = "INSERT INTO mogemoge(comment) VALUES('俺はもうabcd')";
		//$query = "INSERT INTO portfolio(student_id,research_time,comment,day) VALUES('$student_id','$research_time','$comment','$today')";

		//echo "no";
	}

	if($mysqli->query($query)) {  ?>
		<div class="alert alert-success" role="alert">記録しました</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}
} ?>

<form method="post">
	<h2 class="visible-xs" align="center">研究記録フォーム</h2>
	<h1 class="hidden-xs">研究記録フォーム</h1>
	<div class="form-group">
		<input type="text" class="form-control" name="comment" placeholder="内容" required />
	</div>
	<div class="form-group"> 
    	 <!--  <div class="col-xs-2"> -->
      	<select class="form-control" name="research_time" required />
      		<option value="" disabled selected>研究に費やした時間</option>
        	<?php
				for ($i = 1; $i <=24; $i++) {
   					print ('<option value="' . $i. '">' . $i . '時間</option>');
   				}
   			?>
      	</select>
    	<!--	</div> -->
  	</div>
	<button type="submit" class="btn btn-default" name="record">記録する</button>
</form>




 <ul class="nav nav-tabs nav-justified">
    <li><a href="home.php?home">ホーム</a></li>
	<li class="active"><a href="record.php?record">記録ページ</a></li>
	<li><a href="portfolio.php?portfolio">ポートフォリオ</a></li>
	<li><a href="logout.php?logout">ログアウト</a></li>
 </ul>

</div>
</body>
</html>
