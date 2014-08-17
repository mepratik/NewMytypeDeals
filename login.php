<?php
	session_start();
	require_once('config.php');
	
	$conf=new configure();
	try
	{
		$dbh=new PDO("mysql:host=$conf->host;dbname=$conf->dbname","$conf->uname","$conf->pass");
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	$password=md5($password);
	
	$stmt=$dbh->prepare("SELECT * FROM users WHERE email=:uname AND password=:password");
	$stmt->bindParam(":uname",$username);
	$stmt->bindParam(":password",$password);
	$stmt->execute();
	if($stmt->rowCount() == 1)
	{
		$r=$stmt->fetch();
		$_SESSION['login']=1;
		$_SESSION['uname']=$username;
		$_SESSION['uid']=$r['uid'];
		$_SESSION['fname']=$r['fname'];
		echo "Authentication Successful : Loading account details...";
	}
	else
	{
		echo "Authentication Failure : Username or Password you have provided is wrong.";
		session_destroy();
	}
?>