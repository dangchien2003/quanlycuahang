<?php
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

echo "<table border='1'>";
// Lặp qua từng hàng và cột và hiển thị dữ liệu
for ($a = 1; $a <= $highestRow; $a++) {
    echo "<tr>";
    for ($colASII = 65; $colASII <= 69; $colASII++) {
        $col = chr($colASII);
        $cellValue = $sheet->getCell($col . $a)->getValue();
        echo "<td>{$cellValue}</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>