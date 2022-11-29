<?php

?>
		
        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<?php
		if(isset($_SESSION['LOGIN_username'])){
		?>
		<div style="font-size:18px;padding:10px 0 10px 0 ">LOGIN ADMIN DAN USER </div>
		Anda dalam status login.
		<?php
		}else{
		?>
		<div style="font-size:18px;padding:10px 0 10px 0 ">LOGIN ADMIN DAN USER</div>
		<img src="gembok.jpg" />
		<form action="login.php" name="form_login" method="post">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td width="120">Username </td>
			<td><input name="username" type="text" size="40" value=""></td>
		  </tr>
		  <tr>
			<td>Password</td>
			<td><input name="password" type="password" size="40" value=""></td>
		  </tr>
		  <tr>
			<td></td>
			<td><input name="login" type="submit" value="Login"> </td>
		  </tr>
		</table>
		</form>
		
		<?php } ?>

    	</div>
