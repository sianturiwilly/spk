<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}

if(isset($_POST['new'])){
	session_unregister('ANALISA_KRITERIA');
	exit("<script>location.href='?hal=analisa';</script>");
}

# baca jumlah kriteria
$jumlah_kriteria=mysqli_num_rows(mysqli_query($con,"select * from kriteria"));
# baca jumlah alternatif
$jumlah_alternatif=mysqli_num_rows(mysqli_query($con,"select * from alternatif"));

# baca data alternatif
$alternatif=array();
$title='';
$q=mysqli_query($con,"select * from alternatif order by nama");
while($h=mysqli_fetch_array($q)){
	$alternatif[]=array($h['id_alternatif'],$h['nim'],$h['nama']);
	$title.='<td align="center" width="240">'.strtoupper($h['nama']).'</td>';
}

# baca data kriteria dan nilai bobot dari form input analisa
$kriteria=array();
$q=mysqli_query($con,"select * from kriteria");
while($h=mysqli_fetch_array($q)){
	$kriteria[]=array($h['id_kriteria'],$h['nama'],$h['atribut'],$h['bobot']);
}

$no=0;
$daftar='<td width="40">NO</td><td width="100">NO. REGISTRASI</td><td width="150">NAMA</td>';
for($i=0;$i<count($kriteria);$i++){
	$daftar.='<td>'.$kriteria[$i][1].'</td>';
}
$daftar='<tr>'.$daftar.'</tr>';
for($i=0;$i<count($alternatif);$i++){
	$no++;
	$daftar.='<tr><td>'.$no.'</td><td>'.$alternatif[$i][1].'</td><td>'.$alternatif[$i][2].'</td>';
	for($ii=0;$ii<count($kriteria);$ii++){
		$q=mysqli_query($con,"select himpunan.nama from klasifikasi inner join himpunan on klasifikasi.id_himpunan=himpunan.id_himpunan where klasifikasi.id_alternatif='".$alternatif[$i][0]."' and himpunan.id_kriteria='".$kriteria[$ii][0]."'");
		$h=mysqli_fetch_array($q);
		$himpunan=$h['nama'];
		$daftar.='<td>'.$himpunan.'</td>';
	}
	$daftar.='</tr>';
}

$no=0;
$daftar_1='<td width="40">NO</td><td width="100">NO. REGISTRASI</td><td width="150">NAMA</td>';
for($i=0;$i<count($kriteria);$i++){
	$daftar_1.='<td>'.$kriteria[$i][1].'</td>';
}
$daftar_1='<tr>'.$daftar_1.'</tr>';
for($i=0;$i<count($alternatif);$i++){
	$no++;
	$daftar_1.='<tr><td>'.$no.'</td><td>'.$alternatif[$i][1].'</td><td>'.$alternatif[$i][2].'</td>';
	for($ii=0;$ii<count($kriteria);$ii++){
		$q=mysqli_query($con,"select himpunan.nilai from klasifikasi inner join himpunan on klasifikasi.id_himpunan=himpunan.id_himpunan where klasifikasi.id_alternatif='".$alternatif[$i][0]."' and himpunan.id_kriteria='".$kriteria[$ii][0]."'");
		$h=mysqli_fetch_array($q);
		$nilai=$h['nilai'];
		# catat nilai himpunan ke dalam matriks
		$matriks_x[$i+1][$ii+1]=$nilai;
		$daftar_1.='<td>'.$nilai.'</td>';
	}
	$daftar_1.='</tr>';
}

# NORMALISASI 1
$no=0;
$daftar_2='<td width="40">NO</td><td width="100">NO. REGISTRASI</td><td width="150">NAMA</td>';
for($i=0;$i<count($kriteria);$i++){
	$daftar_2.='<td>'.$kriteria[$i][1].'</td>';
}
$daftar_2='<tr>'.$daftar_2.'</tr>';
for($i=0;$i<count($alternatif);$i++){
	$no++;
	$daftar_2.='<tr><td>'.$no.'</td><td>'.$alternatif[$i][1].'</td><td>'.$alternatif[$i][2].'</td>';
	for($ii=0;$ii<count($kriteria);$ii++){
		$arr='';
		for($j=0;$j<count($alternatif);$j++){ # alternatif
			$arr[]=$matriks_x[$j+1][$ii+1];
		}
		if($kriteria[$ii][2]=='benefit'){
			if($matriks_x[$i+1][$ii+1]>0){$jml=$matriks_x[$i+1][$ii+1]/max($arr);}else{$jml=0;}
		}else{
			if(min($arr)>0){$jml=min($arr)/$matriks_x[$i+1][$ii+1];}else{$jml=0;}
		}
		$matriks_1[$i+1][$ii+1]=round($jml,3);
		$daftar_2.='<td>'.round($jml,3).'</td>';
	}
	$daftar_2.='</tr>';
}

