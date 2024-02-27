<?php
// Đường dẫn đến thư viện PHPExcel
require '../../vendor/autoload.php'; // Điều chỉnh đường dẫn tương ứng

use PhpOffice\PhpSpreadsheet\IOFactory;

// Đường dẫn đến file Excel chứa ảnh
$file_path = "C:\Users\chien\Desktop\Book1.xlsx"; // Điều chỉnh đường dẫn tương ứng

// Đọc file Excel
$spreadsheet = IOFactory::load($file_path);
$worksheet = $spreadsheet->getActiveSheet();

// Lấy ảnh từ ô bảng tính (ví dụ: ô A1)
$image = $worksheet->getDrawingCollection()[0]; // Giả sử ảnh đầu tiên được đặt trong ô A1

// Lưu dữ liệu của ảnh thành một file PNG mới
$image_data = $image->getImageResource();
imagepng($image_data, 'path/to/save/new_image.png'); // Điều chỉnh đường dẫn tới nơi bạn muốn lưu trữ tập tin PNG mới
?>