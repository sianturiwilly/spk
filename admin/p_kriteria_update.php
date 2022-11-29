<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}
$nama='';
$atribut='';
$bobot='';
if(isset($_POST['simpan'])){
	$nama=$_POST['nama'];
	$atribut=$_POST['atribut'];
	$bobot=$_POST['bobot'];
	$atribut='benefit';
	$bobot=30;
	
	if(empty($_POST['nama']) ){
		echo "<script>window.alert('Kolom bertanda \'harus diisi\' tidak boleh kosong.');</script>";
	}else{
		if($_POST['action']=='new'){
			$q="insert into kriteria(nama,atribut,bobot) values('".$_POST['nama']."','benefit','".$_POST['bobot']."')";
			mysqli_query($con,$q);
		}
		if($_POST['action']=='edit'){
			$q="update kriteria set nama='".$_POST['nama']."',atribut='".$_POST['atribut']."',bobot='".$_POST['bobot']."' where id_kriteria='".$_POST['id']."'";
			mysqli_query($con,$q);
		}
		exit("<script>location.href='?hal=data_kriteria';</script>");
	}
}

$action=$_GET['action'];

if($_GET['action']=='edit' and !empty($_GET['id'])){
	$id=$_GET['id'];
	$q=mysqli_query($con,"select * from kriteria where id_kriteria='".$id."' order by id_kriteria asc");
	if(mysqli_num_rows($q)>0){
		$h=mysqli_fetch_array($q);
		$nama=$h['nama'];
		$atribut=$h['atribut'];
		$bobot=$h['bobot'];
	}
}

if($_GET['action']=='delete' and !empty($_GET['id'])){
	$id=$_GET['id'];
	mysqli_query($con,"delete from kriteria where id_kriteria='".$id."'");
	exit("<script>location.href='?hal=data_kriteria';</script>");
}

?>
 
        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:18px;padding:10px 0 10px 0 ">UPDATE DATA KRITERIA</div>
		<form action="" name="" method="post">
		<input name="action" type="hidden" value="<?php echo $action;?>">
		<input name="id" type="hidden" value="<?php echo $id;?>">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td width="120">Nama Kriteria</td>
			<td><input name="nama" type="text" size="40" value="<?php echo $nama;?>"> <em>harus diisi</em></td>
		  </tr>
		 
		  <tr>
			<td></td>
			<td><input name="simpan" type="submit" value="Simpan"> <input name="batal" type="button" onClick="location.href='?hal=data_kriteria';" value="Batal"></td>
		  </tr>
		</table>
		</form>


    	</div>
