<?php
$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
$praktikum = ["JARKOM", "PAW"];

for ($i=0; $i< count($matkul); $i++) {
	// mengecek matakuliah apakah ada di praktikum
	if (in_array($matkul[$i], $praktikum)) {
		echo "Saya sedang mengambil matkul " . $matkul[$i] . " termasuk praktikumnya";
		echo "<br>";
	}elseif ($i == 6 || $i == 7) {
		echo "Saya belum mengambil matkul " . $matkul[$i];
		echo "<br>";
	}else {
		echo "Saya sudah mengambil matkul " . $matkul[$i] . " semester lalu";
		echo "<br>";
	}
}