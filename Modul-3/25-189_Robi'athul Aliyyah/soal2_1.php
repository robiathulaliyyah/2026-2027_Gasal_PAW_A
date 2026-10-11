<?php
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

$indeks = array_key_last($fruits);
unset($fruits[2]);
print_r($fruits);
echo "<br>";
echo "Nilaii dengan indeks tertinggi: " . $fruits[$indeks];