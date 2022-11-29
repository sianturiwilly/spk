<?php



$host = "localhost";
$user = "root";
$pass = "";
$db ="spk";
$koneksi = mysql_connect($host, $user, $pass);
if (!$koneksi) {
echo "Koneksi ke server tidak berhasil";
};
$database = mysql_select_db($db);
if (!$database) {
echo "Koneksi ke database tidak berhasil";
}
mysql_select_db($db) or die ("Database not Found !");
//kalian pasti sudah tau fungsi ini, fungsi ini digunakan untuk membuat koneksi ke database



include ('class.ezpdf.php');

//Pengaturan kertas untuk saat ini tipe kertas A4
$pdf =& new Cezpdf('A4','portrait');


		// Atur margin
		$pdf->ezSetCmMargins(1, 3, 3, 3);

		$pdf->addObject($all, 'all');
		$pdf->closeObject();
		
		//baris kode dibawah ini digunakan untuk mencetak info toko dalam pdf

		$pdf->ezText('LAPORAN PENILAIAN CALON KARYAWAN', 15, array('justification' => 'center'));
		$pdf->ezText('', 15, array('justification' => 'center'));
		$pdf->ezSetDy(-10);
		$pdf->ezText('PT. XXX', 12, array('justification' => 'center'));
		$pdf->ezText('Jl. XXX', 10, array('justification' => 'center'));
		
		
		$pdf->ezSetDy(-10); //perintah untuk memberikan jarak spasi paragraf
		
		//$pdf->line(50,1500,2273,1500); //perintah untuk membuat garis atas tabel
					
		$pdf->ezSetDy(-10);
		
		$sql = mysql_query("SELECT * FROM hasilsaw order by rangking asc"); 	 	
		$i = 1;
		while($tampil = mysql_fetch_array($sql)) {
			 
			$data[$i]=array('NO.'=> $tampil['rangking'], 	 	
							'NAMA'=>$tampil['nama'],
							'NILAI'=>$tampil['nilai'],
							'RANGKING'=>$tampil['rangking'],
							'KELAYAKAN'=>$tampil['layak']
							);
								
			$i++;
			
		}
	$pdf->ezText($tampil['id']);
		//perintah untuk mengatur teks yang di cetak pada pdf
		//$pdf->ezStartText(100, 557, 12);
		//$pdf->ezStartText2(500, 557, 12);
		$pdf->ezStartPageNumbers(35, 15, 10);
		$pdf->ezTable($data, '', '', '');
		$pdf->ezSetDy(-50);
		
		$pdf->ezText('NB :', 13, array('justification' => 'LEFT')); //membuat teks NB di bawah tabel
		
		$pdf->ezStream();
?>
