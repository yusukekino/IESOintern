<?php
//データベースに接続

$dbname = 'データベース名';
$host = 'ホスト名';
$user_name = 'ユーザー名';
$password = 'パスワード';


$pdo = new PDO("mysql:dbname=$dbname; host=$host",'$user_name','$password');



//セッションスタート
session_start();

if(  $_SESSION['j'] != 2 ){

	if( $_POST['sinki_num2'] == 8 ){//もし会員情報確認画面でやり直すを押した場合
		$_SESSION = array();
		session_destroy();//セッションの削除
	}



	if(!session_is_registered("loginID") and !session_is_registered("sinkiID")){//もしログインIDがセッションされていなければ、ログインページへ
		header("Location: mission_3-8_loginpage.php");
		exit();
	}
	
/*	$sin_ID=$_SESSION['sinkiID'];
	$sin_name=$_SESSION['sinkipsw'];
	$sin_psw=$_SESSION['sinkiID'];
	$loginID=$_SESSION['loginID'];
	$loginpsw=$_SESSION['loginpsw'];*/

	if( session_is_registered("sinkiID") and $_POST['sinki_num2'] != 1){//新規登録の場合
		?>
		<!DOCTYPE html>
		<html lang = "ja">
		<head>
		<meta charset = "UFT-8">
		<title>会員情報確認画面</title>
		</head>
		<body>
		<center>
		<br><br>
		名前　　　：<?php echo $_SESSION['sinkiname']?><br>
		ＩＤ　　　：<?php echo $_SESSION['sinkiID']?><br>
		パスワード：<?php echo $_SESSION['sinkipsw']?><br>
		<br>
		上記の情報で新規会員登録を行います。よろしいですか？<br><br>

			<form action = "mission_3-8.php" method = "post">
			<input type = "hidden" name ="sinki_num2" value = "1"><br/>
			<input type = "submit" value ="はい">
			</form>

			<form action = "mission_3-8.php" method = "post">
			<input type = "hidden" name ="sinki_num2" value = "8"><br/>
			<input type = "submit" value ="やり直す">
			</form>
		</center>
		</body>
		</html>
	<?php
	}

	if( $_POST['sinki_num2'] == 1 ){ //新規登録確認画面ではいと答えた場合

		$sinkiid = $_SESSION['sinkiID'];
		$sinkiname = $_SESSION['sinkiname'];
		$sinkipsw = $_SESSION['sinkipsw'];

	//データベースに会員情報を登録
		$sql = "INSERT into kaiindata308 (id , name , psw) VALUES ( '$sinkiid' , '$sinkiname' , '$sinkipsw' )";
		$result = $pdo ->query('SET NAMES utf-8');
		$result = $pdo ->query($sql);

		$_SESSION['j'] = 2;
	}



	//既存の会員がログインする場合
	if( session_is_registered("loginID")){
		$sql="SELECT psw FROM kaiindata308 WHERE id ='$loginID'";
		$result=$pdo->query($sql);
		$password2=$result->fetchColumn();

		if($loginpsw!=$password2){
			?>
			<!DOCTYPE html>
			<html lang = "ja">
			<head>
			<meta charset = "UFT-8">
			<title>ログイン失敗</title>
			</head>
			<body>
			<center>
			<br><br>
			<h6>パスワードが間違っています。<h6><br>
			<a href='mission_3-8_loginpage.php'>ログイン画面へ</a>
			</form>
			</body>
			</html>
			<?php
			session_start();
			session_destroy();
			exit();
		}
		?>


		<?php

		if($loginpsw==$password2){
			$_SESSION['j'] = 2;
		}

	}

}


