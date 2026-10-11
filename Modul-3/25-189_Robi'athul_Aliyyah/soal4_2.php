<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
print_r($weight);

echo "<br>";
echo "<br>";

$key = array_keys($weight);
for($i = 0; $i < count($key); $i++) {
	$nama = $key[$i];
	$value = $weight[$nama];

	echo $nama . " is " . $value . " kg. <br>";
}

?>

