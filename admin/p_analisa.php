<?php

if(!isset($_SESSION['LOGIN_username'])){
	exit("<script>location.href='./';</script>");
}

if(isset($_POST['submit'])){
	unset($_SESSION['ANALISA_KRITERIA']);
	$q=mysqli_query($con,"select * from kriteria");
	while($h=mysqli_fetch_array($q)){
		$_SESSION['ANALISA_KRITERIA'][$h['id_kriteria']]=$_POST['txt_bobot_'.$h['id_kriteria']];
	}
	exit("<script>location.href='?hal=hasil';</script>");
}

$bobot[]=array(0,'Sangat Rendah');
$bobot[]=array(2.5,'Rendah');
$bobot[]=array(5,'Cukup');
$bobot[]=array(7.5,'Tinggi');
$bobot[]=array(10,'Sangat Tinggi');

$no=0;
$daftar_kriteria='';
# menampilkan kriteria beserta data himpunannya
$q=mysqli_query($con,"select * from kriteria");
while($h=mysqli_fetch_array($q)){
	$no++;
	$list_bobot='';
	for($i=0;$i<count($bobot);$i++){
		if(isset($_SESSION['ANALISA_KRITERIA'][$h['id_kriteria']]) and $bobot[$i][0]==$_SESSION['ANALISA_KRITERIA'][$h['id_kriteria']]){$s=' selected';}else{$s='';}
		$list_bobot.='<option value="'.$bobot[$i][0].'"'.$s.'>'.$bobot[$i][1].'</option>';
	}
	
	$daftar_kriteria.='
	<tr>
		<td width="160"><strong>C'.$no.'.</strong>&nbsp;&nbsp;&nbsp; '.$h['nama'].'</td>
		<td><select name="txt_bobot_'.$h['id_kriteria'].'" style="width:150px">'.$list_bobot.'</select></td>
	</tr>
	';
}



?>

        <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:18px;padding:10px 0 10px 0 ">ANALISA CTKI</div>
		<br>
		<form action="?hal=analisa" method="post">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" class="tabel_reg">
		<?php echo $daftar_kriteria;?>
		</table>
		<br /><br /><input name="submit" type="submit" value="Submit Analisa &raquo;" />
		</form>
    	</div>
