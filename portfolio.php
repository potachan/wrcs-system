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

<?php
//本日取得
function getToday($date = 'Y-m-d') {
 	$today = new DateTime();
	return $today->format($date);
}
 
//本日かどうかチェック
function isToday($year, $month, $day) {
 	$today = getToday('Y-n-j');
 	if ($today == $year."-".$month."-".$day) {
 		return true;
	}
	return false;
}
 
//今週月曜日の日付を返す
function getMonday() {
 
	$today = new DateTime();
	$w = $today->format('w');
	$ymd = $today->format('Y-m-d');
 
	if ($w == 0) {
		$d = 6;
	} else {
		$d = $w - 1 ;
	}
	$next_prev = new DateTime($ymd);
	$next_prev->modify("-{$d} day");
	return $next_prev->format('Ymd');
 
}
 
//N日（週）+か-する関数
function getNthDay($year, $month, $day, $n) {
 
	$next_prev = new DateTime($year.'-'.$month.'-'.$day);
	$next_prev->modify($n);
	return $next_prev->format('Ymd');
}

//週間カレンダー表示
if (isset($_GET['date'])) {
	//年月日取得
	$year_month_day = $_GET['date'];
 } else {
	//今週日曜日取得
	$year_month_day = getMonday();
 }
 

//年月日に変数で取得
$year  = substr($year_month_day, 0, 4); 
$month = substr($year_month_day, 4, 2); 
$day   = substr($year_month_day, 6, 2); 
$month = sprintf("%01d", $month);
$day   = sprintf("%01d", $day);
$weekjp = array(
	'(日)', //0
	'(月)', //1
	'(火)', //2
	'(水)', //3
	'(木)', //4
	'(金)', //5
	'(土)'  //6
);

$next_week = getNthDay($year, $month, $day, '+1 week');
$pre_week  = getNthDay($year, $month, $day, '-1 week');

$table = NULL;

//週間の日付出力
for ($i = 0; $i < 7; $i++) { 
	$ymd = getNthDay($year, $month, $day, '+'.$i.' day');
	$y = substr($ymd, 0, 4); 
	$m = substr($ymd, 4, 2); 
	$d = substr($ymd, 6, 2); 
	$n = sprintf("%01d", $m);
	$j = sprintf("%01d", $d);
	$t = $j.'日';
	//指定日のタイムスタンプを取得
	$timestamp = mktime(0, 0, 0, $m, $d, $y);

	//指定日の曜日番号（日:0  月:1  火:2  水:3  木:4  金:5  土:6）を取得
	$weekno = date('w', $timestamp);

	$diff = null;
	$diff = "SELECT * FROM portfolio WHERE day = '$ymd' AND student_id = '$student_id' ";
	$stmt = $mysqli->query($diff);
	$oma = null;
	$student_id2 = null;

	// ユーザー情報の取り出し
	while ($row = $stmt->fetch_assoc()) {
		$oma = $row['day'];
		$research_time = htmlspecialchars($row['research_time']);
		$comment = htmlspecialchars($row['comment']);
		$student_id2 = $row['student_id'];
	}

	// データベースの切断
	$stmt->close();

	if ($student_id == $student_id2 && isset($oma)) {
		$table .= '<tr><td>'.$t.'&nbsp;'.$weekjp[$weekno].'</td><td>'.$research_time.'</td><td>'.$comment.'</td></tr>'.PHP_EOL;

	}
	else {
		$table .= '<tr><td>'.$t.'&nbsp;'.$weekjp[$weekno].'<td></td><td></td></td></tr>'.PHP_EOL;

	}
}
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

<h2 class="visible-xs">週間研究ポートフォリオ</h2>
<h1 class="visible-lg">週間研究ポートフォリオ</h1>

<table class="table table-striped table-bordered table-hover table-condensed">

<tr>
<th><a href="<?php $_SERVER['SCRIPT_NAME'];?>?date=<?php echo $pre_week;?>">&laquo; 前週</a></td>
<th><?php echo $year;?> 年 <?php echo $month;?> 月</td>
<th><a href="<?php $_SERVER['SCRIPT_NAME'];?>?date=<?php echo $next_week;?>">次週 &raquo;</a></td>
</tr>


<tr><th class="col-md-1 col-xs-3">日付</th><th class="col-md-1 col-xs-4">時間</th><th class="col-md-4 col-xs-5">内容</th></tr>
<?php echo "$table"; ?>

</table>

 <ul class="nav nav-tabs nav-justified">
    <li><a href="home.php?record">ホーム</a></li>
	<li><a href="record.php?record">記録ページ</a></li>
	<li class="active"><a href="#">ポートフォリオ</a></li>
	<li><a href="logout.php?logout">ログアウト</a></li>
 </ul>


</div>
</body>
</html>