// NORMALISASI 2
for($i=0;$i<count($alternatif);$i++){
	$jml=0;
	for($ii=0;$ii<count($kriteria);$ii++){
		$jml=$jml + ($kriteria[$ii][3]*$matriks_1[$i+1][$ii+1]);
	}
	$hasil[]=array(round($jml,3),$alternatif[$i][0]);
}
sort($hasil);
for($i=count($hasil)-1;$i>=0;$i--){
	$rank=count($hasil)-$i;
	$hasil_akhir[$hasil[$i][1]]=array($hasil[$i][0],$rank);
}


?>
<div style="font-size:18px;padding:10px 0 10px 0 ">PENEMPATAN CALON TKI</div>
		<div style="font-size:12px;padding:10px 0 10px 0 ">Pencarian Nama Calon TKI </div>
	<form action="<?php $_server['php_self'] ?>" method="post" name="pencarian" id="pencarian">  
		  <input type="text" name="search" id="search">  
		  <input type="submit" name="submit" id="submit" value="CARI">  
	</form>  

	<?php
	
$no=0;
$daftar_4='<td width="40">NO</td><td width="200">NAMA</td><td>NILAI SAW</td><td width="70">RANGKING</td><td width="200">PENEMPATAN</td>';
$daftar_3='<tr>'.$daftar_3.'</tr>';
$q="delete from hasil_penempatan";
		$q=mysqli_query($con,$q);
	

for($i=0;$i<count($alternatif);$i++){
	$no++;
	$daftar_3.='<tr><td>'.$no.'</td><td>'.$alternatif[$i][1].'</td><td>'.$alternatif[$i][2].'</td><td>'.$hasil_akhir[$alternatif[$i][0]][0].'</td><td>'.$hasil_akhir[$alternatif[$i][0]][1].'</td></tr>';
	
	if ($hasil_akhir[$alternatif[$i][0]][1] <= 5){
		$penempatan="Housekeeper";
	}
	elseif($hasil_akhir[$alternatif[$i][0]][1] >= 5 && $hasil_akhir[$alternatif[$i][0]][1]  <= 10){
		$penempatan="Babysitter";
		}
	elseif($hasil_akhir[$alternatif[$i][0]][1] >= 10 && $hasil_akhir[$alternatif[$i][0]][1]  <= 15){
		$penempatan="Care taker";
		}
	elseif($hasil_akhir[$alternatif[$i][0]][1] >= 15 && $hasil_akhir[$alternatif[$i][0]][1]  <= 20){
		$penempatan="Family driver";
		}
	elseif($hasil_akhir[$alternatif[$i][0]][1] >= 20 && $hasil_akhir[$alternatif[$i][0]][1]  <= 25){
		$penempatan="Gardener";
	}
	else{
		$penempatan="Tidak Lolos Seleksi";
	}
	$y="insert into hasil_penempatan(nama,nilai,rangking, penempatan) values ('".$alternatif[$i][2]."','".$hasil_akhir[$alternatif[$i][0]][0]."','".$hasil_akhir[$alternatif[$i][0]][1]."','".$penempatan."') ";
			
			$y=mysqli_query($con,$y);
}

$daftar_4.='';

$search=$_POST['search'];
if($_POST['search'] == ""){
//$q="select * from alternatif   order by nama";
$q="select * from hasil_penempatan order by rangking asc";

}
else{

	//$q="select * from alternatif WHERE nama LIKE '%$search%' order by nama";
	$q="select * from hasil_penempatan WHERE nama LIKE '%$search%' order by rangking asc";
}

//$q="select * from hasil order by rangking asc";
		$q=mysqli_query($con,$q);	
	$no=0;	
while($h=mysqli_fetch_array($q)){
	$no++;
	if ($h['rangking'] <= 5){
		$penempatan="Housekeeper";
		$daftar_4.='<tr ><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}
	elseif($h['rangking'] >= 5 && $h['rangking'] <= 10){
		$penempatan="Babysitter";
		$daftar_4.='<tr><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}
	elseif($h['rangking'] >= 10 && $h['rangking'] <= 15){
		$penempatan="Care taker";
		$daftar_4.='<tr ><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}
	elseif($h['rangking'] >= 15 && $h['rangking'] <= 20){
		$penempatan="Family driver";
		$daftar_4.='<tr><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}
	elseif($h['rangking'] >= 20 && $h['rangking'] <= 25){
		$penempatan="Gardener";
		$daftar_4.='<tr ><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}
	else{
		$penempatan="Tidak Lolos Seleksi";
		$daftar_4.='<tr ><td>'.$no.'</td><td>'.$h['nama'].'</td><td>'.$h['nilai'].'</td><td>'.$h['rangking'].'</td><td>'.$h['penempatan'].'</td></tr>';
	}

	
	

}

?>

        <div style="font-family:Arial;font-size:12px;padding:3px ">
		
		<div style="overflow-x">
		<table width="<?php echo (340+($jumlah_kriteria*60));?>" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <?php //echo $daftar_2;?>
		</table>
		</div>
		<br /><br />
		<div style="overflow-x:scroll;width:640px">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		  <?php echo $daftar_4;?>
		</table>
		</div>
		<!--</div>-->

    	</div>
