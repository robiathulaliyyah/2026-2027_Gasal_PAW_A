<?php

// array_push()
echo "Array awal (\"A\")<br>";

$arrayAwal = ["A"];
array_push($arrayAwal, "B");

echo "Hasil array_push: " . implode(" ", $arrayAwal) . "<br><br>";


// array_merge()
echo "Array awal (\"A\", \"B\") digabung dengan (\"C\")<br>";

$arrayPertama = ["A", "B"];
$arrayKedua = ["C"];
$gabungan = array_merge($arrayPertama, $arrayKedua);

echo "Hasil array_merge: " . implode(" ", $gabungan) . "<br><br>";


// array_values()
echo "Array awal (\"x\" => 1, \"y\" => 2)<br>";

$arrayAsosiatif = ["x" => 1, "y" => 2];
$arrayNilai = array_values($arrayAsosiatif);

echo "Hasil array_values: " . implode(" ", $arrayNilai) . "<br><br>";


// array_search()
echo "Mencari \"B\" pada array (\"A\", \"B\", \"C\")<br>";

$arrayHuruf = ["A", "B", "C"];
$indeksHuruf = array_search("B", $arrayHuruf);

echo "Hasil array_search: " . $indeksHuruf . "<br><br>";


// array_filter()
echo "Array awal (0, 1, false, 2, \"\", 3, \"array\")<br>";

$arrayCampuran = [0, 1, false, 2, "", 3, "array"];
$arrayHasilFilter = array_filter($arrayCampuran);

echo "Hasil array_filter: " . implode(" ", $arrayHasilFilter) . "<br><br>";


// sort() dan rsort()
echo "Array awal (3, 1, 2)<br>";

$arrayUrutNaik = [3, 1, 2];
sort($arrayUrutNaik);

echo "Hasil sort: " . implode(" ", $arrayUrutNaik) . "<br>";

$arrayUrutTurun = [3, 1, 2];
rsort($arrayUrutTurun);

echo "Hasil rsort: " . implode(" ", $arrayUrutTurun) . "<br><br>";


// Fungsi untuk menampilkan array asosiatif
function print_assoc($array) {
    $daftarData = [];

    foreach ($array as $key => $val) {
        $daftarData[] = "$key=>$val";
    }

    return implode(", ", $daftarData);
}


// Data awal
$dataUmur = [
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43
];

echo "Array awal (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";


// asort() mengurutkan nilai secara naik
$arr_asort = $dataUmur;
asort($arr_asort);

echo "Hasil asort: " . print_assoc($arr_asort) . "<br>";


// ksort() mengurutkan key secara naik
$arr_ksort = $dataUmur;
ksort($arr_ksort);

echo "Hasil ksort: " . print_assoc($arr_ksort) . "<br>";


// arsort() mengurutkan nilai secara menurun
$arr_arsort = $dataUmur;
arsort($arr_arsort);

echo "Hasil arsort: " . print_assoc($arr_arsort) . "<br>";


// krsort() mengurutkan key secara menurun
$arr_krsort = $dataUmur;
krsort($arr_krsort);

echo "Hasil krsort: " . print_assoc($arr_krsort) . "<br>";

?>
