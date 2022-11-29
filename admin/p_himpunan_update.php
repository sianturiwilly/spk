<?php

if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}
$nama='';
$nilai='';

if(isset($_POST['simpan'])){
	$nama=$_POST['nama'];
	$nilai=$_POST['nilai'];
	if(empty($_POST['nama'])){
		echo "<script>window.alert('Kolom bertanda \'harus diisi\' tidak boleh kosong.');</script>";
	}else{
		if($_POST['action']=='new'){
			$q="insert into himpunan(id_kriteria, nama, nilai) values('".$_POST['id2']."', '".$_POST['nama']."', '".$_POST['nilai']."')";
			mysqli_query($con,$q);
			$id2=$_POST['id2'];
		}
		if($_POST['action']=='edit'){
			$q="update himpunan set nama='".$_POST['nama']."',nilai='".$_POST['nilai']."' where id_himpunan='".$_POST['id']."'";
			mysqli_query($con,$q);
			$id2=$_POST['id2'];
		}
		exit("<script>location.href='?hal=data_himpunan&kriteria=".$id2."';</script>");
	}
}
$id2='';
if(isset($_GET['id2'])){
	$id2=$_GET['id2'];
}
$q=mysqli_query($con,"select * from kriteria where id_kriteria='".$id2."'");
if(mysqli_num_rows($q)>0){
	$h=mysqli_fetch_array($q);
	$kriteria=$h['nama'];
}

$action=$_GET['action'];
if($_GET['action']=='edit' and !empty($_GET['id'])){
	$id=$_GET['id'];
	$q=mysqli_query($con,"select * from himpunan where id_himpunan='".$id."'");
	if(mysqli_num_rows($q)>0){
		$h=mysqli_fetch_array($q);
		$nama=$h['nama'];
		$nilai=$h['nilai'];
		$id2=$h['id_kriteria'];
		$q=mysqli_query($con,"select * from kriteria where id_kriteria='".$h['id_kriteria']."'");
		if(mysqli_num_rows($q)>0){
			$h=mysqli_fetch_array($q);
			$kriteria=$h['nama'];
		}
	}
}
if($_GET['action']=='delete' and !empty($_GET['id'])){
	$id=$_GET['id'];
	$id2=$_GET['id2'];
	mysqli_query($con,"delete from himpunan where id_himpunan='".$id."'");
	exit("<script>location.href='?hal=data_himpunan&kriteria=".$id2."';</script>");
}

?>
 
        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:18px;padding:10px 0 10px 0 ">UPDATE DATA HIMPUNAN</div>
		<form action="" name="" method="post">
		<input name="action" type="hidden" value="<?php echo $action;?>">
		<input name="id" type="hidden" value="<?php echo $id;?>">
		<input name="id2" type="hidden" value="<?php echo $id2;?>">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td width="120">Nama Kriteria</td>
			<td><strong><?php echo $kriteria;?></strong></td>
		  </tr>
		  <tr>
			<td>Nama Himpunan</td>
			<td><input name="nama" type="text" size="40" value="<?php echo $nama;?>"> <em>harus diisi</em></td>
		  </tr>
		  <tr>
			<td>Nilai</td>
			<td><input name="nilai" type="text" size="10" value="<?php echo $nilai;?>"> </td>
		  </tr>
		  <tr>
			<td></td>
			<td><input name="simpan" type="submit" value="Simpan"> <input name="batal" type="button" onClick="location.href='?hal=data_himpunan&kriteria=<?php echo $id2;?>';" value="Batal"></td>
		  </tr>
		</table>
		</form>


    	</div>
