<?php
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $host = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);

/*$host = "localhost";
$username = "root";
$password = "root";
$dbname = "register_func";*/
