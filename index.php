<?php 
$masa = '20151';
$prog = "Non Pendas";

$styleKTPU = "<style>.ktpu{	font-family:'Lucida Console';	font-size:18px;}</style>";
?>
<!DOCTYPE html>
<html>
<head>
<title>
Kartu Peserta Ujian <?php echo $prog?> Masa <?php echo $masa?>

</title>
</head>
<body>
<?php echo $styleKTPU?>
<script> 
function printContent(el){ 
	var restorepage = document.body.innerHTML; 
	var printcontent = "<?php echo $styleKTPU?>"+"<div class='ktpu'>"+document.getElementById(el).innerHTML+"</div>"; 
	document.body.innerHTML = printcontent; 
	window.print(); 
	document.body.innerHTML = restorepage;
}	 
</script> 

<?php echo "<h1>KTPU $prog MASA UJIAN $masa</h1>";?>
<form method="get">
<input type="text" name="nim" placeholder="Masukan NIM"><input type="submit" value="Cari">
</form>
<hr>
<button onclick="printContent('ktpu')">Print</button> 
<?php



$dir    = $masa;
$files1 = scandir($dir);
$files2 = scandir($dir, 1);
if(isset($_REQUEST['nim'])){
	$ktpu[$_REQUEST['nim']]="TIDAK DITEMUKAN<br>silahkan konfrimasi ke UPBJJ-UT Samarinda terkait ini, bawa serta bukti bayar SPP Anda";
	foreach($files1 as $filenya){
		if(substr( $filenya,0,1)!="." ){
			$myfile = fopen($masa."/".$filenya, "r") or die("Unable to open file!");
			// Output one line until end-of-file
			$nom=0;
			
			$lenTextCek = 33; //LEBATR TEKS YANG DI CEK
			$textCek = ' KARTU TANDA PESERTA UJIAN (KTPU)';//KALIMAT AWAL DARI KTPU
			$posisiNIM = 3; //BERADA BARIS KEBERAPA SETELAH textCEK
			$substrNIM = 17;
			
			$jumCekText = 0;
			$sttCek =0;
			
			
			while(!feof($myfile)) {
			   //echo $nom." - ". substr( fgets($myfile),0,12) . "<br>";
			   $isiFile = fgets($myfile);
			   $cekString = substr($isiFile,0,$lenTextCek );
			   if($cekString == $textCek){
				   $sttCek = '1';
				   $nom++;
				   $rekamKTPU[$nom]=str_replace(" ","&nbsp;",$isiFile)."<br>";
			   }else{
				   $rekamKTPU[$nom].=str_replace(" ","&nbsp;",$isiFile)."<br>";
			   }
			   
			   if($sttCek =='1'){
				$jumCekText++;
				if($jumCekText==$posisiNIM){
					$nim = substr($isiFile,$substrNIM ,9);
					$rekamNIM[$nom]=$nim ;
					$jumCekText=0;
					$sttCek='0';
				}
			   }else{
				   $jumCekText=0;
			   }
			   
			}
			fclose($myfile);
			for($i=1;$i<=$nom;$i++){
				$ktpu[$rekamNIM[$i]]=$rekamKTPU[$i];
			}
		
		
		
		}
	}






	
	
	echo "<div class='ktpu' id='ktpu'>".$ktpu[$_REQUEST['nim']]."</div";
}
?>



</body>
</html>
