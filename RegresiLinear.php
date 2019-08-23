<!doctype>
<html>
	<head>
		<title>Regresi Linear Berganda</title>
		<link rel="icon" type="image/png" href="image/kontak.png">
		<link rel="stylesheet" type="text/css" href="semantic.min.css">
	</head>
	
	<body style="background-image:url(image/seigaiha.png)">
		<?php		
			require_once "Classes/PHPExcel.php";
			session_start();
			if (isset($_POST['unggah']) || (isset($_POST['hitung']))){
				if (isset($_POST['unggah'])) {
					$file_temp_location = $_FILES['pilihFile']['tmp_name'];
					$file_name = $_FILES['pilihFile']['name'];
					$tmpfname = "<sesuai lokasi project>".$file_name; # example location C:\\xampp\\htdocs\\RLB\\upload\\
					
					$_SESSION['temp']=$file_temp_location;
					$_SESSION['name']=$file_name;
					$_SESSION['loc']=$tmpfname;
					
					move_uploaded_file($_SESSION['temp'], $_SESSION['loc']);
				}
				
				$excelReader = PHPExcel_IOFactory::createReaderForFile($_SESSION['loc']);
				$excelObj = $excelReader->load($_SESSION['loc']);
				$worksheet = $excelObj->getSheet(0);
				$lastRow = $worksheet->getHighestRow();
				$data[][] = array();
				$indeksRow = 0;
				$placeholde = 0;
				for ($row = 1; $row <= $lastRow; $row++) {
					$data[0][$indeksRow] = $worksheet->getCell('A'.$row)->getValue();
					$data[1][$indeksRow] = $worksheet->getCell('B'.$row)->getValue();
					$data[2][$indeksRow] = $worksheet->getCell('C'.$row)->getValue();
					$data[3][$indeksRow] = $worksheet->getCell('D'.$row)->getValue();
					$indeksRow++;
				}
				
				function tampilData(){
					global $indeksRow, $data;
					echo "<table class=\"ui celled table\">";
						for($i = 0; $i < $indeksRow; $i++){
							echo "<tr>";
							for($j = 0; $j < 4; $j++){
								echo "<td>";
								echo $data[$j][$i];
								echo "</td>";
							}
							echo "</tr>";
						}
					echo "</table>";
				}
				
				function YFinal($X1, $X2){
					return b0() + ( b1() * $X1 ) + ( b2() * $X2 );
				}

				function b1(){
					return $b1 = (( X2Kuadrat() * X1Y() ) - ( X1X2() * X2Y() )) / (( X1Kuadrat() * X2Kuadrat() ) - ( X1X2() * X1X2() ));
				}

				function b2(){
					return $b2 = (( X1Kuadrat() * X2Y() ) - ( X1X2() * X1Y() )) / (( X1Kuadrat() * X2Kuadrat() ) - ( X1X2() * X1X2() ));
				}

				function b0(){
					return YRataRata() - ( b1() * X1RataRata() ) - ( b2() * X2RataRata() );
				}

				function X2Kuadrat(){
					global $indeksRow, $data;
					$X2Kuadrat = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X2Kuadrat += ($data[2][$i] * $data[2][$i]);
					}
					return $X2Kuadrat;
				}

				function X1Y(){
					global $indeksRow, $data;
					$X1Y = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X1Y += ($data[1][$i] * $data[3][$i]);
					}
					return $X1Y;
				}

				function X1X2(){
					global $indeksRow, $data;
					$X1X2 = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X1X2 += ($data[1][$i] * $data[2][$i]);
					}
					return $X1X2;
				}

				function X2Y(){
					global $indeksRow, $data;
					$X2Y= 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X2Y += ($data[2][$i] * $data[3][$i]);
					}
					return $X2Y;
				}

				function X1Kuadrat(){
					global $indeksRow, $data;
					$X1Kuadrat = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X1Kuadrat += ($data[1][$i] * $data[1][$i]);
					}
					return $X1Kuadrat;
				}

				function YRataRata(){
					global $indeksRow, $data;
					$YRataRata = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$YRataRata += $data[3][$i];
					}
					return $YRataRata/($indeksRow-1);
				}

				function X1RataRata(){
					global $indeksRow, $data;
					$X1RataRata = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X1RataRata += $data[1][$i];
					}
					return $X1RataRata/($indeksRow-1);
				}

				function X2RataRata(){
					global $indeksRow, $data;
					$X2RataRata = 0;
					for($i = 1; $i < $indeksRow; $i++){
						$X2RataRata += $data[2][$i];
					}
					return $X2RataRata/($indeksRow-1);
				}
				
			}			
		?>
		
		</br></br>
		<div class="ui text container" align="center">
	      <h1><b>REGRESI LINEAR BERGANDA</b></h1>
	    </div>
		</br></br></br>
		<div class="ui five column grid">
			<div class="two wide column"></div>
			<div class="five wide column">
				<form class="ui form" action="RegresiLinear.php" method="POST">
					<?php
						if(isset($_POST['hitung']) || isset($_POST['unggah'])){
							tampilData();
						}
						if(isset($_POST['tutup'])){
							$_POST['hitung'] = null;
							session_destroy();
						}
					?>
				</form>
			</div>
 			<div class="two wide column ">
 				<div class="ui vertical divider" style="color:gray;"><i class="code icon"></i></div>
 			</div>
 			<div class="five wide column">
 				<form class="ui form" action="RegresiLinear.php" method="POST" enctype="multipart/form-data">
 					<h4 class="ui dividing header" align="center">Menghitung Jumlah Produksi</h4>
					<div class="field">
						<div class="ui left icon input">
							<input type="file" name="pilihFile">
							<i class="file icon"></i>
						</div>
					</div>
					<div align="center">
						<button class="ui blue button" type="submit" name="unggah">Unggah</button>
					</div>
				</form>
				<form class="ui form" action="RegresiLinear.php" method="POST" enctype="multipart/form-data">
 					<div class="field">
 						<div class="ui left icon input">
							<input name="x1" type="text" placeholder="Masukan Jumlah Permintaan (X1)" value="<?php 
								global $x1, $placeholde;
								if ( $placeholde != 0 || isset($_POST['hitung'])){
									echo $_POST['x1'];
								}
							?>">
							<i class="pencil icon"></i>
						</div>
					</div>
					<div class="field">
 						<div class="ui left icon input">
							<input name="x2" type="text" placeholder="Masukan Jumlah Sisa (X2)" value="<?php 
								global $x2, $placeholde;
								if ( $placeholde != 0 || isset($_POST['hitung'])){
									echo $_POST['x2'];
								}
							?>">
							<i class="pencil icon"></i>
						</div>
					</div>
				    <div class="field">
				    	<div class="ui left icon input">
				      		<input name="y" type="text" placeholder="Jumlah Produksi (Y)" value="<?php 
									global $placeholde;
									if ( isset($_POST['hitung']) ){
										$x1 = $_POST['x1'];
										$x2 = $_POST['x2'];
										echo number_format(YFinal($x1, $x2));
										$placeholde++;
									}
								?>" disabled>
				      		<i class="idea icon"></i>
				      	</div>
				    </div>
					<div align="center">
						<button class="ui blue button" type="submit" name="hitung">Hitung</button>
						<button class="ui red button" type="submit" name="tutup">Tutup</button>
					</div>
 				</form>
 			</div>
 		</div>
	</body>
</html>