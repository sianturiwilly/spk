<?php

session_start();
require_once 'config.php';

if(isset($_POST["login"])){
	if(empty($_POST['username']) or empty($_POST['password']))	{
		exit("<script>window.alert('Kolom Username atau Password harus diisi');window.history.back();</script>");
	}
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$q=mysqli_query($con,"SELECT * FROM admin WHERE username='".$username."' AND password='".$password."'");
	if(mysqli_num_rows($q)==0){
		exit("<script>window.alert('Username dan password yang anda masukkan salah');window.history.back();</script>");
	}
	$_SESSION['LOGIN_username']=$username;
	exit("<script>window.location='".$www."';</script>");
}

?>