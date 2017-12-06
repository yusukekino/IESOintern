<html>
<head>
<meta charset = "UFT-8">
<title>3-8ログアウトページ</title>
</head>
<body>
<h1> <font color = "#00ff00" size = "7" face = "ＭＳ 明朝" >掲示板３－８</font></h1>


<?php
//データベースに接続
$dbname = 'データベース名';
$host = 'ホスト名';
$user_name = 'ユーザー名';
$password = 'パスワード';


$pdo = new PDO("mysql:dbname=$dbname; host=$host",'$user_name','$password');


session_start();

$_SESSION = array();

session_destroy();

?>

<a href = "mission_3-8_loginpage.php">ログインページに戻る</a>
</body>
</html>



