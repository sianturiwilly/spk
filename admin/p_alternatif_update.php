<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if(empty($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}
$nim='';
$nama='';
$jurusan='';
$himpunan=array();
$kriteria=array();
$q=mysqli_query($con,"select * from kriteria order by id_kriteria asc");
while($h=mysqli_fetch_array($q)){
	$kriteria[]=array($h['id_kriteria'],$h['nama']);
}

if(isset($_POST['simpan'])){
	$nim=$_POST['nim'];
	$nama=$_POST['nama'];
	$jurusan=$_POST['jurusan'];
	$isi=true;
	for($i=0;$i<count($kriteria);$i++){
		$himpunan[]=$_POST['kriteria_'.$kriteria[$i][0]];
		if(empty($_POST['kriteria_'.$kriteria[$i][0]])){
			$isi=false;
		}
	}
	//if(empty($_POST['nim']) or empty($_POST['nama']) or empty($_POST['jurusan']) or $isi==false){
	if(empty($_POST['nim']) or empty($_POST['nama']) or $isi==false){
		echo "<script>window.alert('Kolom bertanda \'harus diisi\' tidak boleh kosong.');</script>";
	}else{
		if($_POST['action']=='new'){
			if(mysqli_num_rows(mysqli_query($con,"select * from alternatif where nim='".$_POST['nim']."'"))>0){
				echo "<script>window.alert('NIM yang anda masukan sudah terdaftar sebelumnya. Silahkan gunakan NIM yang lain.');</script>";
			}else{
				$q="insert into alternatif(nim, nama,jurusan) values('".$_POST['nim']."','".$_POST['nama']."', '".$_POST['jurusan']."')";
				mysqli_query($con,$q);
				$id_alternatif=mysqli_insert_id($con);
				for($i=0;$i<count($kriteria);$i++){
					mysqli_query($con,"insert into klasifikasi(id_alternatif, id_himpunan) values('".$id_alternatif."','".$_POST['kriteria_'.$kriteria[$i][0]]."')");
				}
				exit("<script>location.href='?hal=data_alternatif';</script>");
			}
		}
		if($_POST['action']=='edit'){
			$q=mysqli_query($con,"select nim from alternatif where id_alternatif='".$_POST['id']."'");
			$h=mysqli_fetch_array($q);
			$nim_tmp=$h['nim'];
			if(mysqli_num_rows(mysqli_query($con,"select * from alternatif where nim='".$_POST['nim']."' and nim<>'".$nim_tmp."'"))>0){
				echo "<script>window.alert('NIM yang anda masukan sudah terdaftar sebelumnya. Silahkan gunakan NIM yang lain.');</script>";
			}else{
				$q="update alternatif set nim='".$_POST['nim']."', nama='".$_POST['nama']."',jurusan='".$_POST['jurusan']."' where id_alternatif='".$_POST['id']."'";
				mysqli_query($con,$q);
				mysqli_query($con,"delete from klasifikasi where id_alternatif='".$_POST['id']."'");
				for($i=0;$i<count($kriteria);$i++){
					mysqli_query($con,"insert into klasifikasi(id_alternatif, id_himpunan) values('".$_POST['id']."','".$_POST['kriteria_'.$kriteria[$i][0]]."')");
				}
				exit("<script>location.href='?hal=data_alternatif';</script>");
			}
		}
		
	}
}

$action=$_GET['action'];

if($_GET['action']=='edit' and !empty($_GET['id'])){
	$id=$_GET['id'];
	$q=mysqli_query($con,"select * from alternatif where id_alternatif='".$id."'");
	if(mysqli_num_rows($q)>0){
		$h=mysqli_fetch_array($q);
		$nim=$h['nim'];
		$nama=$h['nama'];
		$jurusan=$h['jurusan'];
		$q=mysqli_query($con,"select * from klasifikasi where id_alternatif='".$id."'");
		while($h=mysqli_fetch_array($q)){
			$himpunan[]=$h['id_himpunan'];
		}
	}
}

if($_GET['action']=='delete' and !empty($_GET['id'])){
	$id=$_GET['id'];
	mysqli_query($con,"delete from alternatif where id_alternatif='".$id."'");
	exit("<script>location.href='?hal=data_alternatif';</script>");
}
$daftar_kriteria='';
for($i=0;$i<count($kriteria);$i++){
	$list_himpunan='<option value=""></option>';
	$qq=mysqli_query($con,"select * from himpunan where id_kriteria='".$kriteria[$i][0]."' order by id_kriteria asc, id_himpunan asc");
	
	while($hh=mysqli_fetch_array($qq)){
		if(in_array($hh['id_himpunan'],$himpunan)){$s='selected';}else{$s='';}
		$list_himpunan.='<option value="'.$hh['id_himpunan'].'" '.$s.'>'.$hh['nama'].'</option>';
	}
	$daftar_kriteria.='
	  <tr>
		<td>'.$kriteria[$i][1].'</td>
		<td><select name="kriteria_'.$kriteria[$i][0].'">'.$list_himpunan.'</select> <em>harus diisi</em></td>
	  </tr>
	';
}


?>
 
        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:18px;padding:10px 0 10px 0 ">UPDATE DATA CALON KARYAWAN</div>
		<form action="" name="" method="post">
		<input name="action" type="hidden" value="<?php echo $action;?>">
		<input name="id" type="hidden" value="<?php echo $id;?>">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <tr>
			<td width="120">NO. REGISTRASI</td>
			<td><input name="nim" type="text" size="40" value="<?php echo $nim;?>"> <em>harus diisi</em></td>
		  </tr>
		  <tr>
			<td>Nama Calon TKI</td>
			<td><input name="nama" type="text" size="40" value="<?php echo $nama;?>"> <em>harus diisi</em></td>
		  </tr>
		  <!--
		  <tr>
			<td>PENEMPATAN CALON TKI</td>
			<td><select name="jurusan">
			<option value="0"></option>
			 <option value="Housekeeper" <?php if (!empty($jurusan) && $jurusan == 'Housekeeper')  echo 'selected = "selected"'; ?>>Housekeeper</option>
			 <option value="Babysitter" <?php if (!empty($jurusan) && $jurusan == 'Babysitter')  echo 'selected = "selected"'; ?>>Babysitter</option>
			 <option value="Care taker" <?php if (!empty($jurusan) && $jurusan == 'Care taker')  echo 'selected = "selected"'; ?>>Care taker</option>
			 <option value="Family driver" <?php if (!empty($jurusan) && $jurusan == 'Family driver')  echo 'selected = "selected"'; ?>>Family driver</option>
			 <option value="Gardener" <?php if (!empty($jurusan) && $jurusan == 'Gardener')  echo 'selected = "selected"'; ?>>Gardener</option>
			</select> <em>harus diisi</em></td>
		  </tr>
		  //-->
		  <?php echo $daftar_kriteria;?>
		  <tr>
			<td></td>
			<td><input name="simpan" type="submit" value="Simpan"> <input name="batal" type="button" onClick="location.href='?hal=data_alternatif';" value="Batal"></td>
			
		  </tr>
		</table>
		</form>


    	</div>
