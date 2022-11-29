<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}

$nav_link='hal=data_alternatif';
$edit_link='hal=update_alternatif';
$no=0;
$daftar='';
$search=$_POST['search'];
if($_POST['search'] == ""){
$q="select * from alternatif   order by nama";

}
else{

	$q="select * from alternatif WHERE nama LIKE '%$search%' order by nama";
}
$q=mysqli_query($con,$q);
if(mysqli_num_rows($q) > 0){
	while($h=mysqli_fetch_array($q)){
		$no++;
		$daftar.='
		  <tr>
			<td valign="left">'.$no.'</td>
			<td valign="left">'.$h['nim'].'</td>
			<td valign="left">'.$h['nama'].'</td>
			
			<td align="center" valign="top"><a href="#" onclick="DeleteConfirm(\'?'.$edit_link.'&id='.$h['id_alternatif'].'&action=delete\');return(false);"><img src="images/delete.png"></a> <a href="?'.$edit_link.'&amp;id='.$h['id_alternatif'].'&amp;action=edit"><img src="images/edit.png"></a></td>
		  </tr>
		';
	}
}


?>
<script language="javascript">
function DeleteConfirm(url){
	if (confirm("Apakah anda yakin ingin menghapus ?")){
		window.location.href=url;
	}
}
</script>

        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:18px;padding:10px 0 10px 0 ">DATA CALON KARYAWAN</div>
		<div style="font-size:12px;padding:10px 0 10px 0 ">Pencarian Nama Calon Karyawan </div>
	
	<form action="<?php $_server['php_self'] ?>" method="post" name="pencarian" id="pencarian">  
		  <input type="text" name="search" id="search">  
		  <input type="submit" name="submit" id="submit" value="CARI">  
	</form>  
	

		<div align="right"><a href="?hal=update_alternatif&amp;action=new">Tambah Data</a></div><br>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td align="left" width="40">NO</td>
			<td align="left" width="140">NO. REGISTRASI</td>
			<td align="left">NAMA CALON KARYAWAN</td>
			
			<td align="left" width="40">AKSI</td>
		  </tr>
		  <?php echo $daftar;?>
		</table>

		

    	</div>
