<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
echo "weight = ";
foreach ($weight as $nama => $berat) {
	echo "\"$nama\" => \"$berat\", ";
}
echo "<br>";
$carivalue = array_values($weight);
echo "Data Kedua : " . $carivalue[1];
?>
