<?php

if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}
$nav_link='hal=data_kriteria';
$edit_link='hal=update_kriteria';

$no=0;
$daftar='';
$bobot=array(0=>'',1=>'Sangat Rendah',2=>'Rendah',3=>'Cukup',4=>'Tinggi',5=>'Sangat Tinggi');
$q=mysqli_query($con,"select * from kriteria order by id_kriteria");
if(mysqli_num_rows($q) > 0) 
	
	while($h=mysqli_fetch_array($q)){
		$no++;
		if ($no<9){
			$daftar.='
		  <tr>
			<td valign="top">'.$no.'</td>
			<td valign="top">'.$h['nama'].'</td>

			<td align="center" valign="top"><a href="#" onclick="DeleteConfirm(\'?'.$edit_link.'&id='.$h['id_kriteria'].'&action=delete\');return(false);"><img src="images/delete.png"></a> <a href="?'.$edit_link.'&amp;id='.$h['id_kriteria'].'&amp;action=edit"><img src="images/edit.png"></a></td>
		  </tr>
	
		';
		}
		if ($no==9){
				$daftar.='
		  <tr>
			<td valign="top">8.a</td>
			<td valign="top">'.$h['nama'].'</td>

			<td align="center" valign="top"><a href="#" onclick="DeleteConfirm(\'?'.$edit_link.'&id='.$h['id_kriteria'].'&action=delete\');return(false);"><img src="images/delete.png"></a> <a href="?'.$edit_link.'&amp;id='.$h['id_kriteria'].'&amp;action=edit"><img src="images/edit.png"></a></td>
		  </tr>
	
		';
		}
		if ($no==10){
				$daftar.='
		  <tr>
			<td valign="top">8.b</td>
			<td valign="top">'.$h['nama'].'</td>

			<td align="center" valign="top"><a href="#" onclick="DeleteConfirm(\'?'.$edit_link.'&id='.$h['id_kriteria'].'&action=delete\');return(false);"><img src="images/delete.png"></a> <a href="?'.$edit_link.'&amp;id='.$h['id_kriteria'].'&amp;action=edit"><img src="images/edit.png"></a></td>
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
		<div style="font-size:18px;padding:10px 0 10px 0 ">DATA KRITERIA</div>
		<div align="right"><a href="?hal=update_kriteria&amp;action=new">Tambah Data</a></div><br>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td align="left" width="40">NO</td>
			<td align="left">NAMA KRITERIA</td>

			<td align="left" width="40">AKSI</td>
		  </tr>
		  <?php echo $daftar;?>
		</table>

		
    	</div>
