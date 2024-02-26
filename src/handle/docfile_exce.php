<?php
require_once "helper.php";
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = 'C:\Users\chien\Desktop\Book1.xlsx';
$spreadsheet = IOFactory::load($filePath);

$sheet = $spreadsheet->getSheet(0);

$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
echo "Cột cao nhất: ".$highestColumn;
echo "<br>";
echo "Dòng cao nhất: ".$highestRow;
// Lặp qua từng hàng và cột và hiển thị dữ liệu
$sql = "insert into linhkien(malinhkien, tenlinhkien, chiso, giaban, trangthai) VALUES ";
$values = [];
for ($a = 3; $a <= $highestRow; $a++) {
    for ($colASII = 65; $colASII <= 69; $colASII++) {
        $col = chr($colASII);
        $cellValue = $sheet->getCell($col . $a)->getValue();
        array_push($values, $cellValue??NULL);
    }
    $sql .= "(?, ?, ?, ?, ?), ";
    echo "</tr>";
}
$sql = substr($sql, 0, -2);
echo $sql;
echo count($values);
print_r($values);
$result = query_input($sql, $values);
echo $result;
?>