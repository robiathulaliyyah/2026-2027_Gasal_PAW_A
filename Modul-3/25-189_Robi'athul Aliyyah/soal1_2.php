<?php
// soal 1.1
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");
echo "fruits = ";
foreach ($fruits as $b) {
	echo $b . ", ";
}
echo "<br>";

echo "Nilai dengan indeks tertinggi: " . $fruits[array_key_last($fruits)];

echo "<br>";
echo "<br>";

// SOAL 1.2
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo "Data Blueberry dihapus";
unset($fruits[1]);
echo "<br>";
echo "fruits = ";
foreach ($fruits as $b) {
	echo $b . ", ";
}
echo "<br>";

echo "Nilai dengan indeks tertinggi: " . $fruits[array_key_last($fruits)];
?>