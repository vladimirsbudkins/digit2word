<?php
	header("content-type:text/html;charset=utf8");
	//автозагрузка классов
	function __autoload($class)
	{
  		require_once("classes/$class.php");
	}
	if(isset($_POST['digit']))
	{
		$positive_integer = new positive_integer();
		$result = $positive_integer->convert($_POST['digit']);
	}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Digits to numbers</title>
	<!--link href="css/style.css" rel="stylesheet"-->
</head>
<body>
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
		<p>
			<!--p><input type="number" min="1" max="" name="digit"><p-->
			<input type="text" name="digit">
			<input type="submit" name="convert" value="Contert to word" >
		</p>
	</form>
	<!--Вывод результата-->
	<h3><?=$result?></h3>
</body>
</html>