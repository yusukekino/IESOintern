<html>
<head>
<meta charset = "UFT-8">
<title>3-8ログインページ</title>
</head>
<body>
<h1> <font color = "#00ff00" size = "7" face = "ＭＳ 明朝" >掲示板３－８ログイン</font></h1>


<?php
//データベースに接続
$dbname = 'データベース名';
$host = 'ホスト名';
$user_name = 'ユーザー名';
$password = 'パスワード';


$pdo = new PDO("mysql:dbname=$dbname; host=$host",'$user_name','$password');


session_start();

//テーブルを作成

//会員情報のみのテーブル
$sql = 'CREATE TABLE IF NOT EXISTS kaiindata308
	(
 	id varchar(50),
	name text(50),
	psw char(50),
	PRIMARY KEY(id)
	);';

$result = $pdo ->query($sql);


//投稿するデータのテーブル
$sql = 'CREATE TABLE IF NOT EXISTS toukoudata308
	(
	No int(11) auto_increment,
	name text(50),
	comment text(50),
	date varchar(50),
	psw char(50),
        filename char(50),
	PRIMARY KEY(No)
	);';

$result = $pdo ->query($sql);

//この数字によって状態を変える
$postsinkinum = $_POST['sinki_num'];



//会員登録 番号は１　ログインは２

if($postsinkinum == NULL or $postsinkinum == 0 ){ 
?>
	<form action = "mission_3-8_loginpage.php" method = "post">

	新規会員登録 <br/><br/><br/><br/>
	掲示板で使用する名前を入力してください。<br/>
	<input type = "text" name ="sinki_name"><br/><br/>
	
	掲示板で使用するIDを入力してください。<br/>
	<input type = "text" name ="sinki_id"><br/><br/>

	パスワードを設定してください。<br/>
	※このパスワードは次回以降のログイン時、および<br/>
	　削除、編集の際に必要になります。<br/>
	<input type = "text" name ="sinki_psw" ><br/>
	
	<input type = "hidden" name ="sinki_num" value = "1"><br/>

	<input type = "submit" value ="登録">
	

	</form>

-------------------------------------------------------------------<br/><br/>
	<form action = "mission_3-8_loginpage.php" method = "post">

	会員登録がお済みの方 <br/><br/><br/><br/>
	idを入力してください。<br/>
	<input type = "text" name ="kizon_id"><br/>
	
	パスワードを入力してください。<br/>
	
	<input type = "text" name ="kizon_psw" ><br/>
	
	<input type = "hidden" name ="sinki_num" value = "2"><br/>

	<input type = "submit" value ="ログイン">
	

	</form>
	</body>
	</html>


<?php 
}


//新規会員登録の名前、パスワード、ＩＤが送信された場合 

if( isset($_POST['sinki_psw']) and isset($_POST['sinki_name']) ){ 

	$_SESSION['sinkiname'] = $_POST['sinki_name'];
	$_SESSION['sinkipsw'] = $_POST['sinki_psw'];
	$_SESSION['sinkiID'] = $_POST['sinki_id'];
	
	header("Location: mission_3-8.php");
	exit();

}

//ログインのID,パスワードが入力された場合 

if(isset($_POST['kizon_psw']) and isset($_POST['kizon_id']) and $postsinkinum == 2){
	$_SESSION['loginID'] = $_POST['kizon_id'];
	$_SESSION['loginpsw'] = $_POST['kizon_psw'];

	header("Location: mission_3-8.php");
	exit();

}


?>


