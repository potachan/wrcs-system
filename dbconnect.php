<?php
//データベースの接続と選択
require_once('./core/config.php');


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
	error_log($mysqli->connect_error);
	exit;
}

/* 文字セットを utf8 に変更します */
//if (!$mysqli->set_charset("utf8")) {
//    printf("Error loading character set utf8: %s\n", $mysqli->error);
//} else {
//    printf("Current character set: %s\n", $mysqli->character_set_name());
//}


// if(!mysql_connect("localhost","root","root"))
// {
//      die('oops connection problem ! --> '.mysql_error());
// }
// if(!mysql_select_db("register_func"))
// {
//      die('oops database selection problem ! --> '.mysql_error());
// }