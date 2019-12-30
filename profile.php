<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

 <?php
 $ten = $_GET["name"];
 $mk =$_GET["email"];
	if ( $ten=="admin"&& $mk="123"){
	echo "Thanh cong";
	}
 ?>
Welcome <?php echo $_GET["name"]; ?><br>
Your password is: <?php echo $_GET["email"]; ?>
</body>
</html>