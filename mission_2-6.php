<html>
<head>
<meta charset = "UFT-8">
<title>ミッション2-6です。</title>
</head>
<body>
<h1>掲示板</h1>




<?php

//削除


if( isset($_POST['number']) ){            //もし削除番号が送信されたら、パスワード入力画面を表示させる
?>
	<form action = "mission_2-6.php" method = "post">

	削除の前にパスワードを入力してください <br/>
	<input type = "hidden" name ="sakunum" value = "<?php echo $_POST['number'] ?>"><br/>
	<input type = "text" name ="psw_sakujo" ><br/>
	<input type = "submit" value ="送信">

	</form>
<?php
}

if( isset( $_POST['psw_sakujo'])){		//削除番号送信後、パスワードがあっていたら削除実行
	$sakujo_number = $_POST['sakunum'];
	$array_g = file('ghost2-2.txt');
	$array = file('kadai2-2.txt');
        $array_sakujo = explode("<>",$array_g[$sakujo_number - 1]);

	if( $_POST['psw_sakujo'] == $array_sakujo[4]){
		$num = count($array);

		for( $i = 0; $i < $num; $i++ ){
			$array_pieces = explode("<>",$array[$i]);

			if( $array_pieces[0] != $sakujo_number ){
				if( $f == 0 ){
					$fp = fopen( 'kadai2-2.txt','w' );
					fwrite( $fp,$array[$i] );
					fclose( $fp );
					$f++;
				}
				else{
					$fp = fopen( 'kadai2-2.txt','a' );
					fwrite( $fp,$array[$i] );
					fclose( $fp );
				}
			}
		}

	}
	else{					//パスワードが間違っていた場合、違いますと表示
		echo passwordが違います."\n";
		
	}
}





//投稿編集
if( isset( $_POST['number2'] ) ){		//編集対象番号が送信された場合パスワードを要求する
?>
	<form action = "mission_2-6.php" method = "post">

	編集の前にパスワードを入力してください <br/>
	<input type = "hidden" name ="hennum" value = "<?php echo $_POST['number2'] ?>"><br/>
	<input type = "text" name ="psw_hensyu" ><br/>
	<input type = "submit" value ="送信">

	</form>
<?php
}
if( isset( $_POST['psw_hensyu'] )){		//もしパスワードが入力され、それが正しければ編集
	$hen_num = $_POST['hennum'];
	$array = file( 'ghost2-2.txt' );
	$array_hensyu = explode("<>",$array[$hen_num - 1]);
	$num = count($array);

	if( $_POST['psw_hensyu'] == $array_hensyu[4]){

		for( $i = 0; $i < $num; $i++ ){
			$array2 = explode("<>",$array[$i]);

			if( $array2[0] == $hen_num ){
				$new_name = $array2[1];
				$new_comment = $array2[2];
			}
		}
	}
	else{					//パスワードが間違っていた場合、違いますと表示
		echo passwordが違います."\n";
		
	}
		
}



if( isset($_POST['number']) or isset($_POST['number2'] )){
}
else{			

?>





<form action = "mission_2-6.php" method = "post">

名前 <br/>
<input type = "text" name ="name" value = "<?php echo $new_name ?>" ><br/>

コメント <br/>
<input type = "text" name ="comment" value = "<?php echo $new_comment ?>" ><br/>

パスワードを入力してください <br/>
<input type = "text" name ="psw"><br/>
※このパスワードは削除、編集の際に必要になります<br/>
<input type = "hidden" name ="hidden" value = "<?php echo $hen_num ?>" >


<input type = "submit" value ="送信">

</form>





<form action = "mission_2-6.php" method = "post">

削除 <br/>
<input type = "text" name ="number" ><br/>

<input type = "submit" value ="この投稿を削除する">

</form>







<form action = "mission_2-6.php" method = "post">

編集対象番号を入力してください <br/>
<input type = "text" name ="number2"><br/>

<input type = "submit" value ="この番号を編集する">

</form>
</body>
</html>



<?php
}

//掲示板に入力

if( isset($_POST['number']) or isset($_POST['number2']) ){ //削除と編集の番号が送信されたときは特別
	
	if(isset($_POST['number2'])){				//編集番号が送信された場合、何もしない
	}
	else{							//削除番号が入力された場合、今までのやつを出力
		$fq = fopen( 'kadai2-2.txt','r');         //掲示板に出力(削除した後のデータ）

		$array = file( 'kadai2-2.txt' );

		for( $i = 0 ; $i < count($array) ; $i++ ){
			$array_pieces = explode("<>",$array[$i]);
			echo $array_pieces[0] . " " . $array_pieces[1] . " " .
			$array_pieces[2] . " " . $array_pieces[3]."<br/>";
		}
		fclose($fq);
	}
}
else{

	if( $_POST['hidden'] > 0 ){			//編集番号が送信されたとき
		$hen_num2 = $_POST['hidden'];
		$array = file( 'kadai2-2.txt' );
		$num = count($array);

		for( $i = 0; $i < $num; $i++ ){			//エクスプロードする
			$array2 = explode("<>",$array[$i]);

			if( $array2[0] == $hen_num2 ){		//編集番号と一致した場合、$newfileに差し替えた情報を格納する。
				$newfile[$i] = $hen_num2 . '<>' . $_POST['name'] . '<>' . $_POST['comment'] . 
       						'<>' . $array2[3] ."\n";
			}
			else{    				//編集番号と一致しなかった場合、$newfileに元のファイルの情報を入れる。
				$newfile[$i] = $array[$i];
		        }
		}
		$fp = fopen('kadai2-2.txt','w');
		
		for( $i = 0; $i < count($newfile) ; $i++ ){	//$newfileの情報を'kadai2-2.txt'に上書き
			fwrite( $fp , $newfile[$i] );
		}
		fclose( $fp );
	}
	else{						//編集番号が送信されなかったとき（つまり普通に掲示板に書き込みたいとき）
		
		if( isset($_POST['name'] ) and isset( $_POST['comment'] ) and isset($_POST['psw']) ){//名前、コメント、パスワード全て入力した場合のみ書き込み可能

			$fp = fopen( 'kadai2-2.txt','a');
			$fg = fopen( 'ghost2-2.txt','a');       //削除されても残る全く同じ内容のファイル（配列の総数を変えないため）

			$file = file( 'ghost2-2.txt' );
			
			$num = count($file) + 1;
				
			$str = $num . '<>' . $_POST['name'] . '<>' . $_POST['comment'] . 
			       '<>' . date('Y / m / d / h : i') . '<>' .$_POST['psw']. '<>' ."\n";


			fwrite($fp,$str);
			fwrite($fg,$str);
			fclose($fp);
			fclose($fg);
		}
	}

	$fq = fopen( 'kadai2-2.txt','r');   //掲示板に出力

	$array = file( 'kadai2-2.txt' );

	for( $i = 0 ; $i < count($array) ; $i++ ){
		$array_pieces = explode("<>",$array[$i]);
		echo $array_pieces[0] . " " . $array_pieces[1] . " " .
		$array_pieces[2] . " " . $array_pieces[3]."<br/>";
	}
	fclose($fq);

}

?>
