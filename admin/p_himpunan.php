<?php

if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}
$id_kriteria='';
if(isset($_POST['kriteria'])){
	$id_kriteria=$_POST['kriteria'];
}elseif(isset($_GET['kriteria'])){
	$id_kriteria=$_GET['kriteria'];
}

$nav_link='hal=data_himpunan';
$edit_link='hal=update_himpunan';
$no=0;
$daftar='';
$sql=mysqli_query($con,"select * from himpunan where id_kriteria='".$id_kriteria."'");
if(mysqli_num_rows($sql) > 0){
	while($h=mysqli_fetch_array($sql)){
		$no++;
		$daftar.='
		  <tr>
			<td valign="left">'.$no.'</td>
			<td valign="left">'.$h['nama'].'</td>
			<td valign="left" align="left">'.$h['nilai'].'</td>
			<td align="left" valign="left"><a href="#" onclick="DeleteConfirm(\'?'.$edit_link.'&id='.$h['id_himpunan'].'&action=delete&id2='.$h['id_kriteria'].'\');return(false);"><img src="images/delete.png"></a> <a href="?'.$edit_link.'&amp;id='.$h['id_himpunan'].'&amp;action=edit"><img src="images/edit.png"></a></td>
		  </tr>
		';
	}
}
# menampilkan data kriteria yang bertipe combo
$list_kriteria='<option value="">Pilih --</option>';
$q=mysqli_query($con,"select * from kriteria order by id_kriteria");
if(mysqli_num_rows($q)>0){
	while($h=mysqli_fetch_array($q)){
		if($id_kriteria==$h['id_kriteria']){$s='selected';}else{$s='';}
		$list_kriteria.='<option value="'.$h['id_kriteria'].'" '.$s.'>'.$h['nama'].'</option>';
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
		<div style="font-size:18px;padding:10px 0 10px 0 ">DATA HIMPUNAN</div>
		<form action="" method="post">
		<input name="cmd_show" type="hidden" value="true" />
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td width="120">Nama Kriteria</td>
			<td><select name="kriteria" onchange="submit()"><?php echo $list_kriteria;?></select></td>
		  </tr>
		</table>
		</form>
		<br>
		<div align="right"><?php if($id_kriteria>0){?><a href="?hal=update_himpunan&amp;action=new&id2=<?php echo $id_kriteria;?>">Tambah Data</a><?php } ?></div><br>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td align="left" width="40">NO</td>
			<td align="left">NILAI KRITERIA</td>
			<td align="left" width="140">NILAI</td>
			<td align="left" width="40">AKSI</td>
		  </tr>
		  <?php echo $daftar;?>
		</table>


    	</div>
