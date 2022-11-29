<?php

$db_host 		= 'localhost';
$db_user 		= 'root';
$db_password 	= '';
$db_name 		= 'spk';

$www 			='http://localhost/spk/';

$con = @mysqli_connect($db_host,$db_user,$db_password) or die('<center>Error ! Gagal koneksi ke server database</center>');
mysqli_select_db($con,$db_name) or die('<center>Error ! Database tidak ditemukan</center>');
?>