if( $_SESSION['j'] == 2 ){    //会員登録が済んでいる状態




//削除


if( isset($_POST['number']) ){            //もし削除番号が送信されたら、パスワード入力画面を表示させる
?>
	<!DOCTYPE html>
	<html lang = "ja">
	<head>
	<meta charset = "UFT-8">
	<title>削除</title>
	</head>
	<body>

	<form action = "mission_3-8.php" method = "post">

	削除の前にパスワードを入力してください <br/>
	<input type = "hidden" name ="sakunum" value = "<?php echo $_POST['number'] ?>"><br/>
	<input type = "text" name ="psw_sakujo" ><br/>

	<input type = "submit" value ="送信">

	</form>
	</body>
	</html>
<?php
}

if( isset( $_POST['psw_sakujo'])){		//削除番号送信後、パスワードがあっていたら削除実行
	$sakujo_number = $_POST['sakunum'];
	$sakujo_psw = $_POST['psw_sakujo'];
	
	$sql = "SELECT psw FROM toukoudata308 WHERE No = '$sakujo_number'";
	$result = $pdo ->query($sql);
	$pas = $result->fetchColumn();

	if( $pas == $sakujo_psw ){

		$sql = "DELETE FROM toukoudata308 WHERE No = '$sakujo_number'";
		$result = $pdo ->query($sql);
		$sql = "ALTER TABLE toukoudata308 auto_increment = 1";
		$result = $pdo ->query($sql);
	}else{
		echo "パスワードが違います。";
	}
}





//投稿編集
if( isset( $_POST['number2'] ) ){		//編集対象番号が送信された場合パスワードを要求する
?>
	<!DOCTYPE html>
	<html lang = "ja">
	<head>
	<meta charset = "UFT-8">
	<title>編集</title>
	</head>
	<body>

	<form action = "mission_3-8.php" method = "post">

	編集の前にパスワードを入力してください <br/>
	<input type = "hidden" name ="hennum" value = "<?php echo $_POST['number2'] ?>"><br/>
	<input type = "text" name ="psw_hensyu" ><br/>

	<input type = "submit" value ="送信">

	</form>
	</body>
	</html>

<?php
}
if( isset( $_POST['psw_hensyu'] )){		//もしパスワードが入力され、それが正しければ入力フォームに編集対象を入力済みで表示
	$hen_num = $_POST['hennum'];
	$hen_psw = $_POST['psw_hensyu'];
	
	$sql = "SELECT psw FROM toukoudata308 WHERE No = '$hen_num'";
	$result = $pdo ->query($sql);
	$pas = $result->fetchColumn();
	
	

	if( $hen_psw == $pas ){
		$sql = "SELECT name FROM toukoudata308 WHERE No = '$hen_num'";
		$result = $pdo ->query($sql);
		$new_name = $result->fetchColumn();

		$sql = "SELECT comment FROM toukoudata308 WHERE No = '$hen_num'";
		$result = $pdo ->query($sql);
		$new_comment = $result->fetchColumn();


	}
	else{
		echo "パスワードが違います";
	
	}
		
}



if( isset($_POST['number']) or isset($_POST['number2'] )){
}
else{	
	




//編集の場合
	if( $new_name != NULL and $new_comment != NULL ){ ?>

		<!DOCTYPE html>
		<html lang = "ja">
		<head>
		<meta charset = "UFT-8">
		<title>編集入力</title>
		</head>
		<body>

		<form action = "mission_3-8.php" method = "post">

		名前 <br/>
		<input type = "text" name ="name" value = "<?php echo $new_name ?>" ><br/>

		コメント <br/>
		<input type = "text" name ="comment" value = "<?php echo $new_comment ?>" ><br/>

		<input type = "hidden" name ="hidden" value = "<?php echo $hen_num ?>" >


		<input type = "submit" value ="この内容で送信">

		</form>
		</body>
		</html>

	<?php 

	}else{ 

//それ以外は、会員情報の名前とパスワードを入力済みで

?>
		<!DOCTYPE html>
		<html lang = "ja">
		<head>
		<meta charset = "UFT-8">
		<title>掲示板３－８</title>
		</head>
		<body>

		<form action = "mission_3-8.php" enctype = "multipart/form-data" method = "post">

		名前 <br/>
		<input type = "text" name ="name" value = "<?php echo $kaiin_name ?>" ><br/>

		コメント <br/>
		<input type = "text" name ="comment"><br/>

		パスワードを入力してください <br/>
		<input type = "text" name ="psw" value = "<?php echo $kaiin_psw ?>"><br/>

		※このパスワードは削除、編集の際に必要になります<br/>

		<br/>
		<input type = "file" name = "file" size = "55">
		<input type = "hidden" name ="hidden" value = "<?php echo $hen_num ?>" >


		<input type = "submit" value ="送信">

		</form>






		<form action = "mission_3-8.php" method = "post">

		削除 <br/>
		<input type = "text" name ="number" ><br/>
		<input type = "submit" value ="この投稿を削除する">

		</form>







		<form action = "mission_3-8.php" method = "post">

		編集対象番号を入力してください <br/>
		<input type = "text" name ="number2"><br/>
		<input type = "submit" value ="この番号を編集する">

		</form>

		<br><br>

                <a href = "mission_3-8_logout.php">ログアウト</a>
		
		</body>
		</html>



		<?php
	}
}

//掲示板に入力



if( $_POST['hidden'] > 0){			//編集番号が送信されたとき
	$hen_num2 = $_POST['hidden'];
	$postnewname = $_POST['name'];
	$postnewcomment = $_POST['comment'];

	//入力フォームから送信された情報を上書き
	$sql = "update toukoudata308 set name = '$postnewname' , comment = '$postnewcomment' where No = $hen_num2";
	$result = $pdo ->query($sql);

}
else{						//編集番号が送信されなかったとき（つまり普通に掲示板に書き込みたいとき）
	
	if( isset($_POST['name'] ) and isset( $_POST['comment'] ) and isset($_POST['psw']) ){//名前、コメント、パスワード全て入力した場合のみ書き込み可能

		//テーブルに投稿するデータを挿入
		
		$date = new DateTime();
		$date = $date ->format('Y / m / d / h : i : s');

		$postname = $_POST['name'];
		$postcom = $_POST['comment'];
		$postpsw = $_POST['psw'];

	//画像や動画のファイルが送信されている場合
		if(isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
 			$old_name = $_FILES['file']['tmp_name'];

			//  もしuploadというフォルダーがなければ
			if(!file_exists('upload')){
				mkdir('upload');
			}

			$new_name = date("YmdHis"); //ベースとなるファイル名は日付
			$new_name .= mt_rand(); //ランダムな数字も追加

			$ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);

			if($_FILES['file']['name']!=NULL){
				if($ext=="mp4"){
					$new_name .= '.mp4';
				}
				else if($ext=="jpeg"){
					$new_name .= '.jpg';
				}
				else if($ext=="gif"){
					$new_name .= '.gif';
				}
				else if($ext=="png"){
					$new_name .= '.png';
				}

				else{
					header('Location: mission_3-8.php');
				}
			}
			move_uploaded_file ( $old_name, 'upload/' . $new_name);

			$sql = "INSERT INTO toukoudata308 ( name , comment , date , psw ,filename) VALUES ( '$postname' , '$postcom' , '$date' , '$postpsw' , $new_name)";
			$result = $pdo ->query('SET NAMES utf-8');
			$result = $pdo ->query($sql);

		}else{
			$sql = "INSERT INTO toukoudata308 ( name , comment , date , psw ) VALUES ( '$postname' , '$postcom' , '$date' , '$postpsw')";
			$result = $pdo ->query('SET NAMES utf-8');
			$result = $pdo ->query($sql);
		
		}
	}
}

//掲示板に出力

$sql = 'SELECT * FROM toukoudata308';
$result = $pdo ->query($sql);


foreach($result as $row){
	print "<div style='padding: 10px; margin-bottom: 10px; border: 1px solid #00aced; border-radius: 10px;'>";
	print '<br>';
	print $row['No'].' ';
	print $row['name'];
	print "<font color='gray'>";
	print "</font><br><br>";
	print '　　'.$row['comment'].'<br><br>';
	print "<center>";
	$e = substr($row['filename'], strrpos($row['filename'], '.') + 1);
	if($e=="mp4"){ ?>
	<video src="http://~~~~/upload/<?php echo $row['filename']; ?>"></video> 
	<?php }
	else{ ?>
	<img src="http://~~~~/upload/<?php echo $row['filename']; ?>">
	<?php }
	print "</center>";
	print "<div align='right'>";
	print '<br>'.$row['date'].'<br>';
	print "</div>";
	print "<br>";
	print "</div>";
}



}


?>
