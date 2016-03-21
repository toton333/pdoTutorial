<?php 
$dsn = 'mysql:host=127.0.0.1;dbname=rdb;charset=utf-8'; //dsn stands for Data Source Name, charset=utf-8 is important
$username = 'root';
$password = 'ladygaga123';

try{

	$db = new PDO($dsn, $username,$password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

}catch(PDOException $e){

      die('Some error occured'. $e->message);
}

/*

 PDO will throw a PDOException when it fails to connect, but not when queries fail. If you want this anyway, you can use the below code after the $db = line to enable it:

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
or you can add it directly into your PDO initialization:

$db = new PDO($dsn, $username, $password, array (
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));

*/