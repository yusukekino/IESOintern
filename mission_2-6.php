<html>
<head>
<meta charset = "UFT-8">
<title>�~�b�V����2-6�ł��B</title>
</head>
<body>
<h1>�f����</h1>




<?php

//�폜


if( isset($_POST['number']) ){            //�����폜�ԍ������M���ꂽ��A�p�X���[�h���͉�ʂ�\��������
?>
	<form action = "mission_2-6.php" method = "post">

	�폜�̑O�Ƀp�X���[�h����͂��Ă������� <br/>
	<input type = "hidden" name ="sakunum" value = "<?php echo $_POST['number'] ?>"><br/>
	<input type = "text" name ="psw_sakujo" ><br/>
	<input type = "submit" value ="���M">

	</form>
<?php
}

if( isset( $_POST['psw_sakujo'])){		//�폜�ԍ����M��A�p�X���[�h�������Ă�����폜���s
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
	else{					//�p�X���[�h���Ԉ���Ă����ꍇ�A�Ⴂ�܂��ƕ\��
		echo password���Ⴂ�܂�."\n";
		
	}
}





//���e�ҏW
if( isset( $_POST['number2'] ) ){		//�ҏW�Ώ۔ԍ������M���ꂽ�ꍇ�p�X���[�h��v������
?>
	<form action = "mission_2-6.php" method = "post">

	�ҏW�̑O�Ƀp�X���[�h����͂��Ă������� <br/>
	<input type = "hidden" name ="hennum" value = "<?php echo $_POST['number2'] ?>"><br/>
	<input type = "text" name ="psw_hensyu" ><br/>
	<input type = "submit" value ="���M">

	</form>
<?php
}
if( isset( $_POST['psw_hensyu'] )){		//�����p�X���[�h�����͂���A���ꂪ��������ΕҏW
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
	else{					//�p�X���[�h���Ԉ���Ă����ꍇ�A�Ⴂ�܂��ƕ\��
		echo password���Ⴂ�܂�."\n";
		
	}
		
}



if( isset($_POST['number']) or isset($_POST['number2'] )){
}
else{			

?>





<form action = "mission_2-6.php" method = "post">

���O <br/>
<input type = "text" name ="name" value = "<?php echo $new_name ?>" ><br/>

�R�����g <br/>
<input type = "text" name ="comment" value = "<?php echo $new_comment ?>" ><br/>

�p�X���[�h����͂��Ă������� <br/>
<input type = "text" name ="psw"><br/>
�����̃p�X���[�h�͍폜�A�ҏW�̍ۂɕK�v�ɂȂ�܂�<br/>
<input type = "hidden" name ="hidden" value = "<?php echo $hen_num ?>" >


<input type = "submit" value ="���M">

</form>





<form action = "mission_2-6.php" method = "post">

�폜 <br/>
<input type = "text" name ="number" ><br/>

<input type = "submit" value ="���̓��e���폜����">

</form>







<form action = "mission_2-6.php" method = "post">

�ҏW�Ώ۔ԍ�����͂��Ă������� <br/>
<input type = "text" name ="number2"><br/>

<input type = "submit" value ="���̔ԍ���ҏW����">

</form>
</body>
</html>



<?php
}

//�f���ɓ���

if( isset($_POST['number']) or isset($_POST['number2']) ){ //�폜�ƕҏW�̔ԍ������M���ꂽ�Ƃ��͓���
	
	if(isset($_POST['number2'])){				//�ҏW�ԍ������M���ꂽ�ꍇ�A�������Ȃ�
	}
	else{							//�폜�ԍ������͂��ꂽ�ꍇ�A���܂ł̂���o��
		$fq = fopen( 'kadai2-2.txt','r');         //�f���ɏo��(�폜������̃f�[�^�j

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

	if( $_POST['hidden'] > 0 ){			//�ҏW�ԍ������M���ꂽ�Ƃ�
		$hen_num2 = $_POST['hidden'];
		$array = file( 'kadai2-2.txt' );
		$num = count($array);

		for( $i = 0; $i < $num; $i++ ){			//�G�N�X�v���[�h����
			$array2 = explode("<>",$array[$i]);

			if( $array2[0] == $hen_num2 ){		//�ҏW�ԍ��ƈ�v�����ꍇ�A$newfile�ɍ����ւ��������i�[����B
				$newfile[$i] = $hen_num2 . '<>' . $_POST['name'] . '<>' . $_POST['comment'] . 
       						'<>' . $array2[3] ."\n";
			}
			else{    				//�ҏW�ԍ��ƈ�v���Ȃ������ꍇ�A$newfile�Ɍ��̃t�@�C���̏�������B
				$newfile[$i] = $array[$i];
		        }
		}
		$fp = fopen('kadai2-2.txt','w');
		
		for( $i = 0; $i < count($newfile) ; $i++ ){	//$newfile�̏���'kadai2-2.txt'�ɏ㏑��
			fwrite( $fp , $newfile[$i] );
		}
		fclose( $fp );
	}
	else{						//�ҏW�ԍ������M����Ȃ������Ƃ��i�܂蕁�ʂɌf���ɏ������݂����Ƃ��j
		
		if( isset($_POST['name'] ) and isset( $_POST['comment'] ) and isset($_POST['psw']) ){//���O�A�R�����g�A�p�X���[�h�S�ē��͂����ꍇ�̂ݏ������݉\

			$fp = fopen( 'kadai2-2.txt','a');
			$fg = fopen( 'ghost2-2.txt','a');       //�폜����Ă��c��S���������e�̃t�@�C���i�z��̑�����ς��Ȃ����߁j

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

	$fq = fopen( 'kadai2-2.txt','r');   //�f���ɏo��

	$array = file( 'kadai2-2.txt' );

	for( $i = 0 ; $i < count($array) ; $i++ ){
		$array_pieces = explode("<>",$array[$i]);
		echo $array_pieces[0] . " " . $array_pieces[1] . " " .
		$array_pieces[2] . " " . $array_pieces[3]."<br/>";
	}
	fclose($fq);

}

?>
