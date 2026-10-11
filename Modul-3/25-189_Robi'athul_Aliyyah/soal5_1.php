<?php
$dataMahasiswa = [
    ["Alex", "220401", "0812345678"],
    ["Bianca", "220402", "0812345687"],
    ["Candice", "220403", "0812345665"]
];

$dataBaru = [
    ["Daniel", "220404", "0812345601"],
    ["Ethan", "220405", "0812345602"],
    ["Fiona", "220406", "0812345603"],
    ["Grace", "220407", "0812345604"],
    ["Hendra", "220408", "0812345605"]
];

echo "Data Awal: ";
echo "<br>";
echo "students = ";
foreach ($dataMahasiswa as $mhs) {
    echo '("' . $mhs[0] . '", "' . $mhs[1] . '", "' . $mhs[2] . '"),<br>';
}
echo "<br>";
$semuaMahasiswa = array_merge($dataMahasiswa, $dataBaru);
echo "Data Setelah Ditambah 5 Data Lain: ";
echo "<br>";
echo "students = (";

foreach ($semuaMahasiswa as $mhs) {
    echo '("' . $mhs[0] . '", "' . $mhs[1] . '", "' . $mhs[2] . '"),<br>';
}

echo ")";
?>
<br></br>
<table border="1">
    <tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
    </tr>
    <?php foreach ($semuaMahasiswa as $mhs): ?>
    <tr>
        <td><?php echo $mhs[0]; ?></td>
        <td><?php echo $mhs[1]; ?></td>
        <td><?php echo $mhs[2]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>